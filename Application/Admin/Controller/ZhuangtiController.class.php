<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi;

/**
 * 后台用户控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class ZhuangtiController extends AdminController {

    /**
     * 用户管理首页
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
        $name       =   I('name');
        $map['status']  =   array('egt',0);
        if(is_numeric($name)){
            $map['uid|name']=   array(intval($name),array('like','%'.$name.'%'),'_multi'=>true);
        }else{
            $map['name']    =   array('like', '%'.(string)$name.'%');
        }

        $list   = $this->lists('Zhuangti', $map);
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '用户信息';
        $this->display();
    }

    /**
     * 用户行为列表
     * @author huajie <banhuajie@163.com>
     */
    public function action(){
        //获取列表数据
        $Action =   M('Action')->where(array('status'=>array('gt',-1)));
        $list   =   $this->lists($Action);
        int_to_string($list);
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

        $this->assign('_list', $list);
        $this->meta_title = '用户行为';
        $this->display();
    }

    public function edit($id){

       $Zhuangti = D('Zhuangti');

        if(IS_POST){ //提交表单
            // unset($_REQUEST['parse']);
            // unset($_POST['parse']);
            // unset($_GET['parse']);
            $obj = $Zhuangti->create();
            // dump($_REQUEST);
            // dump($_FILES);die();
            // if($_FILES['banner']['error'] == 0){
            //     $upload = new \Think\Upload();// 实例化上传类
            //     $upload->maxSize   =     3145728 ;// 设置附件上传大小
            //     $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            //     $upload->rootPath  =     './Uploads/Picture'; // 设置附件上传根目录
            //     $upload->savePath  =     ''; // 设置附件上传（子）目录
            //     // 上传文件
            //     $info   =   $upload->upload();
            //     if(!$info) {// 上传错误提示错误信息
            //         $this->error($upload->getError());
            //     }
            //     $obj['banner'] = $info[0]['banner'];
            // }
            // dump($obj);die();

            if($Zhuangti->save($obj)){

                $this->success('编辑成功！', U('index'));
            } else {
                $error = $Zhuangti->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('Zhuangti')->field(true)->find($id);
            $cats = M('Category')->where('pid=0')->select();

            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->assign('cats', $cats);
            $this->assign('currentrootcatid', $info['rootcatid']);
            $this->meta_title = '编辑专题';
            $this->display();
        }
    }


    /**
     * 新增行为
     * @author huajie <banhuajie@163.com>
     */
    public function addAction(){
        echo 32;die();
        $this->meta_title = '新增行为';
        $this->assign('data',null);
        $this->display('');
    }

    /**
     * 编辑行为
     * @author huajie <banhuajie@163.com>
     */
    public function editAction(){
        // $id = I('get.id');echo 32;die();
        // empty($id) && $this->error('参数不能为空！');
        // $data = M('Zhuangti')->field(true)->find($id);

        // $this->assign('data',$data);
        // $this->meta_title = '编辑行为';
        // $this->display();
    }

    /**
     * 更新行为
     * @author huajie <banhuajie@163.com>
     */
    public function saveAction(){
        $res = D('Action')->update();
        if(!$res){
            $this->error(D('Action')->getError());
        }else{
            $this->success($res['id']?'更新成功！':'新增成功！', Cookie('__forward__'));
        }
    }

    /**
     * 会员状态修改
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        // if( in_array(C('USER_ADMINISTRATOR'), $id)){
        //     $this->error("不允许对超级管理员执行该操作!");
        // }
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['uid'] =   array('in',$id);
        switch ( strtolower($method) ){
            case 'forbidzhuangti':
                $this->forbid('Zhuangti', $map );
                break;
            case 'resumezhuangti':
                $this->resume('Zhuangti', $map );
                break;
            case 'deletezhuangti':
                $this->delete('Zhuangti', $map );
                break;
            default:
                $this->error('参数非法');
        }
    }

    public function add($name = '', $password = '', $repassword = '', $email = ''){
        $name = I('name');
        if(IS_POST){

            $user = array('name' => $name, 'status' => 1);

            if(!M('Zhuangti')->add($user)){
                    $this->error('新增专题失败！');
                } else {
                    $this->success('新增专题成功！',U('index'));
                }

        } else {
            $this->meta_title = '新增专题';
            $this->display();
        }
    }

    /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0){
        switch ($code) {
            case -1:  $error = '用户名长度必须在16个字符以内！'; break;
            case -2:  $error = '用户名被禁止注册！'; break;
            case -3:  $error = '用户名被占用！'; break;
            case -4:  $error = '密码长度必须在6-30个字符之间！'; break;
            case -5:  $error = '邮箱格式不正确！'; break;
            case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
            case -7:  $error = '邮箱被禁止注册！'; break;
            case -8:  $error = '邮箱被占用！'; break;
            case -9:  $error = '手机格式不正确！'; break;
            case -10: $error = '手机被禁止注册！'; break;
            case -11: $error = '手机号被占用！'; break;
            default:  $error = '未知错误';
        }
        return $error;
    }

}
