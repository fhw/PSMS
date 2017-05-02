<?php
/**
 * Created by PhpStorm.
 * User: fhw5629
 * Date: 2016/11/21
 * Time: 10:25
 */

namespace app\index\controller;


use app\index\model\Admin;
use app\index\model\Role;
use think\Controller;

class BaseController extends Controller
{
    public function __construct()
    {

        parent::__construct();
//        if (!empty(session('user_name')) && !empty(session('password'))) {
//
//        }else{
//            $this->error('请先登陆','login/login');
//        }
    }

    public function _initialize()
    {
        if (in_array(request()->action(), array('login')) || in_array(request()->controller(), array('Login'))) {

        } else {
            if (!empty(session('user_name')) && !empty(session('password'))) {
                $this->check_priv();
            } else {
                $this->error('请先登陆', 'login/login');
            }
        }
    }

    //权限判断
    public function check_priv()
    {
        $ctl = $this->toUnderScore(request()->controller());
        $admin = Admin::getByUserName(session('user_name'));
        $roles = $admin->role;

        $roles_id = [];
        for ($i = 0; $i < count($roles); $i++) {
            $roles_id[$i] = $roles[$i]->id;
        }

        $role = Role::with('access')->select($roles_id);
        $access_data = [];
        foreach ($role as $item1) {
            foreach ($item1->access as $key => $item2) {
                $access_data[$key] = $item2->uris;
            }
        }

        if ($ctl == "home") {
            return true;
        } else {
            if (in_array($ctl, $access_data)) {
                return true;
            } else {
                $this->redirect('public/no_access');
            }
        }
    }

    //驼峰命名法转下划线命名法
    public function toUnderScore($str)
    {

        $array = array();
        for ($i = 0; $i < strlen($str); $i++) {
            if ($str[$i] == strtolower($str[$i])) {
                $array[] = $str[$i];
            } else {
                if ($i > 0) {
                    $array[] = '_';
                }
                $array[] = strtolower($str[$i]);
            }
        }

        $result = implode('', $array);
        return $result;
    }

}