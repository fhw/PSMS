<?php
/**
 * Created by PhpStorm.
 * User: fhw5629
 * Date: 2016/11/23
 * Time: 14:40
 */

namespace app\index\model;

use think\Db;
use think\Model;

class Fostering extends Model
{

//    public function getStatusAttr($value)
//    {
//        $status=[0=>'寄养结束',1=>'寄养中'];
//        return $status[$value];
//    }

    /**
     * 添加一条寄养数据
     * @param $data 传入寄养数据数组
     * @return false|int
     */
    public function add_fostering($data)
    {
        return $this->save($data);
    }

    /**
     * 删除一条寄养数据
     * @param $data 传入要删除寄养数据的id
     * @return int
     */
    public function delete_fostering($data)
    {
        return $this->destroy($data);
    }

    /**
     * 修改一条寄养数据
     * @param $id
     * @param $data 传入寄养数据数组
     * @return false|int
     */
    public function update_fostering($id,$data)
    {
        return $this->save($data,['id'=>$id]);
    }

    public function find_fostering($id)
    {
        return Db::table('fostering')
            ->alias('a')
            ->join(['pet'=>'b'],'a.pet_id=b.id')
            ->field('a.id,a.pet_id,b.pet_name,a.start_date,a.finish_date,a.status,a.price,b.master')
            ->where('a.id',$id)
            ->find();
    }

    /**
     * 查询所有寄养数据
     * @return false|static[]
     */
    public function find_all_fostering()
    {
        return Db::table('fostering')
                ->alias('a')
                ->join(['pet'=>'b'],'a.pet_id=b.id')
                ->field('a.id,a.pet_id,b.pet_name,a.start_date,a.finish_date,a.status,a.price,b.master')
                ->paginate(10);
    }

    /**
     * @param $keyword
     * @return \think\paginator\Collection
     */
    public function find_by_keyword($keyword)
    {
        $map['a.id'] = ['like', '%' . $keyword . '%'];
        $map['b.id'] = ['like', '%' . $keyword . '%'];
        $map['b.pet_name'] = ['like', '%' . $keyword . '%'];
        $map['b.master'] = ['like', '%' . $keyword . '%'];
        return  Db::table('fostering')
            ->alias('a')
            ->join(['pet'=>'b'],'a.pet_id=b.id')
            ->field('a.id,a.pet_id,b.pet_name,a.start_date,a.finish_date,a.status,a.price,b.master')
            ->whereOr($map)
            ->paginate(20);
    }

    public function is_same_status($pet_id)
    {
        return $this->where(['pet_id'=>$pet_id,'status'=>'1'])->count();
    }

    public function find_pet($id)
    {
        return Db::table('fostering')
            ->where('pet_id',$id)
            ->count();
    }
}