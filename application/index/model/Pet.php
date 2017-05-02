<?php
/**
 * Created by PhpStorm.
 * User: fhw5629
 * Date: 2016/10/19
 * Time: 19:31
 */

namespace app\index\model;


use think\Db;
use think\Model;

class Pet extends Model
{

//    public function getIsHealthAttr($value)
//    {
//        $is_health=[1=>'健康',0=>'不健康'];
//        return $is_health[$value];
//    }
//
//    public function getIsOnsaleAttr($value)
//    {
//        $is_onsale=[1=>'出售',0=>'不出售'];
//        return $is_onsale[$value];
//    }

    /**
     * 添加一只宠物
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        return $this->save($data);
    }

    /**
     * 删除一只宠物
     * @param $id
     * @return int
     */
    public function delete_by_id($id)
    {
        return Pet::destroy($id);
    }

    /**
     * 查询所有宠物
     * @return false|static[]
     */
    public function select_all()
    {
        return Db::table('pet')
                ->alias('a')
                ->join('pet_type b','a.pet_type=b.id')
                ->field('a.*,b.pet_type_name')
                ->paginate(8);
    }

    public function find_by_id($id)
    {
        return $this->get($id);
    }

    public function select_by_keyword($data)
    {
        $map['id'] = ['like', '%' . $data . '%'];
        $map['pet_name'] = ['like', '%' . $data . '%'];
        $map['pet_type'] = ['like', '%' . $data . '%'];
        $map['age'] = ['like', '%' . $data . '%'];
        $map['master'] = ['like', '%' . $data . '%'];
        return Db::table('pet')->whereOr($map)->paginate(8);
    }

    public function select_by_id($id)
    {
        return Db::table('pet')
            ->alias('a')
            ->join('pet_type b','a.pet_type=b.id')
            ->field('a.*,b.pet_type_name')
            ->where('a.id',$id)
            ->find();
    }

    public function update_by_id($data,$id)
    {
        return $this->save($data,['id'=>$id]);
    }

    public function find_onsale()
    {
        return Db::table('pet')
            ->alias('a')
            ->join('pet_type b','a.pet_type=b.id')
            ->field('a.*,b.pet_type_name')
            ->where('is_onsale',1)
            ->paginate(8);
    }

    public function find_sold()
    {
        return Db::table('pet')
            ->alias('a')
            ->join('pet_type b','a.pet_type=b.id')
            ->field('a.*,b.pet_type_name')
            ->where('is_onsale',2)
            ->paginate(8);
    }


    /**
     * 添加价格
     * @param $price
     * @param $id
     * @return false|int
     */
    public function add_price($price, $id)
    {
        return $this->save(['price'=>$price],['id'=>$id]);
    }

    /**
     * 销售状态改成已销售
     * @param $id
     * @return false|int
     */
    public function sale_out($id)
    {
        return $this->save(['is_onsale'=>2],['id'=>$id]);
    }

    public function find_male()
    {
        return Db::table('pet')
            ->alias('a')
            ->join('pet_type b','a.pet_type=b.id')
            ->field('a.*,b.pet_type_name')
            ->where(['sex'=>'公','is_mating'=>1])
            ->paginate(8);
    }

    public function find_female()
    {
        return Db::table('pet')
            ->alias('a')
            ->join('pet_type b','a.pet_type=b.id')
            ->field('a.*,b.pet_type_name')
            ->where(['sex'=>'母','is_mating'=>1])
            ->paginate(8);
    }

    public function find_sex_by_id($id)
    {
        return $this->where('id',$id)->field('sex')->find();
    }

    public function find_type_by_id($id)
    {
        return $this->where('id',$id)->field('pet_type')->find();
    }

    public function match($id)
    {
        return Db::table('pet')
                ->alias('a')
                ->join('pet_type b','a.pet_type=b.id')
                ->field('a.*,b.pet_type_name')
                ->where('sex','<>',$this->find_sex_by_id($id)['sex'])
                ->where('pet_type','=',$this->find_type_by_id($id)['pet_type'])
                ->where('is_mating',1)
                ->where('is_onsale','<',2)
                ->paginate(8);
    }

    public function select_mating()
    {
        return Db::table('pet')
            ->alias('a')
            ->join('pet_type b','a.pet_type=b.id')
            ->field('a.*,b.pet_type_name')
            ->where('is_mating',1)
            ->paginate(8);
    }

    public function count_by_type_id($type_id)
    {
        return Db::table('pet')->where('pet_type',$type_id)->count();
    }
}