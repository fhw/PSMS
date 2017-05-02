<?php
/**
 * Created by PhpStorm.
 * User: fhw5629
 * Date: 2016/10/26
 * Time: 18:19
 */

namespace app\index\controller;


use app\index\model\Admin;
use think\Controller;
use think\Session;

class LoginController extends Controller
{
    public function login(){
        return $this->fetch();
    }

    public function is_login()
    {
            $admin_array = [
                "user_name" => $_POST['user_name'],
                "password" => $_POST['password'],
            ];

            $admin_model = new Admin();

            if($admin_model->auth_admin($admin_array) &&
                captcha_check($_POST['captcha']))
            {
                Session::set('user_name',$_POST['user_name']);
                Session::set('password',$_POST['password']);
                return '登陆成功';
            }
            else{
                if(!captcha_check($_POST['captcha'])){
                    return '验证码错误';
                }else{
                    if(!$admin_model->auth_admin($admin_array)){
                        return '账号或者密码错误';
                    }
                }
            }
    }
}