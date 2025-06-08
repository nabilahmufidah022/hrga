<?php

namespace Ppl\Hrga\Models;

use Winter\Storm\Database\Model;
// use Ppl\Hrga\Models\SickList;
use Ppl\Hrga\Models\Division as MoDivisi;
use Backend\Models\User as BackendUser;

/**
 * sick Model
 */
class Sick extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ppl_hrga_sicks';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
    //    'list' => [
    //         'Ppl\Hrga\Models\SickList',
    //         'key'      => 'form_pengajuan_sakit_id',   // foreign key in SickList
    //         'localKey' => 'form_pengajuan_sakit_id'
    //     ]
    ];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [
        'nama' => [
            BackendUser::class,
            'key' => 'user_id'
        ],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'surat_dokter' => 'System\Models\File'
    ];
    public $attachMany = [];

     public function getJumlahHariAttribute()
    {
        if ($this->tanggal_awal && $this->tanggal_akhir) {
            return $this->tanggal_awal->diffInDays($this->tanggal_akhir) + 1;
        }

        return 0;
    }

//     public function getSuratDokterPathUrlAttribute()
//     {
//         if ($this->surat_dokter_path) {
//             return $this->surat_dokter_path->getPath(); // Or use getUrl() for public URL
//         }
//         return null;
//     }
    
//     public function afterSave()
// {
//     // Automatically create a log entry when a product is created
//     $list = new SickList;
//     $list->form_pengajuan_sakit_id = $this->form_pengajuan_sakit_id;
//     $list->tanggal_awal = $this->tanggal_awal;
//     $list->tanggal_akhir = $this->tanggal_akhir;
//     $list->jumlah_hari = $this->jumlah_hari;
//     $list->nama = $this->nama;
//     $list->save();
// }
//     public function getStatusIdAttribute()
//     {
//         $latestList = $this->list()->latest()->first();

//         if (!$latestList) {
//             return '-';
//         }
    
//         $statusLabels = [
//             '0' => 'Pending',
//             '1' => 'Diterima',
//             '2' => 'Ditolak',
//         ];
    
//         return $statusLabels[$latestList->status_id] ?? 'Tidak Diketahui';
//     }

    public function getDivisiIdOptions($value, $formData)
    {
        // $DivisiData = MoDivisi::get(['id','nama_divisi', 'kode_divisi'])->toArray();
        // $Divisi = [];
        // foreach($DivisiData as $value) {
        //     $Divisi[$value['id']] = $value['kode_divisi']; 
        // }
        // return $Divisi;

        $Divisi_id = MoDivisi::selectRaw("*, concat(kode_divisi,' - ', nama_divisi) as divisi")->lists('divisi', 'id');
        return $Divisi_id;
    }

    public function getKodeDivisiAttribute($value)
    {
        // $divisi = DB::table('merapat_divisi')->join()->where('divisi_id', $id);
        $DivisiData = MoDivisi::where('id','=', $this->divisi_id)->first();
        // dd($DivisiData);
        $nama_divisi = $DivisiData->nama_divisi;
        $kode_divisi = $DivisiData->kode_divisi;

        $dataDivisi = $kode_divisi.' - '.$nama_divisi;

        return $dataDivisi;
        // $Divisi_id = MoDivisi::selectRaw("*, concat(kode_divisi,' - ', nama_divisi) as divisi")->where($this->divisi_id, '=', 'id');
        // // dd($Divisi_id);
        // return $Divisi_id;
    }

}
