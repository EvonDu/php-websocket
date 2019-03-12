<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../worker/workerman/Autoloader.php';

use Channel\Server;
use Workerman\Worker;

//加载配置
$config = require dirname(__DIR__)."/config/main.php";
$ip = $config["channel_ip"];
$port = $config["channel_port"];

//开启信道服务
$chanel = new Server($ip, $port);

//判断是否使用全局启动，如果不是则直接启动：
//Linux下需要统一启动，否则会丢失后面的服务
//Window下则需要用批处理脚本分别启动，因为windows下的php没有完善的进程控制接口
if(!defined('GLOBAL_START'))
    Worker::runAll();