<?php
//引入依赖
require_once 'vendor/autoload.php';

//引入配置
$config = require_once 'config/main.php';

//获取信息参数(事件与信息)
$events = isset($argv[1]) ? $argv[1] : "publish";
$message = isset($argv[2]) ? $argv[2] : "message";

//连接信道，发送信息
try{
    //连接服务
    @Channel\Client::connect('127.0.0.1', $config['channel_port']);
    //publish为在服务中定义的事件，$data参数支持对象但这个事件只限字符串
    @Channel\Client::publish("publish", $message);
}catch (Exception $e){
    exit("[*] ERROR <$events>: $message\n");
}

//返回信息
exit("[*] SUCCESS <$events>: $message\n");