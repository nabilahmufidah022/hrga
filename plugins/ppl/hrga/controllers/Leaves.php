<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Illuminate\Support\Facades\Redirect as FacadesRedirect;
use Validator;
use ValidationException;
use Redirect;
use Flash;
use Carbon\Carbon;

use Ppl\Hrga\Models\Leave as Leave;
use Backend\Models\User as BackendUser;
/**
 * Leaves Backend Controller
 */
class Leaves extends Controller
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
        'ppl.hrga.pengajuan.cuti',
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ppl.Hrga', 'homes', 'leaves');
    }

    public function listExtendQuery($query) {
        $user = $this->user;

        if ($user->role_id == 4) {
            // Admin HRGA bisa lihat semua data dengan status 4 atau 1 juga
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                ->orWhere('flag_status', 7);
            });
        }elseif ($user->role_id == 5) {
            // Admin HRGA bisa lihat semua data dengan status 4 atau 1 juga
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                ->orWhere('flag_status', 6);
            });
        } 
        else {
            // User biasa hanya lihat datanya sendiri
            $query->where('user_id', $user->id);
        }
    }

    public function index()
    {
        $tgl_now = Carbon::now();
        
        $id_backenduser = Leave::pluck('user_id');
        // dd($id_backenduser);

        $nama = BackendUser::whereIn('id', $id_backenduser)->get();
        $this->vars["tgl_now"]=$tgl_now->addMinutes(419);
        $this->asExtension('ListController')->index();     
    }

    public function preview($id, $context='preview'){
        $id_sakit = Leave::find($id);
        $this->vars["nama_pengaju"] = BackendUser::find($id_sakit->user_id);
        $this->asExtension('FormController')->preview($id, $context);
    }

    public function update($id, $context='update'){
        $id_sakit = Leave::find($id);
        $this->vars["nama_pengaju"] = BackendUser::find($id_sakit->user_id);
        $this->asExtension('FormController')->preview($id, $context);
    }

    public function formBeforeCreate($model) {
        $data = input('Leave');
        if($data['tanggal_akhir'] < $data['tanggal_awal']){
            $rules=[
                'tanggal_akhir' => 'before:date',
            ];

            $customMessages = [
                'before' => 'Tanggal akhir tidak boleh kurang dari Tanggal awal!!',
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
            'keterangan_cuti'  => 'Required'
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

        $tanggal_awal = Carbon::parse($data['tanggal_awal']);
        $tanggal_akhir = Carbon::parse($data['tanggal_akhir']);
        $jumlah_rencana_cuti = $tanggal_awal->diffInDays($tanggal_akhir) + 1;
        $model->jumlah_rencana_cuti = $jumlah_rencana_cuti;
    }

    public function formAfterCreate($model) {
        $model->user_id = $this->user->id;
        $model->flag_status = 6;
        $model->save();

        Flash::success('Berhasil Mengajukan Permohonan Cuti!!');
        return Redirect::to('/mybackend/ppl/hrga/Leaves'); 
    }
    public function formAfterSave($model) {
        $user = $this->user;

        if ($user->role_id == 4) {
            $model->flag_status = 1;
            $model->save();
        }else{
            $model->flag_status = 7;
            $model->save();
        }

        Flash::success('Permohonan Cuti Berhasil Disetujui!!');
        return Redirect::to('/mybackend/ppl/hrga/Leaves');
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
        $detail = Leave::find($data['leave_id']);
        $detail->alasan_tolak = $data['alasan'];
        $detail->flag_status = 5;
        $detail->save();

        Flash::success('Pengajuan Cuti Ditolak!');
        return Redirect::to('/mybackend/ppl/hrga/Sicks');
    }
}
