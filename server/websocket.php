<?php
require_once __DIR__ . '/../vendor/autoload.php';

use lib\BaseWorker;
use \lib\LocalLog;

//加载配置
$config = require dirname(__DIR__)."/config/main.php";
$ip = $config["websocket_ip"];
$port = $config["websocket_port"];
$channel_port = $config["channel_port"];

//建立服务
$server = new BaseWorker("websocket://$ip:$port");
$server->setCount(4);
$server->setName("WebSocketServer");
$server->listenChannel("127.0.0.1",$channel_port);
$server->addOnMessageEvents(function($connection,$message)use($config){
    LocalLog::Wirte("receive",$connection->worker->id,$message,$config["log_dir"]);
});
$server->addOnPublishEvents(function($worker,$message)use($config){
    LocalLog::Wirte("publish",$worker->id,$message,$config["log_dir"]);
});

//判断是否使用全局启动，如果不是则直接启动：
//Linux下需要统一启动，否则会丢失后面的服务
//Window下则需要用批处理脚本分别启动，因为windows下的php没有完善的进程控制接口
if(!defined('GLOBAL_START'))
    BaseWorker::runAll();