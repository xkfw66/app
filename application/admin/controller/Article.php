<?php
namespace app\admin\controller;
use think\Controller;


class Article extends Common
{
    protected $db;//声明一个对象

    /***
     * 实例化对象
     */
    protected  function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->db = new \app\common\model\Article();
    }
    /***
     * 加载首页并获取全部数据
     *
     */
    public function index()
    {

        $pid = input('get.pid',0);
        //halt($pid);
        $data = $this->db->index($pid);
       //halt($data);
        return $this->fetch('',['data'=>$data]);
    }
    /***
     * 获取添加页面的分类数据
     */
    public function store()
    {
        //$id = input('get.id',0);
        $filed =   $this->db->store();
        //halt($filed);
        return $this->fetch('',['filed'=>$filed]);//加载模板
    }
    /***
     * 分类添加
     */
     public function add()
    {
      if(request()->isPost())
      {
         //halt($_POST);
          $res =    $this->db->add(input('post.'));//获取表单数据
          if($res)
          {   //说明执行成功
              $this->success($res['msg'],'index');exit;
          }
          else{
              //执行失败
              $this->error($res['msg'],'add');exit;
          }
      }

    }
    /**
     * 删除
     */
    public function del()
    {
        //echo 1;die;
        /*$id =input('get.id') ;
        halt($id);*/
        $res = $this->db->del(input('get.id'));

        if($res['vaild'])
        {
            $this->success($res['msg'],'index');exit;
        }
        else{
            $this->error($res['msg']);exit;
        }
    }
    /***
     * 分类的编辑
     */
    public function edit()
    {
        if(request()->isPost())
        {
           //halt($_POST);
            $res = $this->db->edit(input('post.'));
            if($res['vaild'])
            {
                $this->success($res['msg'],'index');exit;
            }
            else{
                $this->error($res['msg']);exit;
            }
        }
        //获取当前修改的id
        $id = input('param.id');
       //halt($id);
       // 获取旧数据
        $olderdata = $this->db->find($id);
       // halt($olderdata);
        $this->assign('olderdata',$olderdata);
       // halt($olderdata);
        //处理所属分类。。。不能包含子集数据和自己交由模型处理
       $date = $this->db->cateData($id);
        $this->assign('date',$date);
        return $this->fetch();
    }
    /***
     * 修改状态
     */
    public function status()
    {
        $data = input("get.");
   // halt($data);
        $validate = validate('Article');
        if(!$validate->scene('status')->check($data))
        {
            return $this->error($validate->getError());
        }

        $res = $this->db->save(['status'=>$data['status']], ['id'=>$data['id']]);
        if($res )
        {
            $this->success("状态更新成功");

        }else
        {
            $this->error("状态更新失败");
        }
    }
    /**
     *排序修改
     */
    public function sort($id, $sort) {
        $res = $this->db->save(['sort'=>$sort], ['id'=>$id]);
        if($res) {
            $this->result($_SERVER['HTTP_REFERER'], 1, 'success');
        }else {
            $this->result($_SERVER['HTTP_REFERER'], 0, '更新失败');
        }
    }
}