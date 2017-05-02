<?php
/**
 * Created by PhpStorm.
 * User: fhw56
 * Date: 2017/3/24
 * Time: 11:16
 */

namespace app\index\controller;


use think\Controller;

class PublicController extends Controller
{
    public function no_access()
    {
        return $this->fetch();
    }
}