<?php namespace Ppl\Hrga\Updates;

use Ppl\Hrga\Models\SystemSetting as SysSettingMdl;
use Winter\Storm\Database\Updates\Seeder;


class Dml005UpdateBackendBrandSettings extends Seeder
{
    public function run()
    {
        \log::info('do migration:' . __FILE__);

        $customCss = <<<HERED
                nav#layout-mainmenu.navbar {background-color:#2C3691;}
                .control-toolbar .toolbar-item-report {
                    position: relative;
                    white-space: nowrap;
                    display: table-cell;
                    vertical-align: top;
                    padding-right: 20px;
                }
                .control-breadcrumb li:after {
                    border-top: 22.5px solid transparent;
                    border-bottom: 22.5px solid transparent;
                    border-left: 15px solid #9098a2;
                } 
                .sidenav-tree ul.top-level>li>ul li a span.counter{
                    font-size:8pt !important;
                    display:block;
                    position:absolute;
                    top:1.071em;
                    padding:.143em .429em .214em .286em;
                    background-color:#d9350f;
                    color:#fff;
                    font-size:.786em;
                    line-height:100%;
                    -webkit-border-radius:3px;
                    -moz-border-radius:3px;
                    border-radius:3px;
                    opacity:1;
                    filter:alpha(opacity=100);
                    -webkit-transform:scale(1,);
                    -ms-transform:scale(1,);
                    transform:scale(1,);
                    -webkit-transition:all 0.3s;
                    transition:all 0.3s;
                }         
HERED;

        $contentPatch = [
            'app_name' =>  env("APP_NAME", "MERAPAT - PT Penjaminan Jamkrindo Syariah"),
            'app_tagline' => env("APP_TAGLINE", "Menjadi Perusahaan Penjaminan Syariah Terpercaya dan Terdepan dalam Pertumbuhan Bisnis di Indonesia"),
            'primary_color' => env("BACKEND_PRIMARY_COLOR", "#25396F"),
            'secondary_color' => env("BACKEND_SECONDARY_COLOR", "#E67E22"),
            'accent_color' => env("BACKEND_ACCENT_COLOR", "#3498DB"),
            'menu_mode' => env("BACKEND_MENU_MODE", "inline"),
            'default_colors' => [
                ['color' => '#1abc9c'],
                ['color' => '#16a085'],
                ['color' => '#2ecc71'],
                ['color' => '#27ae60'],
                ['color' => '#3498db'],
                ['color' => '#2980b9'],
                ['color' => '#9b59b6'],
                ['color' => '#8e44ad'],
                ['color' => '#34495e'],
                ['color' => '#2b3e50'],
                ['color' => '#f1c40f'],
                ['color' => '#f39c12'],
                ['color' => '#e67e22'],
                ['color' => '#d35400'],
                ['color' => '#e74c3c'],
                ['color' => '#c0392b'],
                ['color' => '#ecf0f1'],
                ['color' => '#bdc3c7'],
                ['color' => '#95a5a6'],
                ['color' => '#7f8c8d'],
            ],
            'custom_css' => $customCss,
        ];

        $value = json_encode($contentPatch);
        $itemName = "backend_brand_settings";
        $mdl = SysSettingMdl::where("item", $itemName)->first();
        if(!$mdl) {

            \Log::info('migration log:' . __FILE__, ["record does not exists"]);
            $new = new SysSettingMdl;
            $new->item = $itemName;
            $new->value = $value;
            $saved = $new->save();
            \Log::info('migration log:' . __FILE__, ["create record:", $saved]);
        } else {
            $mdl->item = $itemName;
            $mdl->value = $value;
            $saved = $mdl->save(); 
            \Log::info('migration log:' . __FILE__, ["update record:", $saved]);
        }

    }
}
