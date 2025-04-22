<?php namespace Ppl\Hrga;

use Backend;
use BackendMenu;
use Backend\Models\UserRole;
use System\Classes\PluginBase;
use Backend\Controllers\Auth;
use Ppl\Hrga\Statics\DocType as StaticDocType;
use Ppl\Hrga\Statics\JenisDeposito as StaticJenisDeposito;
use Ppl\Hrga\Statics\JenisResiprokal as StaticJenisResiprokal;
use Ppl\Hrga\Statics\JenisJangkaWaktu as StaticJenisJangkaWaktu;
use Winter\Storm\Support\Facades\Mail;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Ppl\Hrga\Models\Userroomorder as Roomorder;
use Backend\Models\User as BackendUser;

/**
 * Jarvis Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * @var array Plugin dependencies
     */
    public $require = ['Ppl.Locale'];

    /**
     * @var bool elevated  property, set true to enable overriding Auth action  
     */
    public $elevated = true;

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register(): void
    {
        BackendMenu::registerContextSidenavPartial('Ppl.Hrga', 'manage-users', '$/ppl/hrga/partials/_sidebar.htm');
        BackendMenu::registerContextSidenavPartial('Ppl.Hrga', 'master-data', '$/ppl/hrga/partials/_sidebar.htm');  
        BackendMenu::registerContextSidenavPartial('Ppl.Hrga', 'placementdoc', '$/ppl/hrga/partials/_sidebar.htm'); 
        BackendMenu::registerContextSidenavPartial('Ppl.Hrga', 'homes', '$/ppl/hrga/partials/_sidebar.htm');
        BackendMenu::registerContextSidenavPartial('Ppl.Hrga', 'dashboards', '$/ppl/hrga/partials/_sidebar.htm');  
    }


    /**
     * Boot method, called right before the request route.
     */
    public function boot(): void
    {

        \Event::listen('backend.menu.extendItems', function ($navigationManager) {
            $navigationManager->removeQuickActionItem('Winter.cms', 'preview');
        });
          
        Auth::extend(function ($controller) {
            $controller->bindEvent('page.beforeDisplay', function ($action, $params) use ($controller) {
                if ($action === 'signin') { 
                    return \Redirect::to('/');
                }
                if ($action === 'signout') { 
                    // good bye
                }
            });
        });

        \Event::listen('backend.menu.extendItems', function ($navigationManager) { 
            $listMenu = $navigationManager->listMainMenuItems();
            // dd($listMenu);
            // logic untuk cek notif'
            /**
             *
                "dashboards" 
                "adminroomorders" 
                "meetingroomlists" 
                "divisions" 
                "reports" 
                "homes"
                "userroomorders"
                "meetingrooms" 
             */
            // dd($listMenu["JAMSYAR.MODESAIN.HOME"]->sideMenu);
            // $listMenu["JAMSYAR.MERAPAT.HOMES"]->sideMenu["userroomorders"]->counter = 4;
            $listMenu["PPL.HRGA.HOMES"]->sideMenu["adminroomorders"]->counter = \Ppl\Hrga\Models\Adminroomorder::CekCounter();
        });

    }

    /**
     * Registers any frontend components implemented in this plugin.
     */
    public function registerComponents(): array
    {

        return [
            'Ppl\Hrga\Components\LoginFe' => 'hrgaLogin',
            'Ppl\Hrga\Components\Landing' => 'jslinkLanding',
            'Ppl\Hrga\Components\Hrga' => 'jslinkHrga',
            'Ppl\Hrga\Components\Agreement' => 'jslinkAgreement',
        ];
    }

    public function registerListColumnTypes()
    {
        return [
            // 'statusdoc' => [$this, 'evalStatusdocListColumn'],
            'doctype' => [$this, 'evalDoctypeListColumn'],
            'jenisdeposito' => [$this, 'evalJenisdepositoListColumn'],
            'jenisresiprokal' => [$this, 'evalJenisresiprokalListColumn'],
            'jenisjangkawaktu' => [$this, 'evalJenisjangkawaktuListColumn'],
        ];
    }

    public function evalDocTypeListColumn($value, $column, $record)
    {
        $type = StaticDocType::list();

        $type = isset($type[$value]) ? $type[$value] : $type[0];

        return $type;
    }

    public function evalJenisDepositoListColumn($value, $column, $record)
    {
        $type = StaticJenisDeposito::list();

        // $type = isset($type[$value]) ? $type[$value] : $type[0];

        return $type;
    }

    public function evalJenisResiprokalListColumn($value, $column, $record)
    {
        $type = StaticJenisResiprokal::list();

        // $type = isset($type[$value]) ? $type[$value] : $type[0];

        return $type;
    }

    public function evalJenisJangkaWaktuListColumn($value, $column, $record)
    {
        $type = StaticJenisJangkaWaktu::list();

        return $type;
    }

    
    // public function registerSchedule($schedule)
    // {
    //     // $schedule->command('cache:clear')->everyMinute();
    //     // $schedule->command('emails:send')
    //     // ->everyMinute()
    //     // ->sendOutputTo('/tmp')
    //     // ->emailOutputTo('tugasbila08@gmail.com');
        
        

    //     $schedule->call(function () {
    //         date_default_timezone_set('Asia/Jakarta');
    //         $tanggal_now=CarbonImmutable::now();
    //         $tanggal_last= $tanggal_now->addMinutes(15);

    //         $tanggal_start = $tanggal_last->format('Y-m-d H:i:s');
    //         $tanggal_end = $tanggal_now->format('Y-m-d H:i:s');
    //         $row_email = Roomorder::whereBetween('tanggal_awal', [$tanggal_end,$tanggal_start])
    //         ->whereNull('flag_notif1')
    //         ->get();

    //         $penerima_user= []; 
    //         foreach($row_email as $email){

    //                 $penerima_user=[
    //                     'nama' => $email->pengirim->first_name.' '. $email->pengirim->last_name,
    //                     'room' => $email->ruangan->room_name,
    //                     'agenda' => $email->agenda_rapat,
    //                     'jadwal' => $email->tanggal_awal. ' s/d '. $email->tanggal_akhir,
    //                 ];
                
    //                 $pengirim = $email->pengirim->email;
    //                 $ruangan = $email->ruangan->room_name;  

    //                 Mail::send('jamsyar.merapat::mail.message', $penerima_user, function($message) use ($pengirim, $ruangan){
    //                     // $pengirim = $email->pengirim->email;
    //                     $message->from('devops@ext.jamsyar.id','Admin Meeting');
    //                     $message->subject('Reminder menuju waktu pemakaian'.$ruangan.'!!!');
    //                     $message->to($pengirim);
    //                 });
    //                 // $data = Roomorder::flaq_email(1);
    //                 $email->flag_notif1=1;
    //                 $email->save();
                
    //         }
    //         return true; 
    //     })->everyMinute();


    //     //30 mnt sebelum dimulai untuk admin
    //     $schedule->call(function () {
    //         date_default_timezone_set('Asia/Jakarta');
    //         $tgl_now_adm=CarbonImmutable::now();
    //         $tgl_last_adm= $tgl_now_adm->addMinutes(30);

    //         $tgl_start_adm = $tgl_last_adm->format('Y-m-d H:i:s');
    //         $tgl_end_adm = $tgl_now_adm->format('Y-m-d H:i:s');
    //         $row_mail_adm = Roomorder::whereBetween('tanggal_awal', [$tgl_end_adm,$tgl_start_adm])
    //         ->whereNull('flag_notif_adm')
    //         ->get();

    //         $roleid_adm= BackendUser::where('role_id', '=', 4)->first();
    
    //         $penerima_admin= []; 
    //         foreach($row_mail_adm as $mail_adm){
                    
    //                 $penerima_admin=[
    //                     'nama' => $roleid_adm->first_name.' '. $roleid_adm->last_name,
    //                     'nama_peminjam' => $mail_adm->pengirim->first_name.' '. $mail_adm->pengirim->last_name,
    //                     'no_wa' => $mail_adm->no_wa,
    //                     'room' => $mail_adm->ruangan->room_name,
    //                     'jadwal' => $mail_adm->tanggal_awal. ' s/d '. $mail_adm->tanggal_akhir,
    //                 ];

    //                 $ruangan = $mail_adm->ruangan->room_name; 

    //                 Mail::send('jamsyar.merapat::mail.notifadmin', $penerima_admin, function($message) use ($roleid_adm, $ruangan){
    //                     $message->from('devops@ext.jamsyar.id','Admin Meeting');
    //                     $message->subject('Reminder menuju pemakaian '.$ruangan.'!!');
    //                     $message->to($roleid_adm->email);
    //                 });
    //                 $mail_adm->flag_notif_adm=1;
    //                 $mail_adm->save();
                
    //         }
    //         return true; 
    //     })->everyMinute();

    //     $schedule->call(function () {
    //         date_default_timezone_set('Asia/Jakarta');
    //         $tanggal_now=CarbonImmutable::now();
    //         $tgl_last= $tanggal_now->addMinutes(5);

    //         $tgl_start = $tgl_last->format('Y-m-d H:i:s');
    //         $tgl_end = $tanggal_now->format('Y-m-d H:i:s');
    //         $data_email = Roomorder::whereBetween('tanggal_akhir', [$tgl_end,$tgl_start])->whereNull('flag_notif2')
    //         ->get();

    //         $role_user= BackendUser::where('role_id', '=', 4)->first();

    //         $penerima_email= []; 
    //         foreach($data_email as $mail){
                    
    //                 $penerima_email=[
    //                     'nama' => $mail->pengirim->first_name.' '. $mail->pengirim->last_name,
    //                     'room' => $mail->ruangan->room_name,
    //                     'agenda' => $mail->agenda_rapat,
    //                     'jadwal' => $mail->tanggal_awal. ' s/d '. $mail->tanggal_akhir,
    //                 ];

    //                 $penerima_notif=[
    //                     'nama' => $role_user->first_name.' '. $role_user->last_name,
    //                     'nama_peminjam' => $mail->pengirim->first_name.' '. $mail->pengirim->last_name,
    //                     'no_wa' => $mail->no_wa,
    //                     'room' => $mail->ruangan->room_name,
    //                     'jadwal' => $mail->tanggal_awal. ' s/d '. $mail->tanggal_akhir,
    //                 ];

    //                 $sender = $mail->pengirim->email; 
    //                 $ruang_rapat = $mail->ruangan->room_name; 

    //                 Mail::send('jamsyar.merapat::mail.notifberakhir', $penerima_email, function($message) use ($sender){
    //                     // $pengirim = $email->pengirim->email;
    //                     $message->from('devops@ext.jamsyar.id','Admin Meeting');
    //                     $message->subject('Reminder 5 menit sebelum peminjaman selesai!!!');
    //                     $message->to($sender);
    //                 });

    //                 Mail::send('jamsyar.merapat::mail.notifberakhiradmin', $penerima_notif, function($message) use ($role_user, $ruang_rapat){
    //                     // $pengirim = $email->pengirim->email;
    //                     $message->from('devops@ext.jamsyar.id','Admin Meeting');
    //                     $message->subject('Reminder 5 menit sebelum peminjaman '.$ruang_rapat. ' selesai!!!' );
    //                     $message->to($role_user->email);
    //                 });
    //                 // $data = Roomorder::flaq_email(1);
    //                 $mail->flag_notif2=1;
    //                 $mail->save();
    //         }
    //         return true;
    //     })->everyMinute();


    // }
}

