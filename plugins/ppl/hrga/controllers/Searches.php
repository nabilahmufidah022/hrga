<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Redirect,Flash;
use Winter\Storm\Support\Facades\DB;
use Request;
use Backend\Classes\Controller;
use Backend\Widgets\Search;
use Illuminate\Http\Client\Request as ClientRequest;
use Ppl\Hrga\Models\Meetingroomlist as Ruangrapat;
use Ppl\Hrga\Models\Userroomorder as Formorder;
use Carbon\Carbon;

/**
 * Searches Backend Controller
 */
class Searches extends Controller
{
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

        BackendMenu::setContext('Ppl.Hrga', 'hrga', 'searches');
    }

   

    // public function onSearch()

    // {
    //     \Event::listen('offline.sitesearch.query', function ($query) {
    //         $items = Models\EMagazine::where('title', 'like', "%${query}%")
    //                                         ->get();
    //         $results = $items->map(function ($item) use ($query) {
    //             $relevance = mb_stripos($item->title, $query) !== false ? 2 : 1;

    //             return [
    //                 'title'     => $item->title,
    //                 'url'       => '/emagazines/' . $item->slug,
    //                 'thumb'     => $item->img->first(),
    //                 'relevance' => $relevance,
    //             ];
    //         });

    //         return [
    //             'provider' => 'EMagazine',
    //             'results'  => $results,
    //         ];
    //     });
    // }

    public function index()
    {
        
        $events = [];
        
        $events['start_date'] = request()->start_date;
        $events['start_time'] = request()->start_date;
        $events['end_time'] = request()->end_time;

        $tgl_now = Carbon::now('Asia/Jakarta');
        // $tgl_now= date_default_timezone_set('Asia/Jakarta');
        // dd($tgl_now);
        $exclId = [];
            $formorders = Formorder::whereIn('flaq_status',['1','2','3'])
            // ->where('tanggal_akhir', '>=', $tgl_now)
            ->get(); 
            if($formorders) {
                foreach ($formorders as $formorder) {
                    $exclId[$formorder->meetingroomlist_id] =$formorder->meetingroomlist_id; 
    
                }
            
        }$ruangan = Ruangrapat::whereNotIn('id', $exclId)->get();
        
        if($events['start_date']!=null && $events['start_time']!=null && $events['end_time']!=null){
            $exclId = [];
            $formorders = Formorder::whereIn('flaq_status',['1','2','3'])->whereBetween('tanggal_akhir',[$events['start_date'], $events['start_time'],$events['end_time']])
            // ->where('tanggal_akhir', '>=', $tgl_now)
            ->get(); 
            if($formorders) {
                foreach ($formorders as $formorder) {
                    $exclId[$formorder->meetingroomlist_id] =$formorder->meetingroomlist_id; 
    
                }
            
        }$ruangan = Ruangrapat::whereNotIn('id', $exclId)
->get();
            
        }
        $events = $ruangan;
        

        $this->vars['events'] = $events; 
    }

    public function indexx()
    {
        
        // $events = Ruangrapat::get();
        // $events = Ruangrapat::where('flag_status', '>=' , 4)->get();

        // $events = Formorder::where('merapat_roomorder_form.flaq_status', '>=', 4)->groupBy('meetingroomlist_id')->get();
        $events = [];
        // $events['date'] = request()->date;
        $events['start_date'] = request()->start_date;
        $events['end_date'] = request()->end_date;

        $ruangan = Db::table('merapat_roomorder_form as pinjam')
        // ->select(
        // 'room.meetingroomlist_id',
        // 'pinjam.room_name',
        // 'room.flaq_status'
        // )
        ->Join('merapat_meetingroomlists as room', 'room.id', '=', 'pinjam.meetingroomlist_id')
        ->select('pinjam.meetingroomlist_id', 'pinjam.flaq_status',
             'room.room_name','room.id')
            //  ->whereNotIn('room.id', function($query) {
            //     $query->select('merapat_roomorder_form')
            //           ->from('meetingroomlist_id');
            // })
        // ->where('room.flaq_status', '>=', 4)
        // ->whereNotIn('room.id', DB::table('merapat_roomorder_form')->select('meetingroomlist_id'))
        // ->where(DB::table('merapat_roomorder_form')->select('flaq_status'), '>=', 4 )
        // ->groupBy('meetingroomlist_id','room_name', 'flaq_status')
        // ->select('users.*', 'contacts.phone', 'orders.price')
        ->get();
        dd($ruangan);
        if($events['start_date']!=null && $events['end_date']!=null){
            $ruangan = Db::table('merapat_roomorder_form as room')
                ->select(
                    'room.meetingroomlist_id',
                    'pinjam.room_name',
                    'room.flaq_status'
                )
                ->Join('merapat_meetingroomlists as pinjam', 'room.meetingroomlist_id', '=', 'pinjam.id')
                ->where('room.flaq_status', '>=', 4)
                ->groupBy('meetingroomlist_id','room_name', 'flaq_status')
                 ->whereBetween('tanggal_akhir',[$events['start_date'],$events['end_date']])
                // ->select('users.*', 'contacts.phone', 'orders.price')
                ->get();
        }

        $events = $ruangan;

    // dd($events);

        
        // $events = [];
        //    $events['start_date'] = request()->start_date;
        //    $events['end_date'] = request()->end_date;
        // $ruangan = DB::table('merapat_meetingroomlists')
        //     ->leftjoin('merapat_roomorder_form', 'merapat_meetingroomlists.id', '=', 'merapat_roomorder_form.meetingroomlist_id')
        //     // ->where('merapat_meetingroomlists.id', '=', 'merapat_roomorder_form.meetingroomlist_id')
        //     // ->where('meetingrommlist_id', '=' , )
        //     // ->where('merapat_roomorder_form.flaq_status','>=', 4 )
        //     ->get();

        // if($events['start_date']!=null && $events['end_date']!=null){
        //     $ruangan = DB::table('merapat_meetingroomlists')
        //         ->join('merapat_roomorder_form', 'merapat_meetingroomlists.id', '=', 'merapat_roomorder_form.meetingroomlist_id')
        //         // ->where('merapat_meetingroomlists.id', '=', 'merapat_roomorder_form.meetingroomlist_id')
        //         // ->where('tanggal_awal','=', $events['start_date'])
        //         // ->where('tanggal_akhir','=',$events['end_date'])
        //         ->orwhere('merapat_roomorder_form.flaq_status','>=', 4 )
        //         ->whereBetween('tanggal_akhir',[$events['start_date'],$events['end_date']])
        //         ->get();
        $this->vars['events']=$events;
        // dd($events);
       }
    //    $events['page_title'] = 'Search';
        // dd($events);
        // $startDate = post('start_date');
        // $endDate = post('end_date');
        // $events = Formorder::whereNotIn('flaq_status', [1,2,3])->get();
        // // dd($e);
        

        // // Kemudian kirim hasil pencarian ke tampilan


//     public function index()
//     {

        
//         $results = Search::search('content', 'fox')
// 	        ->where('status', 'published')
// 	        ->get();
//         $keyword = post('keyword');
//         $data = array();
//         // $data=Ruangrapat::get();
//         $data_cari =Formorder::whereNotIn('flaq_status', [1,2,3])->get();
//         // dd($data_cari);
//         if ($keyword != null && $keyword != "") {
//             $data_cari = $data_cari
//                 ->where(function ($query) use ($keyword) {
//                     $query
//                         ->where('tanggal_awal', 'like', '%' . $keyword . '%')
//                         ->orwhere('tanggal_akhir', 'like', '%' . $keyword . '%');
//                         // ->orwhere('', 'like', '%' . $keyword . '%');
//                 });
//     }
//     $data_cari = $data_cari->get();
//     $data['keyword'] = $keyword;    
//     // $this->vars['keyword']=$data;
//     return view('Jamsyar.Merapat.searches', $data);
// }

}
