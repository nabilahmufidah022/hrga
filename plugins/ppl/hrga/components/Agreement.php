<?php namespace Ppl\Hrga\Components;

use Cms\Classes\ComponentBase;
use Ppl\Links\Models\Userlink;
use BackendAuth;

class Agreement extends ComponentBase
{
    /**
     * Gets the details for the component
     */
    public function componentDetails()
    {
        return [
            'name'        => 'Agreement Component',
            'description' => 'No description provided yet...'
        ];
    }

    /**
     * Returns the properties provided by the component
     */
    public function defineProperties()
    {
        return [];
    }

    // public function onRun()
    // {
    //     $user = BackendAuth::getUser();
    //     dd($user);
    // }

    // public function onRun()
    // {
    //     // This code will be executed when the page or layout is
    //     // loaded and the component is attached to it.
    //     $fallbackUrl = "https://jamkrindosyariah.co.id/";
    //     $qs = trim($this->param('qs'));
    //     // $this->page['qs'] = $this->param('qs'); // Inject some variable to the page
    //     if(!$qs) {

    //         header("Location: {$fallbackUrl}");
    //         die();
    //         // return;
    //     }

    //     $userlink = Userlink::where('code', urldecode($qs))->where('active_status', 1)->first();
    //     if(!$userlink) {
    //         header("Location: {$fallbackUrl}");
    //         die();
    //         // return;
    //     }
        
    //     $url = $userlink->target; 
        
    //     header("Location: {$url}");
    //     die();
    // }
}

