<?php
/**
 * Created by PhpStorm.
 * User: FHW
 * Date: 2017/3/15
 * Time: 16:51
 */

namespace app\index\validate;


use think\Validate;

class Access extends Validate
{
    protected $rule=[
      ['title','require','title不能为空'],
        ['uris','require','uri不能为空'],
    ];
}