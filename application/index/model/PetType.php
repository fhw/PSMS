<?php 
namespace app\index\model;
use think\Db;
use think\Model;
/**
* pet_type 宠物类型表
*/
class PetType extends Model
{
    /**
     * 添加一个宠物类型
     * @param $data 添加的数据
     * @return false|int|string
     */
    public function add_pet_type($data)
    {
            return $this->save($data);
	}

    /**
     * 根据id删除一个宠物类型
     * @param $id
     * @return int
     */
    public function delete_by_id($id)
    {
        return $this->destroy($id);
    }

    /**
     * 更新一个宠物类型
     * @param $data 更新的数据
     * @param $id
     * @return false|int
     */
    public function update_by_id($data, $id)
    {
        return $this->save($data,['id'=>$id]);
    }


    /**
     * 分页显示所有宠物类型
     * @return false|static[]
     */
    public function page_all_list()
    {
        return $this->paginate(10);
    }

    public function all_list()
    {
        return $this->all();
    }

    public function find_by_id($id)
    {
        return $this->get($id);
    }

    public function find_by_keyword($keyword)
    {
        return $this->where('pet_type_name','like','%'.$keyword.'%')->paginate(10);
    }
}