<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {

	//系统首页
    public function index(){
         $rootid = I('get.rootid');
        // echo 3232;die();

        $category = D('Category')->getTree();

        // $lists    = D('Document')->lists(null);
        // $pics = ;
        $pics = 1;
        // session('rootcatid' , 1);
        $Zhuangti = M("Zhuangti")->where('rootcatid='.$rootid)->find();
        $map['id']  = array('in',implode(',' , array($Zhuangti['lunbo1'] , $Zhuangti['lunbo2'] , $Zhuangti['lunbo3'] , $Zhuangti['lunbo4'])));
        $pics = M('Picture')->where($map)->select();
        $this->assign('pics',$pics);//栏目
        $this->assign('m1h3' , $this->zhuangti['m1h3']);
        $this->assign('m2h3' , $this->zhuangti['m2h3']);
        // $this->assign('lists',$lists);//列表
        // $this->assign('page',D('Document')->page);//分页

        $this->display();
    }

}
