<?php

namespace app\index\controller;

use think\Controller;

class IndexController extends BaseController
{
    public function index()
    {
        return $this->fetch('home/home');
    }
}
