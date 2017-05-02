<?php
/**
 * Created by PhpStorm.
 * User: fhw5629
 * Date: 2016/10/26
 * Time: 16:20
 */

namespace app\index\model;


use think\Db;
use think\Model;

class Admin extends Model
{
    /**
     * 用户登陆判断
     * @param $admin_array
     * @return bool
     */
    public function auth_admin($admin_array)
    {
        $sql = sprintf("SELECT COUNT(`admin`.`id`) AS `count` FROM `admin`
                        WHERE `admin`.`user_name` = '%s' AND `admin`.`password` = '%s';", $admin_array['user_name'], $admin_array['password']);

        $user = Db::query($sql);

        if(count($user) == 0)
        {
            return false;
        }
        else
        {
            return $user[0]['count'] == 1 ? true : false;
        }
    }

    public function is_same_admin($user_name)
    {
        return $this->where('user_name',$user_name)->count();
    }

    public function add($data)
    {
        return $this->save($data);
    }

    public function delete_by_id($id)
    {
        return $this->destroy($id);
    }

    public function update_by_id($data,$id)
    {
        return $this->update($data,['id'=>$id]);
    }

    public function get_admin($id)
    {
        return $this->get($id);
    }

    /**
     * 获取admin列表
     * @param $id
     * @return false|static[]
     */
    public function all_admin(){
        return $this->all();
    }

    public function role()
    {
        return $this->belongsToMany('Role','user_role','role_id','admin_id');
    }
}