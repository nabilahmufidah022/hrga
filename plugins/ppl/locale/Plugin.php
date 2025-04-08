<?php namespace Ppl\Locale;

use Backend;
use Backend\Models\UserRole;
use System\Classes\PluginBase;

/**
 * Locale Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     */
    public function pluginDetails(): array
    {
        return [
            'name'        => 'ppl.locale::lang.plugin.name',
            'description' => 'ppl.locale::lang.plugin.description',
            'author'      => 'Ppl',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register(): void
    {

    }

    /**
     * Boot method, called right before the request route.
     */
    public function boot(): void
    {

    }

    /**
     * Registers any frontend components implemented in this plugin.
     */
    public function registerComponents(): array
    {
        return []; // Remove this line to activate

        return [
            'Ppl\Locale\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any backend permissions used by this plugin.
     */
    public function registerPermissions(): array
    {
        return []; // Remove this line to activate

        return [
            'ppl.locale.some_permission' => [
                'tab' => 'ppl.locale::lang.plugin.name',
                'label' => 'ppl.locale::lang.permissions.some_permission',
                'roles' => [UserRole::CODE_DEVELOPER, UserRole::CODE_PUBLISHER],
            ],
        ];
    }

    /**
     * Registers backend navigation items for this plugin.
     */
    public function registerNavigation(): array
    {
        return []; // Remove this line to activate

        return [
            'locale' => [
                'label'       => 'ppl.locale::lang.plugin.name',
                'url'         => Backend::url('ppl/locale/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['ppl.locale.*'],
                'order'       => 500,
            ],
        ];
    }
}
