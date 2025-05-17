<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Illuminate\Support\Facades\Redirect as FacadesRedirect;
use Ppl\Hrga\Models\Userroomorder as Roomorder;
use Ppl\Hrga\Models\Meetingroomlist as Ruangrapat;
use Redirect;
use Flash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Winter\Storm\Support\Facades\DB;

/**
 * Adminroomorders Backend Controller
 */
class Adminroomorders extends Controller
{
    protected $partialsDir = 'ppl/hrga/partials/';   
    public $requiredPermissions = ['ppl.hrga.peminjaman.halamanpeminjaman'];
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

        BackendMenu::setContext('Ppl.Hrga', 'homes', 'adminroomorders');
    }

    public function onSimpanBatal($model){
        $data = input();
        $detail = Roomorder::find($data['merapat_id']);
        $detail->alasan_tolak = $data['alasan'];
        $detail->flaq_status = 6;
        $detail->save();
        

        // $penerima_email=[
        //     'nama' => $detail->pengirim->first_name.' '. $detail->pengirim->last_name,
        //     'room' => $detail->ruangan->room_name,
        //     'jadwal' => $detail->tanggal_awal. ' s/d '. $detail->tanggal_akhir,
        //     'alasan_batal' => $data['alasan'],
        // ];

        // $sender = $detail->pengirim->email; 
        // // $nama_ruangan = $detail->ruangan->room_name; 
        

        // Mail::send('ppl.hrga::mail.notifpembatalanadmin', $penerima_email, function($message) use ($sender){
        //     $message->from('devops@ext.jamsyar.id','Admin Meeting');
        //     $message->subject('Peminjaman dibatalkan!!');
        //     $message->to($sender);
        // });

        Flash::success('Pengajuan Permohonan Desain Berhasil Dibatalkan!');
        return Redirect::to('/mybackend/ppl/hrga/adminroomorders');
    }

    public function onSelesai(){
        $data = input();
        $detail = Roomorder::find($data['merapat_id']);
        $detail->flaq_status = 2;
        $detail->save();

        // $penerima_email=[
        //     'nama' => $detail->pengirim->first_name.' '. $detail->pengirim->last_name,
        //     'room' => $detail->ruangan->room_name,
        //     'jadwal' => $detail->tanggal_awal. ' s/d '. $detail->tanggal_akhir,
        // ];

        // $sender = $detail->pengirim->email; 
        // // $nama_ruangan = $detail->ruangan->room_name; 

        // Mail::send('ppl.hrga::mail.notifselesaiuser', $penerima_email, function($message) use ($sender){
        //     $message->from('devops@ext.jamsyar.id','Admin Meeting');
        //     $message->subject('Peminjaman diselesaikan!!');
        //     $message->to($sender);
        // });

        Flash::success('Berhasil Menyelesaikan Rapat!!');
        return Redirect::to('/mybackend/ppl/hrga/adminroomorders');
    }

    // public function formAfterSave($model) {
    //     $model->flaq_status = 2;
    //     $model->save();
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
        $tanggal = $tgl_now->addMinutes(419);
        $dove = $tanggal->diffInMinutes($form->tanggal_awal, false);
        $this->vars["tanggalmulai"] =$dove;
        $this->vars["form"] = $form->flaq_status;
        $this->asExtension('FormController')->preview($id, $context);
    }

}
