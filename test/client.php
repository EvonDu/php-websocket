<?php
    $config = include "../config/main.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>测试客户端</title>
    <script src="assets/layui/layui.js"></script>
    <link rel="stylesheet" href="assets/layui/css/layui.css"/>
    <link rel="stylesheet" href="assets/layui/css/modules/code.css"/>
    <link rel="stylesheet" href="css/main.css"/>
</head>
<body>
    <!-- 发送元素 -->
    <div class="input-group">
        <input name="input" lay-verify="title" autocomplete="off" placeholder="请输入信息" class="layui-input" type="text">
        <button class="layui-btn" onclick="sendMessage()">发送信息</button>
    </div>
    <!-- 信息板面 -->
    <pre class="layui-code">信息面板：</pre>
</body>
</html>

<!-- layui -->
<script>
    layui.use('code', function(){
        //初始化面板
        layui.code({skin: 'notepad'});
        //初始化ws服务
        websocketInit();
    });
</script>
<!-- ws -->
<script>
    //ws操作
    ws = null;
    connecting = false;
    function websocketInit(){
        ws = new WebSocket("ws://<?=$_SERVER['HTTP_HOST']?>:<?=$config["websocket_port"]?>");
        ws.onopen = function() {
            connecting = true;
            printMessage("连接成功!");
        };
        ws.onclose = function() {
            connecting = false;
            printMessage("连接断开!");
        };
        ws.onmessage = function(e) {
            printMessage("收到消息："+ e.data);
        };
    }

    //发送信息
    function sendMessage(){
        //过滤断开状态
        if(!connecting)
            return;

        //获取元素
        var input = document.getElementsByName('input')[0];

        //发送信息
        ws.send(input.value);

        //输出信息
        printMessage("发送消息："+input.value);

        //清空信息
        input.value = "";
    }

    //输出信息
    function printMessage(msg){
        //获取元素
        var ol = document.getElementsByClassName('layui-code-ol')[0];

        //新增元素
        var li = document.createElement('li');
        li.innerText = msg;
        ol.appendChild(li);
    }
</script>