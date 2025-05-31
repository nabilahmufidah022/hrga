<?php namespace Ppl\Hrga\Controllers;

use Backend\Facades\Backend;
use Backend\Facades\BackendMenu;
use Backend\Classes\Controller;
use Backend\Facades\BackendAuth;
use Winter\Storm\Exception\ValidationException;
use Winter\Storm\Support\Facades\Flash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Ppl\Hrga\Models\Absence;
use Exception;

/**
 * Absences Backend Controller
 * Manages employee attendance records
 */
class Absences extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    /**
     * @var string Configuration file for the form behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the list behavior.
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var array Permissions required to view this page.
     */
    public $requiredPermissions = [
        'ppl.hrga.absensi',
        'ppl.hrga.absences.manage_all'
    ];
    
    /**
     * @var string Directory for partials
     */
    protected $partialsDir = 'ppl/hrga/partials/';   

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Ppl.Hrga', 'homes', 'absences');
    }

    /**
     * Index page
     */
    public function index()
    {
        $tgl_now = Carbon::now();
        $this->vars["tgl_now"] = $tgl_now->addMinutes(419);
        $this->asExtension('ListController')->index();
    }

    /**
     * Handler for attendance submission
     */
    public function onAbsen()
{
    $data = post();

    $rules = [
        'unit_kerja'        => 'required',  // Changed from divisi_id
        'waktu_absen'       => 'required',
        'status_kehadiran'  => 'required',
        'bukti_timestamp'   => 'required',
    ];

    $customMessages = [
        'required' => ':attribute wajib diisi!',
    ];

    $validation = Validator::make($data, $rules, $customMessages);

    if ($validation->fails()) {
        throw new ValidationException($validation);
    }

    try {
        $Absence = new Absence;
        $Absence->user_id = BackendAuth::getUser()->id;
        // Map divisi_id to unit_kerja (this is the key fix)
        $Absence->unit_kerja = $data['unit_kerja'];
        $Absence->waktu_absen = $data['waktu_absen'];
        $Absence->status_kehadiran = $data['status_kehadiran'];
        $Absence->bukti_timestamp = $data['bukti_timestamp'];
        $Absence->save();

        Flash::success('Absensi berhasil disimpan!');
    } catch (Exception $e) {
        Flash::error('Gagal menyimpan absensi: ' . $e->getMessage());
    }
    
    return Redirect::to(Backend::url('ppl/hrga/absences'));
}

    /**
     * After save event handler
     * 
     * @param \Model $model The model being saved
     */
    public function formAfterSave($model)
    {
        // Add additional logic here if needed
    }
    
    /**
     * Get dropdown options for division
     */
    public function getDivisionOptions()
    {
        return \Ppl\Hrga\Models\Division::lists('nama_divisi', 'id');
    }
    
    /**
     * Create new absence record through form
     */
    public function create()
    {
        $this->bodyClass = 'compact-container';
        $this->asExtension('FormController')->create();
    }
    
    /**
     * Edit existing absence record
     */
    public function update($recordId = null)
    {
        $this->bodyClass = 'compact-container';
        $this->asExtension('FormController')->update($recordId);
    }
}