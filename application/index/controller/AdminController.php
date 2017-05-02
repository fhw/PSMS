<?php
/**
 * Created by PhpStorm.
 * User: fhw5629
 * Date: 2016/10/26
 * Time: 16:18
 */

namespace app\index\controller;


use app\index\model\Admin;
use app\index\model\Role;

class AdminController extends BaseController
{
    public function add()
    {
        if (!empty($_POST)&&isset($_POST)){
            $Admin=new Admin();
            $has_admin=$Admin->is_same_admin($_POST['user_name']);
            if($has_admin==0){
                $result=$Admin->add($_POST);
                if ($result){
                    $this->success('添加成功','list_all');
                }else{
                    $this->error('添加失败');
                }
            }else{
                $this->error('已存在该管理员，请核对');
            }
        }else{
            return $this->fetch();
        }
    }

    public function edit($id)
    {
        $Admin=new Admin();
        $data=$Admin->get_admin($id);
        if (!empty($_POST)&&isset($_POST)){
            $has_admin=$Admin->is_same_admin($_POST['user_name']);

                unset($_POST['id']);
                $result=$Admin->update_by_id($_POST,$id);
                if ($result){
                    $this->success('修改成功','list_all');
                }else{
                    $this->error('修改失败');
                }
        }
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function list_all()
    {
        $Admin=new Admin();
        $admin_list=$Admin->all_admin();
        $this->assign('list',$admin_list);
        return $this->fetch('manager');
    }

    public function delete_by_id($id)
    {
        $Admin=Admin::get($id);
        $Admin->role()->detach();
        $result=$Admin->delete($id);
        if($result){
            $this->success('删除成功','list_all');
        }else{
            $this->error('删除失败');
        }
    }

    public function set_role_view($admin_id)
    {
        $data=Admin::get($admin_id);
        $role=new Role();
        $admin_r=$data->role;
        $r_list=$role->all();
        $this->assign(['data'=>$data,'r_list'=>$r_list,'admin_r'=>$admin_r]);
        return $this->fetch();
    }

    public function set_role()
    {
        if ($this->request->isPost()){
            $data=input('post.');
            $admin=Admin::get($data['admin_id']);
            unset($data['admin_id']);
            $admin->role()->detach();
            if (!empty($data['id'])){
                foreach ($data['id'] as $id){
                    $admin->role()->attach($id);
                }
            }else{
                $this->success('角色设置成功！');
            }
        }
        $this->success('角色设置成功！');
    }
}