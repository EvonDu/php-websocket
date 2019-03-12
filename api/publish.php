<?php
//引入依赖
require_once __DIR__ . '/../vendor/autoload.php';

//引入配置
$config = require_once __DIR__ . '/../config/main.php';

//获取信息参数
$message = isset($_REQUEST["msg"]) ? $_REQUEST["msg"] : null;

//连接信道，发送信息
try{
    //连接服务
    @Channel\Client::connect('127.0.0.1', $config['channel_port']);
    //publish为在服务中定义的事件，$data参数支持对象但这个事件只限字符串
    @Channel\Client::publish("publish", $message);
}catch (Exception $e){
    lib\ApiResponse::send(500,'publish message fail.');
}

//返回信息
lib\ApiResponse::send(0,'OK',$message);