<?php namespace Ramzy\Pengajuansakit\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class PengajuanSakit extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];
    
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Ramzy.Pengajuansakit', 'pengajuansakit','formpengajuansakit');
    }
}
