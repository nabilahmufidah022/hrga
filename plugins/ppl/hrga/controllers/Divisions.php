<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Divisions Backend Controller
 */
class Divisions extends Controller
{
    protected $partialsDir = 'ppl/hrga/partials/';
    public $requiredPermissions = ['ppl.hrga.peminjaman.divisi'];
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

        BackendMenu::setContext('Ppl.Hrga', 'homes', 'divisions');
    }
    
}
