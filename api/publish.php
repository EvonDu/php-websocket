<?php
//引入依赖
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../worker/channel/src/Client.php';

//获取信息参数
$message = isset($_REQUEST["msg"]) ? $_REQUEST["msg"] : null;

//连接信道，发送信息
try{
    @Channel\Client::connect('127.0.0.1', 2206);
    @Channel\Client::publish("publish", array('content' => $message));
}catch (Exception $e){
    lib\ApiResponse::send(500,'publish message fail.');
}

//返回信息
lib\ApiResponse::send(0,'OK',$message);