<?php
namespace app\api\controller;

use think\Controller;
use think\Request;
use think\File;
use think\UploadFile;

class Image extends Controller
{
    public function upload() {
        $file = Request::instance()->file('file');
        // 给定一个目录
        $info = $file->move('upload');//创建一个目录
        if($info && $info->getPathname()) {
            return show(1, 'success','/APP/public/'.$info->getPathname());
        }
        return show(0,'upload error');
    }
}