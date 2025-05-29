<?php

namespace Ppl\Hrga\Models;

use Winter\Storm\Database\Model;
use Backend\Models\User;
use Backend\Facades\BackendAuth; 

/**
 * Absence Model
 * This model handles employee attendance records
 */
class Absence extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'absensi';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['id'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'user_id',
        'unit_kerja',  // Pastikan ini sesuai dengan nama kolom di database
        'waktu_absen',
        'status_kehadiran',
        'lokasi_absen'
    ];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'user_id' => 'required',
        'unit_kerja' => 'required',
        'waktu_absen' => 'required|date',
        'status_kehadiran' => 'required'
    ];

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
        'waktu_absen',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array Relations
     */
    public $attachOne = [
        'bukti_timestamp' => [\System\Models\File::class]
    ];
    public $hasOne = [];
    public $hasMany = [];
    public $hasOneThrough = [];
    public $hasManyThrough = [];

    public $belongsTo = [
        'user' => [\Backend\Models\User::class, 'key' => 'user_id'],
        'divisi' => [
            \Ppl\Hrga\Models\Division::class, 
            'key' => 'unit_kerja', 
            'otherKey' => 'id'
        ]
    ];

    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachMany = [];

    /**
     * Get dropdown options for user_id field
     */
    public function getUserIdOptions()
    {
        return User::all()->pluck('full_name', 'id')->toArray();
    }

    /**
     * Get dropdown options for unit_kerja field
     */
    public function getUnitKerjaOptions()
    {
        return \Ppl\Hrga\Models\Division::lists('nama_divisi', 'id');
    }
    

    /**
     * Get dropdown options for status_kehadiran field
     */
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

    /**
     * Before create event hook
     * Sets the user_id to the currently authenticated user
     */
    public function beforeValidate()
    {
        // Set user_id to currently logged in user if not already set
        if (!$this->user_id && BackendAuth::check()) {
            $this->user_id = BackendAuth::getUser()->id;
        }
    }

    public function beforeCreate()
    {
        // Set user_id to currently logged in user if not already set
        if (empty($this->user_id) && \BackendAuth::check()) {
            $this->user_id = \BackendAuth::getUser()->id;
        }
    }
}