<?php namespace Ppl\Hrga\Models;

use Model;
use Carbon\Carbon;
use Ppl\Hrga\Models\Division as MoDivisi;
use Ppl\Hrga\Models\Meetingroomlist as MoMeetingRoom;

/**
 * adminroomorder Model
 */
class Adminroomorder extends Model
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
    public $hasMany = [
        // 'rapat' =>[
        //     MoMeetingRoom::class,
        //     'key' => 'id',
        //     'otherKey' => 'meetingroomlist_id'
        // ],
    ];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [
        'status' =>[
            Roomorder::class,
            'key' => 'id'
        ]
    ];
    public $attachOne = [
        'upload_undangan' => \System\Models\File::class,
        'kehadiran' => \System\Models\File::class,
    ];
    public $attachMany = [];

    public function getDivisiIdOptions($value, $formData)
    {
        $DivisiData = MoDivisi::get(['id','nama_divisi'])->toArray();
        $Divisi = [];
        foreach($DivisiData as $value) {
            $Divisi[$value['id']] = $value['nama_divisi'];
        }
        return $Divisi;
    }

    public function getKodeDivisiAttribute($value)
    {
        $DivisiData = MoDivisi::where('id','=', $this->divisi_id)->first();
        // dd($DivisiData);
        $nama_divisi = $DivisiData->nama_divisi;
        $kode_divisi = $DivisiData->kode_divisi;

        $dataDivisi = $kode_divisi.' - '.$nama_divisi;

        return $dataDivisi;
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
    public function getUnitKerjaAttribute($value) {
        $userMaker = MoDivisi::find($this->divisi_id);
        // dd($userMaker);
        if($userMaker) {
            return $userMaker->nama_divisi;
        }else{
            return 'divisi';
        }
    }

    public static function CekCounter() {
            date_default_timezone_set('Asia/Jakarta');
            $datetime = date('Y-m-d H:i:s');
            $count = Adminroomorder::where('tanggal_awal', '>' , $datetime)->where('flaq_status','=', 1)->get()->count();
            
            return $count;         
    }
    
}
