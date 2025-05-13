<?php

namespace Ppl\Hrga\Models;


use Carbon\Carbon;
use Winter\Storm\Database\Model;
use Ppl\Hrga\Models\Division as MoDivisi;

/**
 * permission Model
 */
class Permission extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'merapat_izinorder_form';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['jumlah_rencana_izin'];


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
    protected $appends = ['jumlah_rencana_izin'];

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

    public function getJumlahRencanaIzinAttribute()
{
    if ($this->tanggal_awal && $this->tanggal_akhir) {
        return $this->tanggal_awal->diffInDays($this->tanggal_akhir) + 1;
    }

    return 0;
}

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'file_pendukung' => \System\Models\File::class,
    ];
    
    // public function getKodeDivisiAttribute($value)
    // {
    //     $DivisiData = MoDivisi::where('id','=', $this->divisi_id)->first();
    //     // dd($DivisiData);
    //     $nama_divisi = $DivisiData->nama_divisi;
    //     $kode_divisi = $DivisiData->kode_divisi;

    //     $dataDivisi = $kode_divisi.' - '.$nama_divisi;

    //     return $dataDivisi;
    // }
}
