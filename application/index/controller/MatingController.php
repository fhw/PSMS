<?php
/**
 * Created by PhpStorm.
 * User: fhw56
 * Date: 2016/12/2 0002
 * Time: 19:41
 */

namespace app\index\controller;


use app\index\model\Mating;
use app\index\model\Pet;


class MatingController extends BaseController
{
    public function add($first_id,$second_id)
    {
        $Pet=new Pet();
        $Mating=new Mating();
        $sex1=$Pet->find_sex_by_id($first_id);
        $data['create_time']=date("Y-m-d H:i:s");
        if ($sex1['sex']==0){
            $data['male_pet_id']=$first_id;
            $data['female_pet_id']=$second_id;
        }else if ($sex1['sex']==1){
            $data['female_pet_id']=$first_id;
            $data['male_pet_id']=$second_id;
        }
        $is_same=$Mating->is_same_data($data['female_pet_id'],$data['male_pet_id']);
        if ($is_same==0){
            $result=$Mating->add($data);
            if ($result){
                $this->redirect('mating/edit_by_create_time',['time'=>$data['create_time']]);
            }else{
                $this->error('添加配对失败！');
            }
        }else{
            $this->error('该配对上次尚未完成！无法添加');
        }

    }

    public function add_view()
    {
        $Pet=new Pet();
        $pet_list=$Pet->select_mating();
        $this->assign(['pet_list'=>$pet_list]);
        return $this->fetch();
    }

    public function list_all()
    {
        $Mating=new Mating();
        $data=$Mating->find_all();
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function match($id)
    {
        $Pet=new Pet();
        $match_list=$Pet->match($id);
        return $match_list;
    }

    public function edit_by_create_time($time)
    {
        $Mating=new Mating();
        $data=$Mating->find_by_create_time($time);
        $this->assign('data',$data);
        return $this->fetch('edit');
    }

    public function edit($id)
    {
        $Mating=new Mating();
        $data=$Mating->find_by_id($id);
        if (!empty($_POST)&&isset($_POST)){
            $data['mating_date']=$_POST['mating_date'];
            $data['is_mating']=$_POST['is_mating'];
            $result=$Mating->update_by_id(['mating_date'=>$data['mating_date'],'is_mating'=>$data['is_mating']],$id);
            if ($result){
                $this->success('保存成功','list_all');
            }else{
                $this->error('保存失败');
            }
        }
        $this->assign('data',$data);
        return $this->fetch('edit');
    }

    public function delete_by_id($id)
    {
        $Mating=new Mating();
        $result=$Mating->delete_by_id($id);
        if ($result){
            $this->success('删除成功','list_all');
        }else{
            $this->error('删除失败');
        }
    }
}