<?php
namespace app\index\controller;
use think\Controller;

class Base extends Controller
{
    public function index()
    {
    	$field = db('base')->select();
    	$nav = db('nav')->select();
    	$subnav = db('subnav')->select();
    	return  $this->fetch('',['nav'=>$nav,'subnav'=>$subnav,'field'=>$field]);
    	
    
    }
}