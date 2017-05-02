<?php
/**
 * Created by PhpStorm.
 * User: fhw56
 * Date: 2016/12/8 0008
 * Time: 19:18
 */

namespace app\index\model;


use think\Db;
use think\Model;

class ProductsOrders extends Model
{
    public function add($data)
    {
        return $this->save($data);
    }

    public function delete_by_order_id($order_id)
    {
        return $this->destroy($order_id);
    }

    public function edit($data,$id)
    {
        return $this->save($data,['id'=>$id]);
    }

    public function find_all()
    {
        return Db::table('order')
            ->alias('a')
            ->join('pet_products b','a.product_id=b.id')
            ->field('a.*,b.product_name')
            ->paginate(10);
    }

    public function find_by_id($id)
    {
        return $this->get($id);
    }

}