<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use BackendAuth;
use Backend\Classes\Controller;
use Winter\Storm\Support\Facades\DB;
use Ppl\Hrga\Models\Meetingroomlist as Ruangrapat;
use View;
/**
 * Meetingrooms Backend Controller
 */
class Meetingrooms extends Controller
{
    protected $partialsDir = 'ppl/hrga/partials/';
    public $requiredPermissions = ['ppl.hrga.peminjaman.ruangrapat'];
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

        BackendMenu::setContext('Ppl.Hrga', 'homes', 'meetingrooms');
    }

    public function onRun()
    {
        if (true) {
            $this->setStatusCode(404);
            return $this->controller->run('404'); //page meeting
        }
    }

    public function index()
    {
        $data = array();
        $data = Ruangrapat::get();
        // echo $data->room_pics->output();
        // dd($data[0]->room_pics[0]->getPath());
        $this->vars['ruangan']=$data;
        $this->asExtension('ListController')->index();
    }

    public function update($id){
        $this->pageTitle = 'Detail Ruangan';
        $data = array();
        // $user = BackendAuth::getUser();
        $data = Ruangrapat::where('id', $id)->first();
        // dd($data);


        // $ruangan = Ruangrapat::get();
        // $this->vars['ruangan']=$data;
        
        $this->vars['ruangan']=$data;
    }

}
