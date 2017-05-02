<?php
/**
 * Created by PhpStorm.
 * User: fhw5629
 * Date: 2016/10/19
 * Time: 19:32
 */

namespace app\index\controller;


use app\index\model\Fostering;
use app\index\model\Mating;
use app\index\model\Pet;
use app\index\model\PetType;
use app\index\tool\Tool;
use think\Controller;

class PetController extends BaseController
{
    public function pet_view()
    {
        $this->list_all();
        return $this->fetch();
    }

    public function insert()
    {
        $Pet = new Pet();
        $PetType = new PetType();
        $pet_type_list = $PetType->all_list();


        if (!empty($_POST) && isset($_POST)) {
            if (!empty($_FILES['photo']) && isset($_FILES['photo'])){
                //先上传商品图片
                $tool = new Tool();
                $upload_filename = $tool->upload();

                //给出商品图片的完整相对路径
                $_POST['photo'] = $upload_filename;

                $pet = $Pet->data($_POST)->save();
                if ($pet) {
                    $this->success('新增成功', 'insert');
                } else {
                    return $this->error('新增失败');
                }
            }else{
                unset($_POST['photo']);
                $pet = $Pet->data($_POST)->save();
                if ($pet) {
                    $this->success('新增成功', 'insert');
                } else {
                    return $this->error('新增失败');
                }
            }

        }
        $this->assign(['pet_type_list' => $pet_type_list]);
        return $this->fetch();
    }

    public function select_by_keyword($keyword)
    {
        $Pet = new Pet();
        if (!empty($keyword) && isset($keyword)) {
            $data = $Pet->select_by_keyword($keyword);
            $this->assign('data', $data);
            return $this->fetch('pet/pet_view');
        } else {
            $this->error('请输入关键字');
        }
    }

    public function list_all()
    {
        $Pet = new Pet();
        $PetType = new PetType();
        $pet_type_list = $PetType->all_list();
        $data = $Pet->select_all();
        $this->assign(['data' => $data, 'pet_type_list' => $pet_type_list]);
        return $this->display();
    }

//    public function detail($id)
//    {
//        $Pet = new Pet();
//        $data = $Pet->select_by_id($id);
//        echo '<pre>';
//        var_dump($data);
//        $this->assign('data', $data);
//        return $this->fetch();
//    }

    public function delete_by_id($id)
    {
        $Pet = new Pet();
        $Mating=new Mating();
        $Fostering=new Fostering();
        $fostering_count=$Fostering->find_pet($id);
        $mating_count=$Mating->find_pet_id($id);
        if ($mating_count==0){
            if ($fostering_count==0){
                $result = $Pet->delete_by_id($id);
                if ($result) {
                    $this->success('删除成功');
                } else {
                    $this->error('删除失败');
                }
            }
            else{
                $this->error('无法删除，该宠物处于寄养列表中');
            }
        }else{
            $this->error('无法删除，该宠物处于配种列表中');
        }

    }

    public function update($id)
    {
        $Pet = new Pet();
        $PetType = new PetType();
        $pet_type_list = $PetType->all_list();
        $data = $Pet->select_by_id($id);

        if (!empty($_POST) && isset($_POST)) {
            if (!empty($_FILES['photo']['name']) && isset($_FILES['photo']['name'])) {
                //先上传商品图片
                $tool = new Tool();
                $upload_filename = $tool->upload();
                //给出商品图片的完整相对路径
                $_POST['photo'] = $upload_filename;
                $pet = $Pet->update_by_id($_POST, $_POST['id']);
                if ($pet) {
                    $this->success('修改成功', 'pet_view');
                } else {
                    return $this->error('修改失败');
                }
            } else {
                unset($_POST['photo']);
                $pet = $Pet->update_by_id($_POST, $id);
                if ($pet) {
                    $this->success('修改成功', 'pet_view');
                } else {
                    return $this->error('修改失败');
                }
            }
        }
        $this->assign(['data' => $data, 'pet_type_list' => $pet_type_list]);
        return $this->fetch();
    }

    public function deal_list()
    {
        $Pet=new Pet();
        $PetType = new PetType();
        $pet_type_list = $PetType->all_list();
        $data=$Pet->find_onsale();
        $this->assign(['data' => $data, 'pet_type_list' => $pet_type_list]);
        return $this->fetch();
    }
    public function sold_list()
    {
        $Pet=new Pet();
        $PetType = new PetType();
        $pet_type_list = $PetType->all_list();
        $data=$Pet->find_sold();
        $this->assign(['data' => $data, 'pet_type_list' => $pet_type_list]);
        return $this->fetch('deal_list');
    }

    public function deal_price($id)
    {
        $Pet=new Pet();
        if (!empty($_POST)&&isset($_POST)){
            $result1=$Pet->add_price($_POST['price'],$id);
            $result2=$Pet->sale_out($id);
            if ($result1&&$result2){
                $msg='交易成功';
                return $msg;
            }else{
                $msg='交易失败';
                return $msg;
            }
        }
        return $this->fetch('deal');
    }

    public function find_by_id($id)
    {
        $Pet=new Pet();
        $data=$Pet->find_by_id($id);
        return $data;
    }

    public function male_list()
    {
        $Pet=new Pet();
        $male_list=$Pet->find_male();
        return $male_list;
    }

    public function detail($id)
    {
        $Pet=new Pet();
        $data=$Pet->select_by_id($id);
        $this->assign('data',$data);
        return $this->fetch();
    }
}