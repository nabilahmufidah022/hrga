<?php namespace Ppl\Hrga\Components;

use Cms\Classes\ComponentBase;
use BackendAuth;
use Flash;
use ApplicationException;



class LoginFe extends ComponentBase
{
    /**
     * Gets the details for the component
     */
    public function componentDetails()
    {
        return [
            'name'        => 'Hrga - Login Front End Component',
            'description' => 'Enable backend user to login using CMS Page on FE'
        ];
    }

    /**
     * Returns the properties provided by the component
     */
    public function defineProperties()
    {
        return [];
    }

    /**
     * 
     */
    public function onRun() 
    {
        $tpl = 'default';

        if(BackendAuth::check())  {// ambil informasi ada yang login atau engga
            return \Redirect::to(config('cms.backendUri'));
            // $user = BackendAuth::getUser();
            // if($user->agreement) {
            //     return \Redirect::to();
            // }
            // $tpl = 'agreement';
            
        }

        $this->beforeDefault();
        $content = $this->renderPartial(sprintf('@%s.htm',$tpl)); // untuk render page custom apa aja
        return \Response::make($content)->header('Content-Type', 'text/html');
    }

    protected function beforeDefault($params = []): void 
    {
        $this->page['appName'] = config('app.name');
        $this->page['urlResetPass'] = config('cms.backendUri') .'/backend/auth/restore';
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
    



}
