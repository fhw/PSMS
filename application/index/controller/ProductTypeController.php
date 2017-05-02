<?php
/**
 * Created by PhpStorm.
 * User: fhw5629
 * Date: 2016/10/19
 * Time: 1:51
 */

namespace app\index\controller;


use app\index\model\PetProducts;
use app\index\model\ProductType;
use think\Controller;
use think\Db;

class ProductTypeController extends BaseController
{

//    public static $producttype;

    public function insert()
    {
        if (!empty($_POST) && isset($_POST)) {
            if (!empty($_POST['type_name']) && isset($_POST['type_name'])) {
                $ProductType = new ProductType();
                if (Db::table('product_type')->where('type_name', $_POST['type_name'])->count() == 0) {
                    $result = $ProductType->data($_POST)->save();
                    if ($result) {
                        $this->success('修改成功');
                    } else {
                        $this->error('修改失败');
                    }
                } else {
                    $msg = "已存在该类型！";
                    $this->error($msg);
                }
            } else {
                $this->error("请输入内容!");
            }
        }
        return $this->fetch();
    }

    public function select()
    {
        $ProductType = new ProductType();
        $producttype = $ProductType->paginate(10);
        $this->assign("producttype", $producttype);
        return $this->fetch();
    }

    public function select_all()
    {
        $ProductType = new ProductType();
        $producttype = $ProductType->select();
        $this->assign("producttype", $producttype);
        return $this->fetch();
    }

    public function find_by_keyword($keyword)
    {
        $ProductType = new ProductType();
        $producttype = $ProductType->where('type_name', 'like', '%' . $keyword . '%')
            ->paginate(10);
        $this->assign("producttype", $producttype);
        return $this->fetch('select');
    }

    public function update($type_id)
    {
        $ProductType = new ProductType();
        $data = $ProductType->get($type_id);
        if (!empty($_POST) && isset($_POST)) {
            if (!empty($_POST['type_name']) && isset($_POST['type_name'])) {
                if (Db::table('product_type')->where('type_name', $_POST['type_name'])->count() == 0) {
                    $result = $ProductType->save($_POST, ['type_id' => $type_id]);
                    if ($result) {
                        $this->success('修改成功');
                    } else {
                        $this->error('修改失败');
                    }
                } else {
                    $msg = "已存在该类型！";
                    $this->error($msg);
                }
            } else {
                $this->error("请输入内容!");
            }
        }
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function delete_by_id($id)
    {
        $PetProducts = new PetProducts();
        $result = $PetProducts->find_by_type_id($id);
        if ($result == 0) {
            $producttype = db('product_type')->delete($id);
            if ($producttype) {
                $this->success('删除成功', 'product_type/select');
            } else {
                $this->error('删除失败');
            }
        } else {
            $this->error("该分类下含有商品，无法删除！");
        }

    }
}