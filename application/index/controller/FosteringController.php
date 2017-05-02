<?php
/**
 * Created by PhpStorm.
 * User: fhw5629
 * Date: 2016/11/23
 * Time: 14:41
 */

namespace app\index\controller;


use app\index\model\Fostering;
use app\index\model\Pet;

class FosteringController extends BaseController
{
    public function add()
    {
        $Fostering = new Fostering();
        $Pet = new Pet();
        $pet_list = $Pet->select_all();
        if (!empty($_POST) && isset($_POST)) {
            if ($Fostering->is_same_status($_POST['pet_id']) == 0) {
                $fostering = $Fostering->add_fostering($_POST);
                if ($fostering) {
                    $this->success('添加成功', 'all');
                } else {
                    $this->error('添加失败');
                }
            } else {
                $this->error('上次寄养还没有结束，请先结束再新增寄养');
            }
        }
        $this->assign('pet_list', $pet_list);
        return $this->fetch();
    }

    public function all()
    {
        $Fostering = new Fostering();
        $data = $Fostering->find_all_fostering();
        $this->assign('data', $data);
        return $this->fetch();
    }

    public function find()
    {
        $Fostering = new Fostering();
        if (!empty($_POST['keyword']) && isset($_POST['keyword'])) {
            $data = $Fostering->find_by_keyword($_POST['keyword']);
        }
        $this->assign('data', $data);
        return $this->fetch('all');
    }

    public function find_by_id($id)
    {
        $Fostering = new Fostering();
        $Pet = new Pet();
        $pet_list = $Pet->select_all();
        $data = $Fostering->find_fostering($id);
        $this->assign(['pet_list' => $pet_list, 'data' => $data]);
        return $this->fetch('edit');
    }

    public function update($id)
    {
        $Fostering = new Fostering();
        if (!empty($_POST) && isset($_POST)) {
            $result = $Fostering->update_fostering($id, $_POST);
            if ($result) {
                $this->success('修改成功');
            } else {
                $this->error('修改失败');
            }
        }
    }

    public function delete_by_id($id)
    {
        $Fostering = new Fostering();
        $result = $Fostering->delete_fostering($id);
        if ($result) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
}