<?php
/**
 * Created by PhpStorm.
 * User: FHW
 * Date: 2017/3/12
 * Time: 11:24
 */

namespace app\index\model;

use think\Model;

class Access extends Model
{

    public function roles()
    {
        return $this->belongsToMany('Role','role_access','role_id','access_id');
    }
}