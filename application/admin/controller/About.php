<?php
namespace app\admin\controller;

use think\Controller;


class About extends Controller
{
   protected $db;
   public function _initialize(){
   parent::_initialize();
   $this->db =new \app\common\model\About();
}
    //资讯管理首页
    public function about()
	
    { 
        $field='';
        //资讯管理查询搜索
        if(request()->isPost()){
            $key = input('param.about');
            //halt($key);
            $field = db('about')->where('article_id|article_title','like',"{$key}%")->select();
        }
       //halt($field);
        if($field){
               $this->assign('field',$field);
                return $this->fetch();
        }else{
    		//获取资讯管理数据
    	   $field = db ('about')->select();
    	   $this->assign('field',$field);
           return $this->fetch();
    }
    }
    //资讯管理添加
    public function about_add()
    {   

		if(request()->isPost())
        {
            $datas=input('post.');
            $file = request()->file('file');
          //  halt($file);
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
            //halt($info);
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
              //  echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
               // echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
               // echo $info->getFilename();
               $datas['article_image']='/APP/public/'.'upload'.'/'.$info->getSaveName();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
            // halt($_POST);die;
            //if($res['vaid']){}
            //halt(input('post.'));
             $res= $this->db->add($datas);
           if($res['vaid'])
            {
                $this->success($res['aa'],'About/about');exit;
            }else{
                $this->error($res['aa']);exit;
            }
    
     }
        return $this->fetch();
    }
    //资讯管理删除
    public function del(){



    $id =input('get.article_id');
    $res= db('about')->where('article_id',$id)->delete();
    if($res){
        $this->success('删除成功','about');exit;
    }else{
        $this->error('删除失败');exit;
    }

    }

    //资讯管理修改
      public function about_upd()
    {
        $id = input('param.article_id');
      // halt($id);
        $oldData = $this->db->find($id);
        //halt($oldData);
        $this->assign('oldData',$oldData);
        if (request()->isPost())
        {
            //halt(input('post.'));
            $datas=input('post.');
            $file = request()->file('file');
         // halt($file);
          if(!is_null($file)){

          
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
            //halt($info);
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
              //  echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
               // echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
               // echo $info->getFilename();
               $datas['article_image']='/APP/public/upload/'.$info->getSaveName();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
            $res = $this->db->upd($datas);


            if($res['vaid'])
            {
                $this->success($res['message'],'About/about');exit;

            }
            else{
                $this->error($res['message']);exit;
            }
        }
        return $this->fetch();
    }

}