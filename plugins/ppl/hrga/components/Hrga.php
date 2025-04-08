<?php namespace Ppl\Hrga\Components;

use Cms\Classes\ComponentBase;
use Ppl\Links\Models\Userlink;
use Backend\Models\User as BackendUser;
use BackendAuth;
use Flash;
use ApplicationException;
// use Auth;

class Hrga extends ComponentBase
{
    /**
     * Gets the details for the component
     */
    public function componentDetails()
    {
        return [
            'name'        => 'Merapat Login Component',
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

    public function onRun()
    {
        $tpl = 'default';
        if(BackendAuth::check())  {// ambil informasi ada yang login atau engga
            $user = BackendAuth::getUser();
            if($user->agreement) {
                return \Redirect::to("/ppl-link");
            }
            $tpl = 'agreement';
            
        }
        
        $content = $this->renderPartial(sprintf('@%s.htm',$tpl)); // untuk render page custom apa aja
        return \Response::make($content)->header('Content-Type', 'text/html');
    }

    public function onLogin()
    {
        $rules = [
            'login'    => 'required',
            'password' => 'required'
        ];

        $validation = \Validator::make(post(), $rules);
        if ($validation->fails()) {
            $err = $validation->messages();
            Flash::error($err->first());
            return;
        }

        if (is_null($remember = \Config::get('cms.backendForceRemember', true))) {
            $remember = (bool) post('remember');
        }

        // Authenticate user
        $user = BackendAuth::authenticate([
            'login' => post('login'),
            'password' => post('password')
        ], $remember);
        Flash::info(sprintf('Welcome %s', $user->first_name));
        return \Redirect::refresh();
    }

    public function onSignOut()
    {
        Flash::warning('Thank you for your confirmation! We will redirect you back to the sign in page.');
        BackendAuth::logout();
        return \Redirect::refresh();
    }

    public function onAgree()
    {
        $user = BackendAuth::getUser();
        $user->agreement = 1;
        $user->save();
        Flash::warning('Thank you for your confirmation!');
        return \Redirect::refresh();
    }
}
