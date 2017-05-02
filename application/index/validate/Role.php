<?php
/**
 * Created by PhpStorm.
 * User: FHW
 * Date: 2017/3/16
 * Time: 12:00
 */

namespace app\index\validate;


use think\Validate;

class Role extends Validate
{
    protected $rule=[
        ['name','require','name不能为空'],
    ];
}