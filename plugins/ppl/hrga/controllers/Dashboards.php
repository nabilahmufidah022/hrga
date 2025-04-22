<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Ppl\Hrga\Models\Userroomorder as Roomorder;
use Ppl\Hrga\Models\Meetingroomlist as Ruangrapat;
use Ppl\Hrga\Models\Division as Divisi;

use Carbon\Carbon;
/**
 * Dashboards Backend Controller
 */
class Dashboards extends Controller
{
    protected $partialsDir = 'ppl/hrga/partials/';
    public $requiredPermissions = ['ppl.hrga.peminjaman.beranda'];
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

        BackendMenu::setContext('Ppl.Hrga', 'homes', 'dashboards');
    }

    public function index()
    {
        // $data = array();
        $order = Roomorder::where('flaq_status', '=', 1)->count();
        $this->vars['peminjaman']=$order;
        
        $room = Ruangrapat::count();
        // dd($room);
        $this->vars['ruangan']=$room;

        $division = Divisi::count();
        // dd($room);
        $this->vars['divisi']=$division;

        $tgl_now = Carbon::now();
        // $this->vars["tgl_now"]=$tgl_now->addMinutes(420);
        
        $reports = RoomOrder::where('tanggal_akhir', '<=', $tgl_now ) ->orwhere('flaq_status', '=', '1')->count();
        // dd($reports);
        $this->vars['report']=$reports;

        $this->asExtension('ListController')->index();
        
    }

}
