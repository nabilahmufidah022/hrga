<?php
 namespace Ppl\Hrga\Models;

use Winter\Storm\Database\Model;
use Backend\Models\User;
use Backend\Facades\BackendAuth;

class Absence extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    public $table = 'absensi';

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'nama',
        'unit_kerja',
        'waktu_absen',
        'status_kehadiran',
        'bukti_timestamp',
        'bukti_kehadiran'
    ];

    public $attachOne = [
        'bukti_timestamp' => ['System\Models\File'],
        'import_file' => ['System\Models\File']
    ];

    public $rules = [
    'user_id' => 'required',
    'unit_kerja' => 'required',
    'waktu_absen' => 'required|date',
    'status_kehadiran' => 'required',
    // bukti_timestamp dihapus dari rules default
];

public function beforeValidate()
{
    if (!$this->user_id && BackendAuth::check()) {
        $this->user_id = BackendAuth::getUser()->id;
    }

    // Dynamic validation untuk bukti_timestamp
    if (!$this->exists) {
        // Record baru - wajib upload bukti_timestamp
        $this->rules['bukti_timestamp'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
    } else {
        // Record existing - tidak wajib kecuali user upload file baru
        if (request()->hasFile('Absence[bukti_timestamp]') || input('Absence.bukti_timestamp')) {
            $this->rules['bukti_timestamp'] = 'nullable|image|mimes:jpeg,png,jpg|max:2048';
        }
        // Jika tidak ada file baru, tidak ada validasi untuk bukti_timestamp
    }

    if (input('bukti_timestamp')) {
        $this->bukti_timestamp = input('bukti_timestamp');
    }
}

    public $customMessages = [
        'user_id.required' => 'Nama wajib diisi',
        'unit_kerja.required' => 'Unit Kerja wajib diisi',
        'waktu_absen.required' => 'Tanggal Absensi wajib diisi',
        'waktu_absen.date' => 'Format Tanggal Absensi tidak valid',
        'status_kehadiran.required' => 'Status Kehadiran wajib diisi',
        'bukti_timestamp.required' => 'Bukti timestamp harus diunggah',
        'bukti_timestamp.image' => 'File harus berupa gambar',
        'bukti_timestamp.mimes' => 'Format file harus JPG, JPEG, atau PNG',
        'bukti_timestamp.max' => 'Ukuran file tidak boleh lebih dari 2MB'
    ];

    protected $dates = [
        'waktu_absen',
        'created_at',
        'updated_at'
    ];

    public $belongsTo = [
        'user' => [User::class, 'key' => 'user_id'],
        'divisi' => [
            \Ppl\Hrga\Models\Division::class,
            'key' => 'unit_kerja',
            'otherKey' => 'id'
        ]
    ];

    public function getNamaAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        if ($this->user) {
            return trim($this->user->first_name . ' ' . $this->user->last_name);
        }
        
        return $value;
    }

    public function getBuktiKehadiranAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        if ($this->bukti_timestamp) {
            return $this->bukti_timestamp->getFileName();
        }
        
        return $value;
    }

    public function getUnitKerjaOptions()
    {
        return [
            'corporate' => 'Corporate Transformation, Renstra & Kepatuhan',
            'sdm' => 'Divisi SDM & Umum',
            'keuangan' => 'Keuangan & Akuntansi',
            'klaim' => 'Klaim & Subrogasi',
            'ti' => 'Koordinator TI',
            'risiko' => 'Manajemen Risiko'
        ];
    }

    public function getStatusKehadiranOptions()
    {
        return [
            'hadir' => 'Hadir',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'cuti' => 'Cuti',
            'tidak hadir' => 'Tidak Hadir'
        ];
    }

    public function getUserIdOptions()
    {
        $user = BackendAuth::getUser();
        if ($user && $user->is_superuser) {
            return User::all()->pluck('full_name', 'id')->toArray();
        }
        return [$user->id => $user->full_name];
    }

   
    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if ($user) {
            $this->user_id = $user->id;
            $this->nama = trim($user->first_name . ' ' . $user->last_name);
        }
    }

    public function beforeUpdate()
    {
        if ($this->isDirty('user_id') && $this->user) {
            $this->nama = trim($this->user->first_name . ' ' . $this->user->last_name);
        }
    }

    public function afterSave()
    {
        $needsUpdate = false;
        
        if ($this->bukti_timestamp && !$this->bukti_kehadiran) {
            $user = BackendAuth::getUser();
            $userName = str_slug($this->nama ?? $user->full_name);
            $timestamp = date('Y-m-d_His');
            $extension = $this->bukti_timestamp->getExtension();
            $newName = $userName . '_' . $timestamp;
            
            $this->bukti_timestamp->rename($newName);
            $this->bukti_kehadiran = $newName . '.' . $extension;
            $needsUpdate = true;
        }
        
        if ($needsUpdate) {
            $this->newQuery()->where('id', $this->id)->update([
                'bukti_kehadiran' => $this->bukti_kehadiran
            ]);
        }
    }

    public function afterFetch()
    {
        if ($this->user && empty($this->nama)) {
            $this->nama = trim($this->user->first_name . ' ' . $this->user->last_name);
        }
        
        if ($this->bukti_timestamp && empty($this->bukti_kehadiran)) {
            $this->bukti_kehadiran = $this->bukti_timestamp->getFileName();
        }
    }

    public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) {
            try {
                if (empty($data['unit_kerja']) || empty($data['waktu_absen']) || empty($data['status_kehadiran'])) {
                    throw new \Exception('Missing required fields');
                }

                $absence = new static;
                $absence->fill([
                    'user_id' => BackendAuth::getUser()->id,
                    'unit_kerja' => $data['unit_kerja'],
                    'waktu_absen' => $data['waktu_absen'],
                    'status_kehadiran' => $data['status_kehadiran']
                ]);
                $absence->save();

            } catch (\Exception $ex) {
                $this->logImportError($row, $ex->getMessage());
            }
        }
    }

    public function exportData($columns, $sessionKey = null)
    {
        $absences = self::all();
        $results = [];

        foreach ($absences as $absence) {
            $results[] = [
                'id' => $absence->id,
                'user_id' => $absence->user_id,
                'nama' => $absence->nama,
                'unit_kerja' => $absence->unit_kerja,
                'waktu_absen' => $absence->waktu_absen,
                'status_kehadiran' => $absence->status_kehadiran,
                'created_at' => $absence->created_at,
                'updated_at' => $absence->updated_at
            ];
        }

        return $results;
    }

    protected function logImportError($row, $message)
    {
        Log::error(sprintf('Row %d failed to import: %s', $row, $message));
    }
}