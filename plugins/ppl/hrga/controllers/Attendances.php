<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Winter\Storm\Support\Facades\DB;

/**
 * Attendances Backend Controller
 */
class Attendances extends Controller
{
    protected $partialsDir = 'ppl/hrga/partials/';
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

        BackendMenu::setContext('Ppl.Hrga', 'homes', 'userroomorders', 'attendances');
    }

    public function formAfterSave($model){
        $data= input();
        
        $upload_kehadiran = DB::table('system_files as document')->select('document.*')->where('attachment_id', $model->id)->where('field', 'kehadiran')->first();
        $link = $data['Userroomorder']['link_kehadiran'];
        // dd($link);
        if( $link == NULL && $upload_kehadiran == NULL){
            // throw new ApplicationException('Nomor rekening sudah ada. Mohon untuk input rekening tersimpan!!');
            throw new \Winter\Storm\Exception\ValidationException
                ([
                    'kehadiran' => 'Kehadiran ini harus diisi!!'
                ]);
            }
            // elseif($link == NULL || $upload_kehadiran != NULL){
            //     throw new \Winter\Storm\Exception\ValidationException
            //     ([
            //         'kehadiran' => 'Kehadiran cob harus diisi!!'
            //     ]);
            // }
           
        // dd($link == "", $upload_kehadiran == NULL);
        $model->flag_attendance	= 1;
        $model->save(); 
    }
}
