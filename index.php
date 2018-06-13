<?php
/**
 * 微信测试号正式启用
 * Created by PhpStorm.
 * User: yzq
 * Date: 2016/12/7
 * Time: 15:56
 */

//开启调试模式
define("APP_DEBUG", false);
//绑定Agent模块到当前入口文件
define('BIND_MODULE','Api');    //application interface
//定义应用目录
define("APP_PATH", "./Application/");
//定义目录分隔符简写形式
define("DS", DIRECTORY_SEPARATOR);
//定义网站根目录
define("ROOT_PATH", dirname(__FILE__) . DS);
//定义公共文件目录
define("WEIXIN_ASSETS", "./Public/weixin_assets/");
//加载框架入口文件
include './ThinkPHP/ThinkPHP.php';