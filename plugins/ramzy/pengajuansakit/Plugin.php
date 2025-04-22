<?php namespace Ramzy\Pengajuansakit;

use System\Classes\PluginBase;
use Backend;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            \ramzy\pengajuansakit\Components\FormPengajuanSakit::class => 'formPengajuanSakit'
        ];
    }

    public function registerSettings()
    {
    }

    public function registerNavigation(): array
    {

        return [
            'simpleweb' => [
                'label'       => 'ramzy.pengajuansakit::lang.plugin.name',
                'url'         => Backend::url('ramzy/pengajuansakit/formpengajuansakit'),
                'icon'        => 'icon-leaf',
                'permissions' => ['ramzy.pengajuansakit.*'],
                'order'       => 500,
            ],
        ];
    }
}
