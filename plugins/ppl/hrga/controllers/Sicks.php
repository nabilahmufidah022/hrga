<?php namespace Ppl\Hrga\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Sicks Backend Controller
 */
class Sicks extends Controller
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
    protected $requiredPermissions = [
        'ppl.hrga.sicks.manage_all',
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ppl.Hrga', 'hrga', 'sick');
    }

    public $model = 'Ppl\Hrga\Models\Sick';

    public function listExtendQuery($query)
    {
        $query->with('list'); // eager load SickList relation
    }
    public function listExtendColumns($list)
{
    // Add the 'status_list' column to the list view
    $list->addColumns([
        'status_list' => [
            'label' => 'Status',
            'sortable' => false,  // We don't need it to be sortable
            'type' => 'text',     // This will render the text values
            'valueFrom' => function($record) {
                return $record->status_list;  // This accesses the accessor
            }
        ]
    ]);
}
}
