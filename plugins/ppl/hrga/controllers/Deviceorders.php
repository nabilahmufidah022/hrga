<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Illuminate\Support\Facades\Redirect as FacadesRedirect;
use Validator;
use ValidationException;
use Redirect;
use Flash;

use Ppl\Hrga\Models\Deviceorder as Deviceorder;
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

    public function onOrder() {
        $data = input();
        if($data['tanggal_akhir'] <= $data['tanggal_awal']){
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
            'nama_peminjam'     => 'Required',
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
            $data, $rules, $customMessages
        );

        if($validation->fails()) { 
            $messages = $validation->messages();
            throw new ValidationException($validation);
        }
        
        $Deviceorder = new Deviceorder;
        // dd($Roomorder);
        $Deviceorder->backend_user_id = $this->user->id;
        $Deviceorder->divisi_id = $data['Deviceorder']['divisi_id'];
        $Deviceorder->no_wa = $data['Deviceorder']['no_wa'];
        $Deviceorder->tanggal_awal = $data['Deviceorder']['tanggal_awal'];
        $Deviceorder->tanggal_akhir = $data['Deviceorder']['tanggal_akhir'];
        $Deviceorder->jumlah_perangkat = $data['Deviceorder']['jumlah_perangkat'];
        $Deviceorder->device_id = $data['Deviceorder']['device_id'];
        $Deviceorder->keperluan = $data['Deviceorder']['keperluan'];
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
        $detail->flag_status = 6    ;
        $detail->save();

        // dd($MoHistory);
        $MoHistory->save();

        Flash::success('Pengajuan Permohonan Desain Berhasil Ditolak!');
        return Redirect::to('/manage/jamsyar/modesain/kadivforms');
    }
}
