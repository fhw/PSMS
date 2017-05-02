<?php
/**
 * Created by PhpStorm.
 * User: fhw56
 * Date: 2016/12/8 0008
 * Time: 19:19
 */

namespace app\index\controller;


use app\index\model\Orders;

class OrdersController extends BaseController
{
    public function find_all()
    {
        $Order=new Orders();
        $data=$Order->find_all();
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function delete_by_order_id()
    {
        $Order=new Orders();
        $result=$Order->delete_by_order_id($_POST['orderid']);
        if ($result){
            $this->success('删除成功！','orders/find_all');
        }else{
            $this->error('删除失败！');
        }
    }

    public function edit($id)
    {
        $Order=new Orders();

        if (!empty($_POST)&&isset($_POST)){
            $result=$Order->edit($_POST,$id);
            if ($result){
                $this->success('删除成功！','orders/find_all');
            }else{
                $this->error('删除失败！');
            }
        }
        return $this->fetch();
    }
}