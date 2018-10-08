<?php
namespace lib;

class ApiResponse{
    static public function send($code=0,$msg=null,$data=null){
        $response = [
            "code"=>$code,
            "msg"=>$msg,
            "data"=>$data
        ];
        header('Content-type: application/json');
        echo json_encode($response);
        die;
    }
}