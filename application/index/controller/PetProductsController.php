<?php
/**
 * Created by PhpStorm.
 * User: fhw5629
 * Date: 2016/10/17
 * Time: 10:28
 */

namespace app\index\controller;


use app\index\tool\Tool;
use think\Controller;
use app\index\model\PetProducts;
use think\Db;
use think\Loader;

class PetProductsController extends BaseController
{
    public function insert_view()
    {
        $ProductTypeController = new ProductTypeController();
        $ProductTypeController->select_all();
        return $this->fetch();
    }

    //插入一条PetProducts数据
    public function insert()
    {
        $PetProducts = new PetProducts();
            if (!empty($_FILES['photo']['name']) && isset($_FILES['photo']['name'])) {
                //先上传商品图片
                $tool = new Tool();
                $upload_filename = $tool->upload();
                //给出商品图片的完整相对路径
                $_POST['photo'] = $upload_filename;
            }
            //插入该数据到数据库
            $result = $PetProducts->save($_POST);

            if ($result) {
                //设置成功后跳转页面的地址，默认的返回页面是$_SERVER['HTTP_REFERER']
                $this->success('新增成功', 'pet_products/select?p=select');
            } else {
                //错误页面的默认跳转页面是返回前一页，通常不需要设置
                $this->error('添加失败！');
            }
    }


//    查询所有商品
    public function select($p)
    {
        $petproducts = Db::table('pet_products')
            ->alias('a')
            ->join('product_type b', 'a.type_id=b.type_id')
            ->paginate(10,false,['query'=>array('p'=>$p)]);
        $this->assign('petproducts', $petproducts);
        return $this->fetch($p);
    }

//    模糊查询
    public function select_by_keyword($p)
    {
        if (!empty($_POST['keyword']) && isset($_POST['keyword'])) {
            $map['a.id'] = ['like', '%' . $_POST['keyword'] . '%'];
            $map['a.product_name'] = ['like', '%' . $_POST['keyword'] . '%'];
            $map['b.type_name'] = ['like', '%' . $_POST['keyword'] . '%'];
            $map['a.stock'] = ['like', '%' . $_POST['keyword'] . '%'];
            $map['a.price'] = ['like', '%' . $_POST['keyword'] . '%'];
            $petproducts = Db::table('pet_products')
                ->alias('a')
                ->join('product_type b', 'a.type_id=b.type_id')
                ->field('a.id,a.product_name,
                                b.type_name,a.stock,a.price,
                                a.sales,a.on_sale_date')
                ->whereOr($map)
                ->paginate(10,false,['query'=>array('p'=>$p)]);
        } else {
            $this->error('请输入关键字');
        }

        //$petproducts=$PetProducts->where('id|product_name|type_name|stock|price','like','%'.$keyword.'%')->select();

        $this->assign('petproducts', $petproducts);
        return $this->fetch($p);
    }

//根据id查询一条记录
    public function detail($id)
    {

        $petproducts = Db::query("SELECT a.id,a.product_name,b.type_id,b.type_name,
	                            a.stock,a.price,a.introduction,a.sales,
	                            a.photo,a.on_sale_date FROM pet_products a
                                LEFT JOIN product_type b ON a.type_id = b.type_id 
                                WHERE id=" . $id);
        $producttype = Db::query("select * from product_type");
        $this->assign(['petproducts' => $petproducts, 'producttype' => $producttype]);

        return $this->fetch();
    }

    //更新一条记录
    public function update()
    {
        if (!empty(request()->file('photo'))) {
            //先上传商品图片
            $tool = new Tool();
            $upload_filename = $tool->upload();

            //给出商品图片的完整相对路径
            $_POST['photo'] = $upload_filename;;

            echo $_POST['photo'];

            $PetProducts = Db::table('pet_products')
                ->where('id', $_POST['id'])
                ->update([
                    'product_name' => $_POST['product_name'],
                    'type_id' => $_POST['type_id'],
                    'stock' => $_POST['stock'],
                    'photo' => $_POST['photo'],
                    'price' => $_POST['price'],
                    'introduction' => $_POST['introduction'],
                ]);
            if ($PetProducts == 0) {
                $this->error('修改失败');
            } else {
                $this->success('修改成功', 'pet_products/select?p=select');
            }
        } else {
            $PetProducts = Db::table('pet_products')
                ->where('id', $_POST['id'])
                ->update([
                    'product_name' => $_POST['product_name'],
                    'type_id' => $_POST['type_id'],
                    'stock' => $_POST['stock'],
                    'price' => $_POST['price'],
                    'introduction' => $_POST['introduction'],
                ]);
            if ($PetProducts == 0) {
                $this->error('修改失败');
            } else {
                $this->success('修改成功', 'pet_products/select?p=select');
            }
        }

    }

//根据id删除一条记录
    public function delete_by_id($id)
    {
        $result = db('pet_products')->delete($id);
        if ($result) {
            $this->success('删除成功', 'pet_products/select?p=select');
        } else {
            $this->error('删除失败');
        }
    }

//    //添加详情页
//    public function intro($id)
//    {
//        if (!empty($id) && isset($id)) {
//            $result = Db::table('pet_products')
//                ->where('id', $id)
//                ->update([
//                    'introduction' => $_POST['introduction']
//                ]);
//            if ($result) {
//                $this->success('商品详情添加成功');
//            } else {
//                $this->error('商品详情添加失败');
//            }
//
//        }
//
//    }

//    //根据某个字段升序排序输出
//    public function asc_by($order)
//    {
//        $petproducts = Db::table('pet_products')
//            ->alias('a')
//            ->join('product_type b', 'a.type_id=b.type_id')
//            ->order($order . ' asc')
//            ->paginate(10);
//        $this->assign('petproducts', $petproducts);
//        return $this->fetch("select");
//    }
//
//    //根据某个字段降序序排序输出
//    public function desc_by($order)
//    {
//        $petproducts = Db::table('pet_products')
//            ->alias('a')
//            ->join('product_type b', 'a.type_id=b.type_id')
//            ->order($order . ' desc')
//            ->paginate(10);
//        $this->assign('petproducts', $petproducts);
//        return $this->fetch("select");
//    }

    public function stock_list()
    {
        $petproducts = Db::table('pet_products')
            ->alias('a')
            ->join('product_type b', 'a.type_id=b.type_id')
            ->paginate(10);
        $this->assign('petproducts', $petproducts);
        return $this->fetch();
    }

    public function add_stock($id)
    {
        $PetProducts=new PetProducts();
        $msg=null;
        if (!empty($_POST)&&isset($_POST)){
            if ($_POST['stock']<=0){
                $msg='请输入大于0的整数！';
                return $msg;
            }else{

                $old_data=$PetProducts->find_by_id($id);
                $_POST['stock']=$old_data['stock']+$_POST['stock'];
                $result=$PetProducts->edit_stock($_POST['stock'],$id);
                if ($result){
                    $msg='库存增加成功！';
                    return $msg;
                }else{
                    $msg='库存增加失败！';
                    return $msg;
                }
            }
        }
    }

    public function out_stock($id)
    {
        $PetProducts=new PetProducts();
        $msg=null;
        if (!empty($_POST)&&isset($_POST)){
            if ($_POST['stock']<=0){
                $msg='请输入大于0的整数！';
                return $msg;
            }else{
                $old_data=$PetProducts->find_by_id($id);
                $_POST['stock']=$old_data['stock']-$_POST['stock'];
                if ($_POST['stock']<0){
                    $msg='库存不能少于0！';
                    return $msg;
                }else{
                    $result=$PetProducts->edit_stock($_POST['stock'],$id);
                    if ($result){
                        $msg='出库成功！';
                        return $msg;
                    }else{
                        $msg='出库失败！';
                        return $msg;
                    }
                }

            }
        }
    }

}