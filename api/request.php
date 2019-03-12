<?php
/**
 * 信息广播
 * @OA\Get(
 *      path="/session",
 *      tags={"WebSocket"},
 *      summary="会话通信",
 *      description="对特定订单会话客户端进行发送信息",
 *      @OA\Parameter(name="order_no", required=true, in="query",description="订单号", @OA\Schema(type="string", default="cz201902163464976422")),
 *      @OA\Parameter(name="data", required=true, in="query",description="信息", @OA\Schema(type="string", default="测试信息")),
 *      @OA\Response(response="default", description="返回结果")
 * )
 */

//引入依赖
require_once __DIR__ . '/../vendor/autoload.php';

//引入配置
$config = require_once __DIR__ . '/../config/main.php';

//获取信息参数
$message = isset($_REQUEST["msg"]) ? $_REQUEST["msg"] : null;
$data = array(
    'type'      => "session",
    'content'   => $message,
);

//连接信道，发送信息
try{
    //连接服务
    @Channel\Client::connect('127.0.0.1', $config['channel_port']);
    //request为在服务中定义的事件，$data参数支持对象
    @Channel\Client::publish("request", $data);
}catch (Exception $e){
    lib\ApiResponse::send(500,'publish message fail.');
}

//返回信息
lib\ApiResponse::send(0,'OK',$message);