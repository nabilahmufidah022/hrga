<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Ppl\Hrga\Models\Personal as datadiri;

/**
 * Personals Backend Controller
 */
class Personals extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    /**
     * @var array Permissions required to view this page.
     */
    protected $partialsDir = 'ppl/hrga/partials/'; 
    protected $requiredPermissions = [
        'ppl.hrga.absensi.biodatadiri',
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ppl.Hrga', 'homes', 'personals');
    }
}
