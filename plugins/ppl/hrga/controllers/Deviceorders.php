<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Illuminate\Support\Facades\Redirect as FacadesRedirect;
use Validator;
use ValidationException;
use Redirect;
use Flash;
use Carbon\Carbon;

use Ppl\Hrga\Models\Deviceorder as Deviceorder;
use Backend\Models\User as BackendUser;
/**
 * Deviceorders Backend Controller
 */
class Deviceorders extends Controller
{
    protected $partialsDir = 'ppl/hrga/partials/';
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    /**
     * @var array Permissions required to view this page.
     */
    protected $requiredPermissions = [
        'ppl.hrga.pengajuan.perangkat',
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ppl.Hrga', 'homes', 'deviceorders');
    }

    public function index()
    {
        $tgl_now = Carbon::now();
        $this->vars["tgl_now"]=$tgl_now->addMinutes(419);
        $this->asExtension('ListController')->index();     
    }

    public function preview($id, $context='preview'){
        $id_perangkat = Deviceorder::find($id);
        $this->vars["nama_pengaju"] = BackendUser::find($id_perangkat->backend_user_id);
        $this->asExtension('FormController')->preview($id, $context);
    }

    public function update($id, $context='update'){
        $id_perangkat = Deviceorder::find($id);
        $this->vars["nama_pengaju"] = BackendUser::find($id_perangkat->backend_user_id);
        $this->asExtension('FormController')->preview($id, $context);
    }

    public function onOrder() {
        $data = input('Deviceorder');
        if($data['tanggal_akhir'] < $data['tanggal_awal']){
            $rules=[
                'tanggal_akhir' => 'before:date',
            ];

            $customMessages = [
                'before' => 'Tanggal Peminjaman akhir tidak boleh kurang dari Tanggal peminjaman awal!!',
            ];

            $validation = Validator::make(
                $data, $rules, $customMessages
            );
    
            if($validation->fails()) {
                $messages = $validation->messages();
                throw new ValidationException($validation);
            }
        }

        $rules = [
            'divisi_id'         => 'Required',
            'no_wa'             => 'Required|numeric',
            'tanggal_awal'      => 'Required',
            'tanggal_akhir'     => 'Required',
            'device_id'         => 'Required',
            'jumlah_perangkat'  => 'Required|numeric',
            'keperluan'         => 'Required'
            // 'nama_mitra' => 'Required'
        ];

        $customMessages = [
            'required' => ':attribute wajib di isi!',
            'numeric' => ':attribute harus angka'
        ];

        $validation = Validator::make(
            $data,$rules, $customMessages
        );

        if($validation->fails()) { 
            $messages = $validation->messages();
            throw new ValidationException($validation);
        }

        $Deviceorder = new Deviceorder;
        // dd($Roomorder);
        $Deviceorder->backend_user_id = $this->user->id;
        $Deviceorder->divisi_id = $data['divisi_id'];
        $Deviceorder->no_wa = $data['no_wa'];
        $Deviceorder->tanggal_awal = $data['tanggal_awal'];
        $Deviceorder->tanggal_akhir = $data['tanggal_akhir'];
        $Deviceorder->jumlah_perangkat = $data['jumlah_perangkat'];
        $Deviceorder->device_id = $data['device_id'];
        $Deviceorder->keperluan = $data['keperluan'];
        $Deviceorder->flag_status = 4;
        $Deviceorder->save(); 

        Flash::success('Berhasil Meminjam Ruang Rapat!!');
        return Redirect::to('/mybackend/ppl/hrga/Deviceorders');
        
    }

    public function formAfterSave($model) {
        $model->flag_status = 1;
        $model->save();
    }

    public function onSimpanTolak($model){
        $data = input();

        $rules = [
            'alasan' => 'Required'
        ];

        $customMessages = [
            'required' => 'Alasan Penolakan Wajib Diupload',
        ];

        $validation = Validator::make(
            $data, $rules, $customMessages
        );

        if($validation->fails()) {
            $messages = $validation->messages();
            throw new ValidationException($validation);
        }
        $detail = Deviceorder::find($data['deviceorder_id']);
        // $detail->alasan_tolak = $data['alasan'];
        $detail->flag_status = 5;
        $detail->save();

        Flash::success('Pengajuan Peminjaman Perangkat Ditolak!');
        return Redirect::to('/mybackend/ppl/hrga/Deviceorders');
    }

    public function onSelesai(){
        $data = input();
        $detail = Deviceorder::find($data['deviceorder_id']);
        $detail->flag_status = 2;
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

        Flash::success('Berhasil Mengembalikan Perangkat!!');
        return Redirect::to('/mybackend/ppl/hrga/Deviceorders');
    }
}
