<?php

namespace Ppl\Hrga\Models;

use Model;
use Backend\Models\User as BackendUser;
use Ppl\Hrga\Models\Division as MoDivisi;
use Ppl\Hrga\Models\Device as MoDevice;

/**
 * deviceorder Model
 */
class Deviceorder extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'device_form';

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
        'nama_peminjam' => [
            BackendUser::class,
            'key' => 'backend_user_id'
        ],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
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

    public function getDeviceidOptions($value, $formData)
    {
        $RoomMeetingData = MoDevice::get(['id','nama_perangkat'])->toArray();
        $RoomMeeting = [];
        foreach($RoomMeetingData as $value) {
            $RoomMeeting[$value['id']] = $value['nama_perangkat'];
        }

        return $RoomMeeting;
    }
}

