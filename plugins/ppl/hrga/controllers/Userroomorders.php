<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

use Ppl\Hrga\Models\Userroomorder as Roomorder;

use Ppl\Hrga\Models\Meetingroomlist as Ruangrapat;
use Redirect;
use Flash;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Illuminate\Support\Facades\Redirect as FacadesRedirect;
use Validator;
use ValidationException;

// use Winter\Storm\Support\Facades\Mail;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;
use Backend\Models\User as BackendUser;
use Backend\Models\UserRole as role;

/**
 * Userroomorders Backend Controller
 */
class Userroomorders extends Controller
{
    protected $partialsDir = 'ppl/hrga/partials/';
    public $requiredPermissions = ['ppl.hrga.peminjaman.peminjamanruangan'];
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ppl.Hrga', 'homes', 'userroomorders');
    }

    public function onOrder($model) {
       
        $data1 = input('Userroomorder');
        // dd($data);

        if($data1['jenis_rapat'] == 'eks'){
            $rules=[
                'jenis_rapat' => 'Required',
                'nama_mitra' => 'Required'
            ];

            $customMessages = [
                'required' => ':attribute wajib di isi!',
            ];

            $validation = Validator::make(
                $data1, $rules, $customMessages
            );
    
            if($validation->fails()) {
                $messages = $validation->messages();
                throw new ValidationException($validation);
            }
        }

        $inputan = input();
        // dd($detail);   
        date_default_timezone_set('Asia/Jakarta');
        $datetime = date('Y-m-d H:i:s', $inputan['dateStr']);

        if($data1['tanggal_akhir'] <= $datetime){
            $rules=[
                'tanggal_akhir' => 'before:date',
            ];

            $customMessages = [
                'before' => 'Waktu akhir tidak boleh kurang dari waktu peminjaman awal!!',
            ];

            $validation = Validator::make(
                $data1, $rules, $customMessages
            );
    
            if($validation->fails()) {
                $messages = $validation->messages();
                throw new ValidationException($validation);
            }
        }

        $rules = [
            'nama' => 'Required',
            'no_wa' => 'Required|numeric',
            'divisi_id' => 'Required',
            'tanggal_akhir' => 'Required',
            'jumlah_peserta' => 'Required|numeric',
            'agenda_rapat' => 'Required',
            'jenis_rapat' => 'Required',
            'nama_peserta_rapat' => 'Required',
            // 'nama_mitra' => 'Required'
        ];

        $customMessages = [
            'required' => ':attribute wajib di isi!',
            'numeric' => ':attribute harus angka'
        ];

        $validation = Validator::make(
            $data1, $rules, $customMessages
        );

        if($validation->fails()) { 
            $messages = $validation->messages();
            throw new ValidationException($validation);
        }

        $data = input();
        $detail = $model;
        // dd($detail);   
        date_default_timezone_set('Asia/Jakarta');
        $datetime = date('Y-m-d H:i:s', $data['dateStr']);
        // dd($datetime, $data);
        $test = $data['Userroomorder']['tanggal_akhir'];
        // dd($test,$datetime);

        $detail = Ruangrapat::find($data['merapat_id']);
        // dd($detail);
        // $detail = $model;
        
        $Roomorder = new Roomorder;
        // dd($Roomorder);
        $Roomorder->backend_user_id = $this->user->id;
        $Roomorder->nama = $data['Userroomorder']['nama'];
        $Roomorder->no_wa = $data['Userroomorder']['no_wa'];
        $Roomorder->divisi_id = $data['Userroomorder']['divisi_id'];
        $Roomorder->tanggal_akhir = $data['Userroomorder']['tanggal_akhir'];
        $Roomorder->jumlah_peserta = $data['Userroomorder']['jumlah_peserta'];
        $Roomorder->agenda_rapat = $data['Userroomorder']['agenda_rapat'];
        $Roomorder->jenis_rapat = $data['Userroomorder']['jenis_rapat'];
        if($data['Userroomorder']['jenis_rapat'] == 'Eksternal'){
            $Roomorder->nama_mitra = $data['Userroomorder']['nama_mitra'];
        }
        $Roomorder->nama_peserta_rapat = $data['Userroomorder']['nama_peserta_rapat'];
        $Roomorder->flaq_status = $detail->flaq_status= 1;
        $Roomorder->tanggal_awal = $datetime;
        $Roomorder->meetingroomlist_id = $detail->id;

        $Roomorder->save();

        $penerima_email=[
            'nama' => $this->user->first_name.' '.$this->user->last_name,
            'room' => $detail->room_name,
            'jadwal' => $datetime.' s/d '.$data['Userroomorder']['tanggal_akhir'],
        ];

        $roleid= BackendUser::where('role_id', '=', 4)->first();

        $penerima_admin=[
            'nama' => $roleid->first_name.' '. $roleid->last_name,
            'room' => $detail->room_name,
            'jadwal' => $datetime.' s/d '.$data['Userroomorder']['tanggal_akhir'],
            'nama_peminjam' => $data['Userroomorder']['nama'],
            'no_wa' => $data['Userroomorder']['no_wa'],
            'agenda' => $data['Userroomorder']['agenda_rapat'],
        ];

        $sender = $this->user->email;
        
        
        $nama_ruangan = $detail->room_name;
        

        Mail::send('jamsyar.merapat::mail.creatednotif', $penerima_email, function($message) use ($sender){
            $message->from('devops@ext.jamsyar.id','Admin Meeting');
            $message->subject('Pemesanan berhasil dibuat!!');
            $message->to($sender);
        });
        Mail::send('jamsyar.merapat::mail.creatednotifadm', $penerima_admin, function($message) use ($roleid,$nama_ruangan){
            $message->from('devops@ext.jamsyar.id','Admin Meeting');
            $message->subject('Pemesanan '.$nama_ruangan);
            $message->to($roleid->email);
        });
        Flash::success('Berhasil Meminjam Ruang Rapat!!');
        return Redirect::to('/manage/ppl/hrga/Userroomorders');
        // dd($model);
    }

    

    // public function onCek(){
    //     $data = input();
    //     $detail = Roomorder::find($data['merapat_id']);
    //     // $tgl_now = Carbon::now();
    //     // $this->vars["tgl_now"]=$tgl_now->addMinutes(420);
    //     // $dove = $tgl_now->diffInMinutes($detail->tanggal_awal,false);
    //     // if($dove <= 0   ){
    //     //     $detail->flaq_status = 5;
    //     // }else{
    //     //     $detail->flaq_status = 3;
    //     // }
    //     // $detail->alasan_tolak = $data['alasan'];
    //     $detail->flaq_status = 3;
    //     $detail->save();
    //     // dd($detail);
    //     \Flash::success('Check In Berhasil!');
    //     // return Redirect::to('/manage/ppl/hrga/Userroomorders');
    // } 

    public function onSelesai(){
        $data = input();
        $detail = Roomorder::find($data['merapat_id']);
        $detail->flaq_status = 2;
        $detail->save();

        $roleid= BackendUser::where('role_id', '=', 4)->first();

        $penerima_admin=[
            'nama' => $roleid->first_name.' '. $roleid->last_name,
            'nama_user' => $this->user->first_name.' '.$this->user->last_name,
            'room' => $detail->ruangan->room_name,
            'jadwal' => $detail->tanggal_awal. ' s/d '. $detail->tanggal_akhir,
        ];
        $nama_ruangan = $detail->ruangan->room_name; 
        

        Mail::send('jamsyar.merapat::mail.notifselesaiadmin', $penerima_admin, function($message) use ($roleid, $nama_ruangan){
            $message->from('devops@ext.jamsyar.id','Admin Meeting');
            $message->subject('Pemesanan '.$nama_ruangan.' diselesaikan!!!');
            $message->to($roleid->email);
        });


        Flash::success('Berhasil Menyelesaikan Rapat!!');
        return Redirect::to('/manage/ppl/hrga/Userroomorders');
    }

    public function onBatal(){
        $data = input();
        $detail = Roomorder::find($data['merapat_id']);
        
        $detail->alasan_tolak = $data['alasan'];
        $detail->flaq_status = 6;
        $detail->save();
        // dd($detail);

        $roleid= BackendUser::where('role_id', '=', 4)->first();

        $penerima_admin=[
            'nama' => $roleid->first_name.' '. $roleid->last_name,
            'nama_user' => $this->user->first_name.' '.$this->user->last_name,
            'room' => $detail->ruangan->room_name,
            'jadwal' => $detail->tanggal_awal. ' s/d '. $detail->tanggal_akhir,
            'alasan_batal' => $data['alasan'],
        ];
        $nama_ruangan = $detail->ruangan->room_name; 
        

        Mail::send('jamsyar.merapat::mail.notifpembatalanuser', $penerima_admin, function($message) use ($roleid, $nama_ruangan){
            $message->from('devops@ext.jamsyar.id','Admin Meeting');
            $message->subject('Pemesanan '.$nama_ruangan.' dibatalkan!!!');
            $message->to($roleid->email);
        });

        Flash::success('Peminjaman Ruangan Berhasil Dibatalkan!!');
        return Redirect::to('/manage/ppl/hrga/Userroomorders');
    } 

    public function listExtendQuery($query) {
        // dd($query);
        $query->where('backend_user_id', $this->user->id);

        
    }

    // public function sendEmailSchedule($schedule){
        
    //     $schedule->command('emails:send')
    //         ->everyMinute()
    //         ->sendOutputTo('haloooo')
    //         ->emailOutputTo('tugasbila08@gmail.com');
    // }
    public function index()
    {
        $tgl_now = Carbon::now();
        $this->vars["tgl_now"]=$tgl_now->addMinutes(419);
        $this->asExtension('ListController')->index();
    }

    public function preview($id, $context='preview'){
        $tgl_now = Carbon::now();
        $form = Roomorder::find($id);
        // date_default_timezone_set('Asia/Jakarta');
        $tanggal = $tgl_now->addMinutes(419);
        $dove = $tanggal->diffInMinutes($form->tanggal_awal, false);
        // dd($dove);
        // dd($dove);
        $this->vars["tanggalmulai"] =$dove;
        $this->vars["form"] = $form->flaq_status;
        $this->asExtension('FormController')->preview($id, $context);
    }

    public function orderform($roomid, $dateStr,$context ='create'){
        // dd($dateStr);
        #date_default_timezone_set('Asia/Jakarta');
        date_default_timezone_set('Asia/Jakarta');
        $datetime = date('Y-m-d g:i:a', strtotime($dateStr));
   
        // dd($datetime);

        
        
        // $roomid = $id
        $this->vars["ruangan"] = Ruangrapat::find($roomid);
        $this->vars['datestring']=$datetime;
        $this->vars['dateStr']=strtotime($dateStr);
        // $this->vars["ruangan"] = Ruangrapat::find($id);
        // dd( $this->vars['form']=$datetime);
        // $data = input();
        // $peminjaman =  Roomorder::find($data['merapat_id']);
        // $peminjaman->backend_user_id = $this->user->id;
        // // $model->meetingroomlist_id = $detail->id;
        // $peminjaman->flaq_status = +1;
        // $peminjaman->save();
        // return Redirect::to('/manage/ppl/hrga/Userroomorders');
        $this->asExtension('FormController')->create($context);
    }


    
}
