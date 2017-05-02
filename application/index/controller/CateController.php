<?php
/**
 * Created by PhpStorm.
 * User: fhw5629
 * Date: 2016/11/14
 * Time: 15:12
 */

namespace app\index\controller;


use app\index\model\Cate;
use think\Controller;

class CateController extends BaseController
{
    public function add()
    {
        $cate=new Cate();
        $data=$cate->add_cate();
        $result=$cate->getTree($data);
        $max_count=0;
//        for ($i=0;$i<count($result)-1;$i++){
//            if($result[$i]['count']<$result[$i+1]['count'])
//            {
//                $max_count=$result[$i+1]['count'];
//            }
//        }
//        echo $max_count;

        echo "<pre>";
        print_r($result);
        $this->assign('result',$result);
        return $this->fetch("cate/cate");
    }
}