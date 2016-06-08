<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Widget;
use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */

class CategoryWidget extends Action{
	private static $dep = 1;

	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($cate, $child = false){
		$field = 'id,name,pid,title,link_id';
		if($child){
			$category = D('Category')->getTree($cate, $field);
			$category = $category['_'];
		} else {
			$category = D('Category')->getSameLevel($cate, $field);
		}
		$this->assign('category', $category);
		$this->assign('current', $cate);
		$this->display('Category/lists');
	}

	/* 显示指定分类的同级分类或子分类列表 */
	public function tops($cate, $child = false){
		if(intval($cate) < 1){ #默认获取最新一期
			$m = D('Category')->where(array('pid=0'))->max('id');

			$cate = intval($m); $child = true;
		}
		$indexRoot = intval(I('get.rootid'));
		if($indexRoot){
			$cate = $indexRoot ; $child=true;
		}

		$root = $this->getCurrentCatTreeNodeId($cate);

		$field = 'id,name,pid,title,link_id';
		if($child){
			$category = D('Category')->getTree($cate, $field);
			$category = $category['_'];
		} else {
			$category = D('Category')->getSameLevel($cate, $field);
		}
		$this->assign('category', $category);
		$this->assign('current', $cate);
		$this->assign('c', $cate);
		$this->assign('rootnodeid' , $root );
		$this->display('Category/tops');
	}

	public function mainbanner($cate, $child = false){
		if(intval($cate) < 1){ #默认获取最新一期
			$m = D('Category')->where(array('pid=0'))->max('id');

			$cate = intval($m); $child = true;
		}
		$indexRoot = intval(I('get.rootid'));
		if($indexRoot){
			$cate = $indexRoot ; $child=true;
		}

		if(session('rootcatid')){
			$root = session('rootcatid');
		}else{
			$root = $this->getCurrentCatTreeNodeId($cate);
			session('rootcatid' ,$root);
		}
		// echo $root;

		$dt = M('Zhuangti')->where(array('rootcatid' => $root))->find();
		// dump($dt);
		if($dt && $dt['banner']){
			$img = M("Picture")->where('id='.$dt['banner'])->getField('path');
			$this->assign('src' , $img);
			$this->assign('alt' , $dt['name']);
		}else{
			$this->assign('src' , '/Uploads/Picture/default.png');
			$this->assign('alt' , 'no');

		}
		$this->display('Category/mainbanner');
	}

	public function getCurrentCatTreeNodeId($cateid){

		if($this->dep++ == 10){
			return 1;
		}
		$m = D('Category')->where(array('id' =>$cateid))->find();
		if($m && $m['pid'] ==  0 ){
			return $cateid;
		}else{
			return $this->getCurrentCatTreeNodeId($m['pid']);
		}
	}
}
