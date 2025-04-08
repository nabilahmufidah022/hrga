<?php namespace Ppl\Hrga\Models;

use Model;
use Backend\Models\User as BackendUser;
use Ppl\Hrga\Models\Division as MoDivisi;
use Ppl\Hrga\Models\Meetingroomlist as MoMeetingRoom;
use DB;

/**
 * userroomorder Model
 */
class Userroomorder extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'merapat_roomorder_form';

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
    public $rules = [
        

    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [
        'nama_peserta_rapat', 
        'nama_mitra'
    ];

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
        'tanggal_akhir'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        // 'rapat' =>[
        //     MoMeetingRoom::class,
        //     'key' => 'id',
        //     'otherKey' => 'meetingroomlist_id'
        // ],
    ];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [
        'ruangan' =>[
            MoMeetingRoom::class,
            'table' => 'merapat_roomorder_form',
            'key' => 'meetingroomlist_id'
        ],
        'pengirim' => [
            BackendUser::class,
            'key' => 'backend_user_id'
        ],
        // 'ruangan' =>[
        //     MoMeetingRoom::class,
        //     'key' => 'id',
        //     'otherKey' => 'meetingroomlist_id'
        // ]
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'upload_undangan' => \System\Models\File::class,
        'kehadiran' => \System\Models\File::class,
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


    public function getMeetingroomlistidOptions($value, $formData)
    {
        $RoomMeetingData = MoMeetingRoom::get(['id','room_name'])->toArray();
        $RoomMeeting = [];
        foreach($RoomMeetingData as $value) {
            $RoomMeeting[$value['id']] = $value['room_name'];
        }

        return $RoomMeeting;
    }

    public function getJenisRapatOptions($value, $formData)
    {
        // return StaticJenisDeposito::list();
        return ['Eksternal' => 'Eksternal', 'Internal' => 'Internal'];
    }

    // public function getDivisiIdOptions($value, $formData)
    // {
    //     $Divisidata = MoDivisi::get(['id','nama_divisi'])->toArray();
    //     $Divisi = [];
    //     foreach($Divisidata as $value) {
    //         $Divisi[$value['id']] = $value['nama_divisi'];
    //     }

    //     return $Divisi;
    // }

    public function getUnitKerjaAttribute($value) {
        $userMaker = MoDivisi::find($this->divisi_id);
        // dd($userMaker);
        if($userMaker) {
            return $userMaker->nama_divisi;
        }else{
            return 'Belum Di Disposisi';
        }
    }

    
    // public function getmeetingroomOptions($roomid, $dateStr)
    // {
    //     return ['au' => $roomid];
    // }
}


    // public function getNamaMitraOptions($value){

    //     if($this->jenis_rapat == 'eks'){
    //         $value->nama_mitra = null;
    //     }
    // }

    // public function filterFields($fields, $context)
    // {
    //     // if deposito : resiprokal maka jenis resiprokal muncul
    //     // if jenis resiprokal : bisnis maka potensi ijk dan target muncul

    //     if ($this->jenis_rapat == 'eks') { // res
    //         $fields->nama_mitra->hidden = false ;
    //     // if($this->jenis_rapat == 'in'){
    //     //     $fields->nama_mitra->hidden = true;
    //     //     // var_dump($this->jenis_rapat);
    //     //     //  var_dump($this->jenis_rapat ?? 'no data'); 


    //     // }


    //     // $data = $this->jenis_resiprokal;
    //     // var_dump($data);
    //     };

    // // public function getRoomMeetingAttribute($value) {
    // //     $userMaker = MoMeetingRoom::find($this->nama_ruangan);
    // //     if($userMaker) {
    // //         return $userMaker->room_name;
    // //     }else{
    // //         return 'Belum Di Assign';
    // //     }
    // // }

    
   
    // }

