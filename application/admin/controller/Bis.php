<?php
namespace app\admin\controller;
use think\Controller;

class Bis extends Controller
{
    protected $db;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->db = model('Bis');
    }

    /**
     * @return mixed商户列表
     */
    public function index()
    {
        $bis = $this->db->getBisdata($status=1);
        return $this->fetch('',['bis'=>$bis]);
    }
    /**
     * 商户入驻申请列表
     */
    public function apply()
    {
        $bis = $this->db->getBisdata($status=0);
        return $this->fetch('',['bis'=>$bis]);
    }

    /**
     * 商家入驻的状态审核
     */
    public function status()
    {

        $data = input("get.");
        $res = model('Bis')->save(["status"=>$data['status']],["id"=>$data['id']]);
        $account =  model('Bisaccount')->save(["status"=>$data['status']],["bis_id"=>$data['id']]);
        $location =  model('Bislocation')->save(["status"=>$data['status']],["bis_id"=>$data['id']]);

        if($res || $account ||  $location)
        {
            $this->success("更新成功");
        }
        else{
            $this->success("更新失败");

        }

    }
    /**
     * 商户详情页
     */
    public function detail() //读取数据
    {
        $id = input("get.id");
       // halt($id);
        $citys = model("City")->indexcity();
        //halt($citys);
        $categorys = model("Article")->getCategoryByParentId();
        //halt($categorys);
        $bisData = model('Bis')->get($id);
       // halt($bisData);
        $accountData = model('Bisaccount')->get(["bis_id"=>$id,"is_main"=>1]);
        //halt($accountData);
        $locationData = model('Bislocation')->get(["bis_id"=>$id,"is_main"=>1]);
       // halt($locationData);
        return $this->fetch('',
        [
            'citys'=>$citys,'categorys'=>$categorys,
            "bisData"=>$bisData,
            "accountData"=>$accountData,
            "locationData"=>$locationData,
        ]);

    }

}