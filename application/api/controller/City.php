<?php
namespace app\api\controller;
use think\Controller;

class City extends Controller{
    protected $db;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->db = new \app\common\model\City();
    }

    public function indexcity()
    {
        $id = input("post.id");
       // halt($id);
        if(!intval($id))
        {
            $this->error();
        }
        $city = $this->db->indexcity($id);

        if($city)
        {
            return show(1,"success",$city);
            // $this->success("成功");
        }
        else{
            $this->error("失败");
        }

    }
}