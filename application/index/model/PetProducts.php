<?php
/**
 * Created by PhpStorm.
 * User: fhw5629
 * Date: 2016/10/17
 * Time: 10:26
 */

namespace app\index\model;


use think\Db;
use think\Model;

class PetProducts extends Model
{
    /**
     * 根据type_id查找对应的商品
     * @param $type_id
     * @return int（返回0则代表该分类下没有商品）
     */
    public function find_by_type_id($type_id)
    {
        $result=Db::table('pet_products')
                        ->where('type_id',$type_id)
                        ->count();
        return $result;
    }

    public function find_by_id($id)
    {
        return $this->get($id);
    }

    /**
     * 出入库
     * @param $stock
     * @param $id
     * @return false|int
     */
    public function edit_stock($stock, $id)
    {
        return $this->save(['stock'=>$stock],['id'=>$id]);
    }
}