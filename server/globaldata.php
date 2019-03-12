<?php
/**
 * 注意：GlobalData组件无法共享资源类型的数据，例如mysql连接、socket连接等无法共享。
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../worker/workerman/Autoloader.php';

use Workerman\Worker;
use GlobalData\Server;

//加载配置
$config = require dirname(__DIR__)."/config/main.php";
$ip = $config["data_ip"];
$port = $config["data_port"];

// 连接Global Data服务端
$global = new Server($ip,$port);

//判断是否使用全局启动，如果不是则直接启动：
//Linux下需要统一启动，否则会丢失后面的服务
//Window下则需要用批处理脚本分别启动，因为windows下的php没有完善的进程控制接口
if(!defined('GLOBAL_START'))
    Worker::runAll();