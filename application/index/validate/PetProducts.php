<?php
/**
 * Created by PhpStorm.
 * User: fhw5629
 * Date: 2016/10/20
 * Time: 10:22
 */

namespace app\index\validate;


use think\Validate;

class PetProducts extends Validate
{
    protected $rule = [
        'product_name|商品名' => 'require|max:25',
        'stock'=>'require',
        'price'=>'require',
    ];
}