<?php
//定义启用全局开启
define("GLOBAL_START",true);

//引入相关类
//require_once __DIR__ . '/worker/workerman/Autoloader.php';
//require_once __DIR__."/server/globaldata.php";
require_once __DIR__."/server/channel.php";
require_once __DIR__."/server/websocket.php";

//启动服务
Workerman\Worker::runAll();