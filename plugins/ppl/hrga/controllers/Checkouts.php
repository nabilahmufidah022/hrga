<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Checkouts Backend Controller
 */
class Checkouts extends Controller
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

        BackendMenu::setContext('Jamsyar.Merapat', 'userroomorders', 'checkouts');
    }

    public function formAfterSave($model) {
        $model->flaq_status = 4;
        $model->save();
    }
}
