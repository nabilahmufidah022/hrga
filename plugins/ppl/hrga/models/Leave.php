<?php

namespace Ppl\Hrga\Models;

use Winter\Storm\Database\Model;
use Ppl\Hrga\Models\Division as MoDivisi;
use carbon\Carbon;

/**
 * leave Model
 */
class Leave extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'form_pengajuan_cuti';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['jumlah_recana_cuti'];

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
    protected $appends = ['jumlah_rencana_cuti'];

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
    public $hasMany = [];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = ['lampiran_dokumen'=>\System\Models\File::class];
    public $attachMany = [];

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

    public function getJumlahRencanaCutiAttribute()
    {
      if ($this->tanggal_awal && $this->tanggal_akhir) {
        return $this->tanggal_awal->diffInDays($this-> tanggal_akhir) +1;
      }
      return 0;
    }
}
