<?php
/**
 * Created by PhpStorm.
 * User: fhw56
 * Date: 2016/12/2 0002
 * Time: 13:36
 */

namespace app\index\model;

use think\Db;
use think\Model;

class Mating extends Model
{
    public function add($data)
    {
        return $this->save($data);
    }

    public function delete_by_id($id)
    {
        return $this->destroy($id);
    }

    public function find_by_id($id)
    {
        return Db::table('mating')
            ->alias('a')
            ->join('pet b','a.male_pet_id=b.id')
            ->join('pet c','a.female_pet_id=c.id')
            ->field('a.*,b.id as male_id,c.id as female_id,b.pet_name as male_pet_name,c.pet_name as female_pet_name')
            ->where('a.id',$id)
            ->find();
    }

    public function find_by_create_time($time)
    {
        return Db::table('mating')
            ->alias('a')
            ->join('pet b','a.male_pet_id=b.id')
            ->join('pet c','a.female_pet_id=c.id')
            ->field('a.*,b.id as male_id,c.id as female_id,b.pet_name as male_pet_name,c.pet_name as female_pet_name')
            ->where('create_time',$time)
            ->find();
    }

    public function find_all()
    {
        return Db::table('mating')
                ->alias('a')
                ->join('pet b','a.male_pet_id=b.id')
                ->join('pet c','a.female_pet_id=c.id')
                ->field('a.*,b.id as male_id,c.id as female_id,b.pet_name as male_pet_name,c.pet_name as female_pet_name')
                ->paginate(10);
    }

    public function update_by_id($data,$id)
    {
        return Db::table('mating')
            ->where('id',$id)
            ->update($data);
    }

    public function find_pet_id($id)
    {
        return Db::table('mating')
            ->where('male_pet_id',$id)
            ->whereOr('female_pet_id',$id)
            ->count();
    }

    public function is_same_data($female_pet_id,$male_pet_id)
    {
        return Db::table('mating')
            ->where('female_pet_id',$female_pet_id)
            ->where('male_pet_id',$male_pet_id)
            ->where('is_mating',0)
            ->count();
    }

}