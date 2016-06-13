<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use Think\Controller;

/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class HomeController extends Controller {

    protected $zhuangti = array();

	/* 空操作，用于输出404页面 */
	public function _empty(){
		$this->redirect('Index/index');
	}


    protected function _initialize(){
        /* 读取站点配置 */
        $config = api('Config/lists');
        C($config); //添加配置

        if(!C('WEB_SITE_CLOSE')){
            $this->error('站点已经关闭，请稍后访问~');
        }
        if($rootcatid = I('get.rootid')){
            ;;;;;
        }else{
            $rootcatid = session('rootcatid');
        }

        if($o = M('Zhuangti')->where(array('rootcatid='.$rootcatid))->find()){
            $this->zhuangti = $o;
            $this->assign('t1h3' , $this->zhuangti['t1h3']);
            $this->assign('t2h3' , $this->zhuangti['t2h3']);
            $this->assign('t3h3' , $this->zhuangti['t3h3']);
            $this->assign('t4h3' , $this->zhuangti['t4h3']);
            $this->assign('t5h3' , $this->zhuangti['t5h3']);
            $this->assign('t6h3' , $this->zhuangti['t6h3']);
            $this->assign('m1content' , $this->zhuangti['m1content']);
            $this->assign('m2content' , $this->zhuangti['m2content']);
            $this->assign('t1content' , $this->zhuangti['t1content']);
            $this->assign('t2content' , $this->zhuangti['t2content']);
            $this->assign('t3content' , $this->zhuangti['t3content']);
            $this->assign('t4content' , $this->zhuangti['t4content']);
            $this->assign('t5content' , $this->zhuangti['t5content']);
            $this->assign('t6content' , $this->zhuangti['t6content']);
            $this->assign('footer' , $this->zhuangti['footer']);
        }
    }

	/* 用户登录检测 */
	protected function login(){
		/* 用户登录检测 */
		is_login() || $this->error('您还没有登录，请先登录！', U('User/login'));
	}

}
