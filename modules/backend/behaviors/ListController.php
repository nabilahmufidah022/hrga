<?php namespace Backend\Behaviors;

use Lang;
use Event;
use Flash;
use ApplicationException;
use Backend\Classes\ControllerBehavior;

/**
 * Adds features for working with backend lists.
 *
 * This behavior is implemented in the controller like so:
 *
 *     public $implement = [
 *         \Backend\Behaviors\ListController::class,
 *     ];
 *
 *     public $listConfig = 'config_list.yaml';
 *
 * The `$listConfig` property makes reference to the list configuration
 * values as either a YAML file, located in the controller view directory,
 * or directly as a PHP array.
 *
 * @package winter\wn-backend-module
 * @author Alexey Bobkov, Samuel Georges
 */
class ListController extends ControllerBehavior
{
    /**
     * @var array List definitions, keys for alias and value for configuration.
     */
    protected $listDefinitions;

    /**
     * @var string The primary list alias to use. Default: list
     */
    protected $primaryDefinition;

    /**
     * @var \Backend\Classes\WidgetBase[] Reference to the list widget object.
     */
    protected $listWidgets = [];

    /**
     * @var \Backend\Classes\WidgetBase[] Reference to the toolbar widget objects.
     */
    protected $toolbarWidgets = [];

    /**
     * @var \Backend\Classes\WidgetBase[] Reference to the filter widget objects.
     */
    protected $filterWidgets = [];

    /**
     * @var array Configuration values that must exist when applying the primary config file.
     * - modelClass: Class name for the model
     * - list: List column definitions
     */
    protected $requiredConfig = ['modelClass', 'list'];

    /**
     * @var array Visible actions in context of the controller
     */
    protected $actions = ['index'];

    /**
     * @var mixed Configuration for this behaviour
     */
    public $listConfig = 'config_list.yaml';

    /**
     * Behavior constructor
     * @param \Backend\Classes\Controller $controller
     */
    public function __construct($controller)
    {
        parent::__construct($controller);

        /*
         * Extract list definitions
         */
        $config = $controller->listConfig ?: $this->listConfig;
        if (is_array($config)) {
            $this->listDefinitions = $config;
            $this->primaryDefinition = key($this->listDefinitions);
        }
        else {
            $this->listDefinitions = ['list' => $config];
            $this->primaryDefinition = 'list';
        }

        /*
         * Build configuration
         */
        $this->setConfig($this->listDefinitions[$this->primaryDefinition], $this->requiredConfig);
    }

    /**
     * Creates all the list widgets based on the definitions.
     * @return array
     */
    public function makeLists()
    {
        foreach ($this->listDefinitions as $definition => $config) {
            $this->listWidgets[$definition] = $this->makeList($definition);
        }

        return $this->listWidgets;
    }

    /**
     * Prepare the widgets used by this action
     * @return \Backend\Widgets\Lists
     */
    public function makeList($definition = null)
    {
        if (!$definition || !isset($this->listDefinitions[$definition])) {
            $definition = $this->primaryDefinition;
        }

        $listConfig = $this->controller->listGetConfig($definition);

        /*
         * Create the model
         */
        $class = $listConfig->modelClass;
        $model = new $class;
        $model = $this->controller->listExtendModel($model, $definition);

        /*
         * Prepare the list widget
         */
        $columnConfig = $this->makeConfig($listConfig->list);
        $columnConfig->model = $model;
        $columnConfig->alias = $definition;

        /*
         * Prepare the columns configuration
         */
        $configFieldsToTransfer = [
            'recordUrl',
            'recordOnClick',
            'recordsPerPage',
            'perPageOptions',
            'showPageNumbers',
            'noRecordsMessage',
            'defaultSort',
            'showSorting',
            'showSetup',
            'showCheckboxes',
            'showTree',
            'treeExpanded',
            'customViewPath',
        ];

        foreach ($configFieldsToTransfer as $field) {
            if (isset($listConfig->{$field})) {
                $columnConfig->{$field} = $listConfig->{$field};
            }
        }

        /*
         * List Widget with extensibility
         */
        $widget = $this->makeWidget(\Backend\Widgets\Lists::class, $columnConfig);

        $widget->bindEvent('list.extendColumnsBefore', function () use ($widget) {
            $this->controller->listExtendColumnsBefore($widget);
        });

        $widget->bindEvent('list.extendColumns', function () use ($widget) {
            $this->controller->listExtendColumns($widget);
        });

        $widget->bindEvent('list.extendQueryBefore', function ($query) use ($definition) {
            $this->controller->listExtendQueryBefore($query, $definition);
        });

        $widget->bindEvent('list.extendQuery', function ($query) use ($definition) {
            $this->controller->listExtendQuery($query, $definition);
        });

        $widget->bindEvent('list.extendRecords', function ($records) use ($definition) {
            return $this->controller->listExtendRecords($records, $definition);
        });

        $widget->bindEvent('list.injectRowClass', function ($record) use ($definition) {
            return $this->controller->listInjectRowClass($record, $definition);
        });

        $widget->bindEvent('list.overrideColumnValue', function ($record, $column, $value) use ($definition) {
            return $this->controller->listOverrideColumnValue($record, $column->columnName, $definition);
        });

        $widget->bindEvent('list.overrideHeaderValue', function ($column, $value) use ($definition) {
            return $this->controller->listOverrideHeaderValue($column->columnName, $definition);
        });

        $widget->bindToController();

        /*
         * Prepare the toolbar widget (optional)
         */
        if (isset($listConfig->toolbar)) {
            $toolbarConfig = $this->makeConfig($listConfig->toolbar);
            $toolbarConfig->alias = $widget->alias . 'Toolbar';
            $toolbarWidget = $this->makeWidget(\Backend\Widgets\Toolbar::class, $toolbarConfig);
            $toolbarWidget->bindToController();
            $toolbarWidget->cssClasses[] = 'list-header';

            /*
             * Link the Search Widget to the List Widget
             */
            if ($searchWidget = $toolbarWidget->getSearchWidget()) {
                $searchWidget->bindEvent('search.submit', function () use ($widget, $searchWidget) {
                    $widget->setSearchTerm($searchWidget->getActiveTerm(), true);
                    return $widget->onRefresh();
                });

                $widget->setSearchOptions([
                    'mode' => $searchWidget->mode,
                    'scope' => $searchWidget->scope,
                ]);

                // Find predefined search term
                $widget->setSearchTerm($searchWidget->getActiveTerm());
            }

            $this->toolbarWidgets[$definition] = $toolbarWidget;
        }

        /*
         * Prepare the filter widget (optional)
         */
        if (isset($listConfig->filter)) {
            $filterConfig = $this->makeConfig($listConfig->filter);

            $widget->cssClasses[] = 'list-flush';

            $filterConfig->alias = $widget->alias . 'Filter';
            $filterWidget = $this->makeWidget(\Backend\Widgets\Filter::class, $filterConfig);
            $filterWidget->bindToController();

            /*
            * Filter the list when the scopes are changed
            */
            $filterWidget->bindEvent('filter.update', function () use ($widget, $filterWidget) {
                return $widget->onFilter();
            });

            /*
            * Filter Widget with extensibility
            */
            $filterWidget->bindEvent('filter.extendScopes', function () use ($filterWidget) {
                $this->controller->listFilterExtendScopes($filterWidget);
            });

            /*
            * Extend the query of the list of options
            */
            $filterWidget->bindEvent('filter.extendQuery', function ($query, $scope) {
                $this->controller->listFilterExtendQuery($query, $scope);
            });

            // Apply predefined filter values
            $widget->addFilter([$filterWidget, 'applyAllScopesToQuery']);

            $this->filterWidgets[$definition] = $filterWidget;
        }

        return $widget;
    }

    /**
     * Index Controller action.
     * @return void
     */
    public function index()
    {
        $this->controller->pageTitle = $this->controller->pageTitle ?: Lang::get($this->getConfig(
            'title',
            'backend::lang.list.default_title'
        ));
        $this->controller->bodyClass = 'slim-container';
        $this->makeLists();
    }

    /**
     * Bulk delete records.
     * @return void
     * @throws \Winter\Storm\Exception\ApplicationException when the parent definition is missing.
     */
    public function index_onDelete()
    {
        if (method_exists($this->controller, 'onDelete')) {
            return call_user_func_array([$this->controller, 'onDelete'], func_get_args());
        }

        /*
         * Establish the list definition
         */
        $definition = post('definition', $this->primaryDefinition);

        if (!isset($this->listDefinitions[$definition])) {
            throw new ApplicationException(Lang::get('backend::lang.list.missing_parent_definition', compact('definition')));
        }

        $listConfig = $this->controller->listGetConfig($definition);

        /*
         * Validate checked identifiers
         */
        $checkedIds = post('checked');

        if (!$checkedIds || !is_array($checkedIds) || !count($checkedIds)) {
            Flash::error(Lang::get(
                (!empty($listConfig->noRecordsDeletedMessage))
                    ? $listConfig->noRecordsDeletedMessage
                    : 'backend::lang.list.delete_selected_empty'
            ));
            return $this->controller->listRefresh();
        }

        /*
         * Create the model
         */
        $class = $listConfig->modelClass;
        $model = new $class;
        $model = $this->controller->listExtendModel($model, $definition);

        /*
         * Create the query
         */
        $query = $model->newQuery();
        $this->controller->listExtendQueryBefore($query, $definition);

        $query->whereIn($model->getKeyName(), $checkedIds);
        $this->controller->listExtendQuery($query, $definition);

        /*
         * Delete records
         */
        $records = $query->get();

        if ($records->count()) {
            foreach ($records as $record) {
                $record->delete();
            }

            Flash::success(Lang::get(
                (!empty($listConfig->deleteMessage))
                    ? $listConfig->deleteMessage
                    : 'backend::lang.list.delete_selected_success'
            ));
        }
        else {
            Flash::error(Lang::get(
                (!empty($listConfig->noRecordsDeletedMessage))
                    ? $listConfig->noRecordsDeletedMessage
                    : 'backend::lang.list.delete_selected_empty'
            ));
        }

        return $this->controller->listRefresh($definition);
    }

    /**
     * Renders the widget collection.
     * @param  string $definition Optional list definition.
     * @return string Rendered HTML for the list.
     * @throws \Winter\Storm\Exception\ApplicationException when there are no list widgets set.
     */
    public function listRender($definition = null)
    {
        if (!count($this->listWidgets)) {
            throw new ApplicationException(Lang::get('backend::lang.list.behavior_not_ready'));
        }

        if (!$definition || !isset($this->listDefinitions[$definition])) {
            $definition = $this->primaryDefinition;
        }

        $vars = [
            'toolbar' => null,
            'filter' => null,
            'list' => null,
        ];

        if (isset($this->toolbarWidgets[$definition])) {
            $vars['toolbar'] = $this->toolbarWidgets[$definition];
        }

        if (isset($this->filterWidgets[$definition])) {
            $vars['filter'] = $this->filterWidgets[$definition];
        }

        $vars['list'] = $this->listWidgets[$definition];

        return $this->listMakePartial('container', $vars);
    }

    /**
     * Controller accessor for making partials within this behavior.
     * @param string $partial
     * @param array $params
     * @return string Partial contents
     */
    public function listMakePartial($partial, $params = [])
    {
        $contents = $this->controller->makePartial('list_'.$partial, $params + $this->vars, false);
        if (!$contents) {
            $contents = $this->makePartial($partial, $params);
        }

        return $contents;
    }

    /**
     * Refreshes the list container only, useful for returning in custom AJAX requests.
     *
     * @return array The list element selector as the key, and the list contents are the value.
     */
    public function listRefresh(string $definition = null)
    {
        if (!count($this->listWidgets)) {
            $this->makeLists();
        }

        if (!$definition || !isset($this->listDefinitions[$definition])) {
            $definition = $this->primaryDefinition;
        }

        return $this->listWidgets[$definition]->onRefresh();
    }

    /**
     * Returns the widget used by this behavior.
     * @return \Backend\Classes\WidgetBase
     */
    public function listGetWidget(string $definition = null)
    {
        if (!$definition) {
            $definition = $this->primaryDefinition;
        }

        return array_get($this->listWidgets, $definition);
    }

    /**
     * Returns the configuration used by this behavior.
     * @return stdClass
     */
    public function listGetConfig(string $definition = null)
    {
        if (!$definition) {
            $definition = $this->primaryDefinition;
        }

        if (
            !($config = array_get($this->listDefinitions, $definition))
            || !is_object($config)
        ) {
            $config = $this->listDefinitions[$definition] = $this->makeConfig($this->listDefinitions[$definition], $this->requiredConfig);
        }

        return $config;
    }

    //
    // Overrides
    //

    /**
     * Called before the list columns are defined.
     * @param \Backend\Widgets\Lists $host The hosting list widget
     * @return void
     */
    public function listExtendColumnsBefore($host)
    {
    }

    /**
     * Called after the list columns are defined.
     * @param \Backend\Widgets\Lists $host The hosting list widget
     * @return void
     */
    public function listExtendColumns($host)
    {
    }

    /**
     * Called after the filter scopes are defined.
     * @param \Backend\Widgets\Filter $host The hosting filter widget
     * @return void
     */
    public function listFilterExtendScopes($host)
    {
    }

    /**
     * Controller override: Extend supplied model
     * @param \Winter\Storm\Database\Model $model
     * @param string|null $definition
     * @return \Winter\Storm\Database\Model
     */
    public function listExtendModel($model, $definition = null)
    {
        return $model;
    }

    /**
     * Controller override: Extend the query used for populating the list
     * before the default query is processed.
     * @param \Winter\Storm\Database\Builder $query
     * @param string|null $definition
     */
    public function listExtendQueryBefore($query, $definition = null)
    {
    }

    /**
     * Controller override: Extend the query used for populating the list
     * after the default query is processed.
     * @param \Winter\Storm\Database\Builder $query
     * @param string|null $definition
     */
    public function listExtendQuery($query, $definition = null)
    {
    }

    /**
     * Controller override: Extend the records used for populating the list
     * after the query is processed.
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection $records
     * @param string|null $definition
     */
    public function listExtendRecords($records, $definition = null)
    {
    }

    /**
     * Controller override: Extend the query used for populating the filter
     * options before the default query is processed.
     * @param \Winter\Storm\Database\Builder $query
     * @param array $scope
     */
    public function listFilterExtendQuery($query, $scope)
    {
    }

    /**
     * Returns a CSS class name for a list row (<tr class="...">).
     * @param  \Winter\Storm\Database\Model $record The populated model used for the column
     * @param  string|null $definition List definition (optional)
     * @return string|void CSS class name
     */
    public function listInjectRowClass($record, $definition = null)
    {
    }

    /**
     * Replace a table column value (<td>...</td>)
     * @param  \Winter\Storm\Database\Model $record The populated model used for the column
     * @param  string $columnName The column name to override
     * @param  string|null $definition List definition (optional)
     * @return string|void HTML view
     */
   public function listOverrideColumnValue($record, $columnName, $definition = null)
{
    if ($columnName === 'status_kehadiran') {
        $colors = [
            'hadir' => 'background-color:#007bff; color:white;',    // biru
            'sakit' => 'background-color:#ffc107; color:black;',    // kuning
            'izin' => 'background-color:#28a745; color:white;',     // hijau
            'cuti' => 'background-color:#28a745; color:white;',     // hijau
            'tidak hadir' => 'background-color:#dc3545; color:white;', // merah
        ];

        $value = $record->status_kehadiran;
        $style = $colors[$value] ?? 'background-color:#6c757d; color:white;'; // default abu

        return "<span style='padding:4px 10px; border-radius:4px; {$style}'>" . ucfirst($value) . "</span>";
    }

    // Untuk kolom lain, biarkan default
    return null;
}


    /**
     * Replace the entire table header contents (<th>...</th>) with custom HTML
     * @param  string $columnName The column name to override
     * @param  string|null $definition List definition (optional)
     * @return string|void HTML view
     */
    public function listOverrideHeaderValue($columnName, $definition = null)
    {
    }

    /**
     * Static helper for extending list columns.
     * @param  callable $callback
     * @return void
     */
    public static function extendListColumns($callback)
    {
        $calledClass = self::getCalledExtensionClass();
        Event::listen('backend.list.extendColumns', function (\Backend\Widgets\Lists $widget) use ($calledClass, $callback) {
            if (!is_a($widget->getController(), $calledClass)) {
                return;
            }
            call_user_func_array($callback, [$widget, $widget->model]);
        });
    }

    /**
     * Static helper for extending filter scopes.
     * @param  callable $callback
     * @return void
     */
    public static function extendListFilterScopes($callback)
    {
        $calledClass = self::getCalledExtensionClass();
        Event::listen('backend.filter.extendScopes', function (\Backend\Widgets\Filter $widget) use ($calledClass, $callback) {
            if (!is_a($widget->getController(), $calledClass)) {
                return;
            }
            call_user_func_array($callback, [$widget]);
        });
    }
}
