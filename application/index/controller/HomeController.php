<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;

/**
* fhw 2016-9-23 19:36
*/
class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $controller = request()->controller();
        $action     = request()->action();
        $url = "{$controller}/{$action}";
    }

	function home(){
        $data['user_name']=Session::get('user_name');
        $this->assign('data',$data);
	    return $this->fetch();
    }

    public function log_out()
    {
        Session::delete('user_name');
        Session::delete('password');
        $this->redirect('login/login');
    }
}