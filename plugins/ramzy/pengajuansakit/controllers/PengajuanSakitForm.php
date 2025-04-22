<?php namespace Ramzy\Pengajuansakit\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class PengajuanSakitForm extends Controller
{
    public $implement = [        'Backend\Behaviors\FormController'    ];
    
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Ramzy.Pengajuansakit', 'main-menu-item');
    }
}
