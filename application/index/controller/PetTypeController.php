<?php
namespace app\index\controller;
use app\index\model\Pet;
use app\index\model\PetType;
use think\Db;

/**
* 宠物类型管理
*/
class PetTypeController extends BaseController
{
    public function add_view()
    {
        return $this->fetch();
    }

    public function add()
    {
        $PetType=new PetType();
        if (!empty($_POST['pet_type_name'])&&isset($_POST['pet_type_name'])){
            if (Db::table('pet_type')->where('pet_type_name',$_POST['pet_type_name'])->count()==0){
                $result=$PetType->add_pet_type($_POST);
                if($result){
                    $this->success('添加成功');
                }else{
                    $this->error($result);
                }
            }else{
                $msg="已存在该类型！";
                $this->error($msg);
            }
        }else{
            $this->error("请输入内容!");
        }

    }

    public function update($id)
    {
        $PetType=new PetType();
        $data=$PetType->find_by_id($id);
        if (!empty($_POST)&&isset($_POST)) {
            if (!empty($_POST['pet_type_name']) && isset($_POST['pet_type_name'])) {
                if (Db::table('pet_type')->where('pet_type_name', $_POST['pet_type_name'])->count() == 0) {
                    $result = $PetType->update_by_id($_POST, $_POST['id']);
                    if ($result) {
                        $this->success('修改成功');
                    } else {
                        $this->error($result);
                    }
                } else {
                    $msg = "已存在该类型！";
                    $this->error($msg);
                }
            } else {
                $this->error("请输入内容!");
            }
        }
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function list_all()
    {
        $PetType=new PetType();
        $list=$PetType->page_all_list();
        $this->assign('list',$list);
        return $this->fetch('manager');
    }

    public function find_by_keyword()
    {
        $PetType=new PetType();
        $list=$PetType->find_by_keyword($_POST['keyword']);
        $this->assign('list',$list);
        return $this->fetch('manager');
    }

    public function delete_by_id($id)
    {
        $PetType=new PetType();
        $Pet=new Pet();
        $has_pet=$Pet->count_by_type_id($id);
        if ($has_pet==0){
            $result=$PetType->delete_by_id($id);
            if ($result){
                $this->success('删除成功','list_all');
            }else{
                $this->error('删除失败','list_all');
            }
        }else{
            $this->error('该分类下含有宠物，无法删除！');
        }

    }
}