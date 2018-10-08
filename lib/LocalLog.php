<?php
namespace lib;

class LocalLog{
    static private $print = true;

    static function Wirte($type,$worker_id,$msg,$dir=""){
        //设置信息
        $path = $dir . date("Ymd") . ".log";
        $content = date("Y-m-d H:i:m")." [$type][$worker_id]: $msg\n";

        //写入日志
        file_put_contents($path,$content,FILE_APPEND);

        //DEBUG
        if(self::$print) echo $content;
    }
}