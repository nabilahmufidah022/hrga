<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Winter\Storm\Support\Facades\DB;
use Ppl\Hrga\Models\Meetingroomlist as Ruangrapat;
use Ppl\Hrga\Models\Userroomorder as Formorder;
use Carbon\Carbon;

/**
 * Homes Backend Controller
 */
class Homes extends Controller
{
    protected $partialsDir = 'ppl/hrga/partials/';
    public $requiredPermissions = ['ppl.hrga.peminjaman.home'];
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

        BackendMenu::setContext('Ppl.Hrga', 'homes', 'homes');
    }

    public function index(){
        $ruang=Ruangrapat::get();
        $events = [];
        foreach ($ruang as $appointment) {
            $events[] = [
                'id' => $appointment->id,
                'title' => $appointment->room_name,
            ];
        }
        $this->vars['resources']=json_encode($events);
        
        $this->addJs('https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.9/index.global.min.js');
        // dd($events); 
        $form=Formorder::whereNotIn('flaq_status', [2,6])->get();

        $pinjams=[];
      
        foreach ($form as $row) {
            $pinjams[] = [
                'title' => $row->nama,
                'start' => $row->tanggal_awal->format('Y-m-d H:i:s'),
                'end' => $row->tanggal_akhir->format('Y-m-d H:i:s'),
                'resourceId' => $row->meetingroomlist_id,

            ];
        }
        // $pinjams[] = [
        //     'title' => '➕',
        //     'start' => '2023-11-30 08:00:00',
        //     'end' => '2023-11-30 08:30:00',
        //     'resourceId' => 1,
        //     'color'=> '#ffffff'

        // ];
        $pinjams[] = [
            'title' => 'testkuy',
            'start' => '2023-11-30 08:30:00',
            'end' => '2023-11-30 09:30:00',
            'resourceId' => 1,

        ];
        $this->vars['pinjams']=json_encode($pinjams);
        $this->asExtension('ListController')->index();
        // dd($events);


    }



    // public function index()
    // {
    //     $data = array();
    //     // $tgl    =date("Y-m-d  H:i:s");
    //     $tgl_now = Carbon::now();
    //     // $trialExpires = $current->addDays(30);
    //     $this->vars["tgl_now"]=$tgl_now->addMinutes(420);
    //     // $tgl->addMinutes(420);
    //     // $dove = $tgl->diffInMinutes($record->tanggal_awal,false);

    //     // dd($tgl);
        
    //     $ruang=Ruangrapat::get();
    //     $this->vars['ruang']=$ruang; 
    //     // $data= Ruangrapat::select('tanggal_awal', 'tanggal_akhir')->get();
    //     $data=Formorder::get();
    //     $data = Db::table('merapat_roomorder_form as room')
    //     ->Join('merapat_meetingroomlists as pinjam', 'room.meetingroomlist_id', '=', 'pinjam.id')
    //     // ->where('room.flaq_status', '>=', 4)
    //     // ->groupBy('meetingroomlist_id','room_name', 'flaq_status')
    //     ->get();

       
    //     // $data =$data['form'];
        
    //     // dd($data);
    //     $this->vars['ruangan']=$data; 
    // }

    // public function indexget()
    // {
    //     $this->db = db_connect();
    //     $mulai_tanggal = @$_POST['mulai_mulai'];
    //     $sampai_tanggal = @$_POST['sampai_tanggal'];

    //     $sql = "SELECT * FROM pemasukan WHERE tgl_pemasukan BETWEEN '" . $mulai_tanggal . "' AND '" . $sampai_tanggal . "'";
    //     $query = $this->db->query($sql);
    //     $results = $query->getResultArray();

    //     return $results;
    // }
}
