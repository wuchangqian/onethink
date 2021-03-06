<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * UCenter客户端配置文件
 * 注意：该配置文件请使用常量方式定义
 */

define('UC_APP_ID', 1); //应用ID
define('UC_API_TYPE', 'Model'); //可选值 Model / Service
define('UC_AUTH_KEY', 'Z$r0MtxdNQ@!PBaJ{Xib-y%[FW)vouGhL6lkO#n+'); //加密KEY
// echo 32;
// echo APP_ENV;die();
    // define('UC_DB_DSN', 'mysqli://root:sys123@127.0.0.1:3306/www.onethink-local.com'); //
if(defined('APP_ENV') && APP_ENV =='dev'){
    define('UC_DB_DSN', 'mysqli://root:sys123@120.26.114.184:3306/onethink'); //

}else if(defined('APP_ENV') && APP_ENV =='prod'){
    define('UC_DB_DSN', 'mysqli://root:didzhanmei821z@127.0.0.1:3306/onethink');
}; // 数据库连接，使用Model方式调用API必须配置此项
define('UC_TABLE_PREFIX', 'one_'); // 数据表前缀，使用Model方式调用API必须配置此项
