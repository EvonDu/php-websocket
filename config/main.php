<?php
//尝试读取本地配置
$config_local = file_exists(__DIR__.'/main-local.php') ? require(__DIR__.'/main-local.php') : [];

//返回配置内容
return array_merge([
    //配置WebSocket服务
    "websocket_ip"=>"0.0.0.0",
    "websocket_port"=>2000,

    //配置Channel服务
    "channel_ip"=>"0.0.0.0",
    "channel_port"=>2206,

    //配置GlobalData服务
    "data_ip"=>"0.0.0.0",
    "data_port"=>2207,

    //配置日志文件夹
    "log_dir"=>"logs/"
], $config_local);