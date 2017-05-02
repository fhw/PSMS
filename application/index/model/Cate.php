<?php
/**
 * Created by PhpStorm.
 * User: fhw5629
 * Date: 2016/11/14
 * Time: 15:12
 */

namespace app\index\model;


use think\Db;
use think\Model;

class Cate extends Model
{
    static function getTree(&$data, $pid = 0, $count = 0)
    {
        if (!isset($data['odl'])) {
            $data = array('new' => array(), 'odl' => $data);
        }
        foreach ($data['odl'] as $k => $v) {
            if ($v['pid'] == $pid) {
                $v['count'] = $count;
                $data['new'][] = $v;
//                unset($data['odl'][$k]);
                self::getTree($data, $v['id'], $count + 1);
            }
        }
        return $data['odl'];
    }

    public function add_cate()
    {
//        $cate0=Db::table('cate')->where('pid',0)->find();
//        $cate1=Db::table('cate')->where('pid',$cate0['id'])->find();
//        $cate2=Db::table('cate')->where('pid',$cate1['id'])->select();
//        $cate3=Db::table('cate')->where('pid',$cate2[0]['id'])->select();
        //$cate4=Db::table('cate')->where('pid',$cate3['id'])->select();
        return Db::table('cate')->select();
    }

    public function delete_cate()
    {

    }

    public function select_cate()
    {

    }

    public function update_cate()
    {

    }
}