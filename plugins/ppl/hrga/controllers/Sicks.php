<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Illuminate\Support\Facades\Redirect as FacadesRedirect;
use Validator;
use ValidationException;
use Redirect;
use Flash;
use Carbon\Carbon;

use Ppl\Hrga\Models\Sick as Sick;
use Backend\Models\User as BackendUser;
/**
 * Sicks Backend Controller
 */
class Sicks extends Controller
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
        'ppl.hrga.pengajuan.sakit',
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ppl.Hrga', 'homes', 'sicks');
    }

    public function index()
    {
        $tgl_now = Carbon::now();
        
        $id_backenduser = Sick::pluck('user_id');
        // dd($id_backenduser);

        $nama = BackendUser::whereIn('id', $id_backenduser)->get();
        $this->vars["tgl_now"]=$tgl_now->addMinutes(419);
        $this->asExtension('ListController')->index();     
    }

    public function preview($id, $context='preview'){
        $id_sakit = Sick::find($id);
        $this->vars["nama_pengaju"] = BackendUser::find($id_sakit->user_id);
        $this->asExtension('FormController')->preview($id, $context);
    }

    public function update($id, $context='update'){
        $id_sakit = Sick::find($id);
        $this->vars["nama_pengaju"] = BackendUser::find($id_sakit->user_id);
        $this->asExtension('FormController')->preview($id, $context);
    }

    public function onOrder() {
        $data = input('Sick');
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
            'keterangan_sakit'  => 'Required'
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
        
        $data1 = input();

        //perhitungan jumlah_hari
        $tanggal_awal = Carbon::parse($data['tanggal_awal']);
        $tanggal_akhir = Carbon::parse($data['tanggal_akhir']);

        // Hitung jumlah hari (termasuk tanggal awal dan akhir)
        $jumlah_hari = $tanggal_awal->diffInDays($tanggal_akhir) + 1;
        // dd($jumlah_hari);
        
        // dd($data1);

        $Sick = new Sick;
        // dd($Roomorder);
        $Sick->user_id = $this->user->id;
        $Sick->divisi_id = $data['divisi_id'];
        $Sick->no_wa = $data['no_wa'];
        $Sick->tanggal_awal = $data['tanggal_awal'];
        $Sick->tanggal_akhir = $data['tanggal_akhir'];
        $Sick->keterangan_sakit = $data['keterangan_sakit'];
        $Sick->jumlah_hari = $jumlah_hari;
        $Sick->flag_status = 4;
        $Sick->save(); 

        Flash::success('Berhasil Mengajukan Permohonan Sakit!!');
        return Redirect::to('/mybackend/ppl/hrga/Sicks');
        
    }

    public function formAfterSave($model) {
        $model->flag_status = 1;
        $model->save();
    }

    
}
