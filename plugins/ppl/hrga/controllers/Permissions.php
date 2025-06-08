<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Illuminate\Support\Facades\Redirect as FacadesRedirect;
use Validator;
use ValidationException;
use Redirect;
use Flash;
use Carbon\Carbon;

use Ppl\Hrga\Models\Permission as Permission;
use Backend\Models\User as BackendUser;

/**
 * Permissions Backend Controller
 */
class Permissions extends Controller
{
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
    protected $partialsDir = 'ppl/hrga/partials/';  
    protected $requiredPermissions = [
        'ppl.hrga.pengajuan.sakit',
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ppl.Hrga', 'homes', 'permissions');
    }

    public function index()
    {
        $tgl_now = Carbon::now();
        
        $id_backenduser = Permission::pluck('backend_user_id');
        // dd($id_backenduser);

        $nama = BackendUser::whereIn('id', $id_backenduser)->get();
        $this->vars["tgl_now"]=$tgl_now->addMinutes(419);
        $this->asExtension('ListController')->index();     
    }

    public function preview($id, $context='preview'){
        $id_sakit = Permission::find($id);
        $this->vars["nama_pengaju"] = BackendUser::find($id_sakit->backend_user_id);
        $this->asExtension('FormController')->preview($id, $context);
    }

    public function update($id, $context='update'){
        $id_sakit = Permission::find($id);
        $this->vars["nama_pengaju"] = BackendUser::find($id_sakit->backend_user_id);
        $this->asExtension('FormController')->preview($id, $context);
    }

    public function formBeforeCreate($model) {
        $data = input('Permission');
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
            'keterangan_izin'   => 'Required',
            'jenis_izin'        => 'Required'
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
        $jumlah_rencana_izin = $tanggal_awal->diffInDays($tanggal_akhir) + 1;
        $model->jumlah_rencana_izin = $jumlah_rencana_izin;
    }

    public function formAfterCreate($model) {
        $model->backend_user_id = $this->user->id;
        $model->flag_status = 4;
        $model->save();

        Flash::success('Berhasil Mengajukan Permohonan Izin!!');
        return Redirect::to('/mybackend/ppl/hrga/Permission');    
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
        $detail = Permission::find($data['sick_id']);
        $detail->alasan_tolak = $data['alasan'];
        $detail->flag_status = 5;
        $detail->save();

        Flash::success('Pengajuan Izin Ditolak!');
        return Redirect::to('/mybackend/ppl/hrga/Permissions');
    }

}
