<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Ppl\Hrga\Models\Userroomorder as roomorder;

/**
 * Meetingroomlists Backend Controller
 */
class Meetingroomlists extends Controller
{
    protected $partialsDir = 'ppl/hrga/partials/';
    public $requiredPermissions = ['ppl.hrga.peminjaman.listruangrapat'];
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

        BackendMenu::setContext('Ppl.Hrga', 'homes', 'meetingroomlists');
    }
}
