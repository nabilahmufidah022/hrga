<?php namespace Ppl\Hrga\Models;

#use Winter\Storm\Database\Model;
use Model;
use Ppl\Hrga\Models\Division as MoDivisi;
use Ppl\Hrga\Models\Position as MoJabatan;

/**
 * personal Model
 */
class Personal extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'datadiri';

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
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [
        'divisi' =>[
            MoDivisi::class,
            'key'=>'id'
        ],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'staff_pics' => \System\Models\File::class,
    ];
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

    public function getJabatanIdOptions($value, $formData)
    {
        $JabatanData = MoJabatan::get(['id','nama_jabatan'])->toArray();
        $Jabatan = [];
        foreach($JabatanData as $value) {
            $Jabatan[$value['id']] = $value['nama_jabatan']; 
        }
        return $Jabatan;

        // $Divisi_id = MoDivisi::selectRaw("*, concat(kode_divisi,' - ', nama_divisi) as divisi")->lists('divisi', 'id');
        // return $Divisi_id;
    }

    public function getKodeJabatanAttribute($value)
    {
        // $divisi = DB::table('merapat_divisi')->join()->where('divisi_id', $id);
        $JabatanData = MoJabatan::where('id','=', $this->jabatan_id)->first();
        // dd($JabatanData);
        $nama_jabatan = $JabatanData->nama_jabatan;

        $dataJabatan = $nama_jabatan;

        return $dataJabatan;
        // $Divisi_id = MoDivisi::selectRaw("*, concat(kode_divisi,' - ', nama_divisi) as divisi")->where($this->divisi_id, '=', 'id');
        // // dd($Divisi_id);
        // return $Divisi_id;
    }

    // public function getKodeJabatanAttribute($value)
    // {
    //     // $divisi = DB::table('merapat_divisi')->join()->where('divisi_id', $id);
    //     $JabatanData = MoJabatan::where('id','=', $this->jabatan_id)->first();
    //     // dd($DivisiData);
    //     $nama_jabatan = $JabatanData->nama_jabatan;
    //     // $kode_divisi = $DivisiData->kode_divisi;

    //     $dataJabatan = $nama_jabatan;

    //     return $dataJabatan;
    //     // $Divisi_id = MoDivisi::selectRaw("*, concat(kode_divisi,' - ', nama_divisi) as divisi")->where($this->divisi_id, '=', 'id');
    //     // // dd($Divisi_id);
    //     // return $Divisi_id;
    // }
}
