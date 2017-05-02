<?php
/**
 * Created by PhpStorm.
 * User: FHW
 * Date: 2017/3/12
 * Time: 12:17
 */

namespace app\index\controller;


use app\index\model\Access;
use app\index\model\Role;

class RoleController extends BaseController
{
    public function index()
    {
        $roles = new Role();
        $r_list = $roles->all();
        $this->assign('r_list', $r_list);
        return $this->fetch();
    }

    public function add_view()
    {
        return $this->fetch();
    }

    public function set_role_view($id)
    {
        $data = Role::get($id);
        $ass = new Access();
        //$data=$roles->get($id);
        $role_a = $data->access;
        $a_list = $ass->all();
        $this->assign(['data' => $data, 'a_list' => $a_list, 'role_a' => $role_a]);
        return $this->fetch();
    }


    public function add()
    {
        $roles = new Role();
        if ($this->request->isPost()) {
            $count = $roles->where('name', input('post.')['name'])->count();
            if ($count) {
                $msg = "该角色已存在，请重新输入！";
                return $msg;
            } else {
                if ($this->request->isAjax()) {
                    $msg = $this->validate(input('post.'), 'Role');
                    if (true !== $msg) {
                        return $msg;
                    }
                } else {
                    if ($roles->allowField(true)->save(input('post.'))) {
                        $this->success('角色：' . $roles->name . '，添加成功', 'role/index');
                    } else {
                        $this->error('添加失败！', 'role/index');
                    }
                }

            }
        }
    }

    public function set_role()
    {
        if ($this->request->isPost()) {
            $data = input('post.');
            $roles = Role::get($data['r_id']);
            unset($data['r_id']);
            $roles->access()->detach();
            if (!empty($data)) {
                foreach ($data['id'] as $id) {
                    $roles->access()->attach($id);
                }
                $this->success('权限设置成功！');
            } else {
                $this->error('权限设置失败！');
            }
        }
    }

    public function delete_by_id($id)
    {
        $role = Role::get($id);
        $role->access()->detach();
        $role->admin()->detach();
        $result = $role->delete();
        if ($result) {
            $this->success('删除成功！', 'role/index');
        } else {
            $this->error('删除失败！', 'role/index');
        }
    }
}