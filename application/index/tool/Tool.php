<?php
/**
 * Created by PhpStorm.
 * User: fhw5629
 * Date: 2016/11/16
 * Time: 10:18
 */

namespace app\index\tool;


class Tool
{
    //图片上传函数
    public function upload()
    {
        // 获取表单上传文件
        $file = request()->file('photo');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['image'=>$file])->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
        if ($info) {
            $upload_filepath = DS . 'phpdemo' . DS . 'psms' . DS . 'public' . DS . 'static' . DS . 'uploads' . DS . $info->getSaveName();
            return $upload_filepath;
        } else {
            echo $file->getError();
        }
    }
    
}