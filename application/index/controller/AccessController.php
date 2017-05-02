<?php
/**
 * Created by PhpStorm.
 * User: FHW
 * Date: 2017/3/14
 * Time: 13:51
 */

namespace app\index\controller;


use app\index\model\Access;

class AccessController extends BaseController
{
    //index页面显示已有的权限列表
    public function index()
    {
        $a_list = Access::all();
        $this->assign('a_list', $a_list);
        return $this->fetch();
    }

    public function add_view()
    {
        return $this->fetch();
    }

    public function edit_view($id)
    {
        $ass = new Access();
        $data = $ass->get($id);
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function add()
    {
        $ass = new Access();
        if ($this->request->isPost()) {
            $count = $ass->where('title', input('post.')['title'])->count();
            if ($count) {
                $msg = "该权限已存在，请重新输入！";
                return $msg;
            } else {
                if ($ass->allowField(true)->validate(true)->save(input('post.'))) {
                    return $this->success('权限：' . $ass->title . '，修改成功', 'access/index');
                } else {
                    return $ass->getError();
                }
            }
        }
    }

    public function edit()
    {
        $ass = new Access();
        if ($this->request->isPost()) {
            $count = $ass->where(['uris' => input('post.')['uris'], 'title' => input('post.')['title']])->count();
            if ($count) {
                $msg = "该权限已存在，请重新输入！";
                return $msg;
            } else {
                if ($ass->allowField(true)->validate(true)->save(input('post.'), ['id' => input('post.')['id']])) {
                    return $this->success('权限：' . $ass->title . '，修改成功', 'access/index');
                } else {
                    return $ass->getError();
                }
            }
        }
    }

    public function delete_by_id($id)
    {
        $access = Access::get($id);
        $access->roles()->detach();
        $result = $access->delete();
        if ($result) {
            $this->success('删除成功!', 'access/index');
        }else{
            $this->error('删除失败！','access/index');
        }
    }

}