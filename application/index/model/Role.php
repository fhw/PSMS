<?php
/**
 * Created by PhpStorm.
 * User: FHW
 * Date: 2017/3/12
 * Time: 11:23
 */

namespace app\index\model;


use think\Model;

class Role extends Model
{
    public function access()
    {
        return $this->belongsToMany('Access','role_access','access_id','role_id');
    }

    public function admin()
    {
        return $this->belongsToMany('Admin','user_role','admin_id','role_id');
    }
}