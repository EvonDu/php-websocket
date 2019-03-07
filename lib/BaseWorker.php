<?php
namespace lib;

require_once __DIR__ . '/../worker/workerman/Autoloader.php';
require_once __DIR__ . '/../worker/channel/src/Client.php';

use Workerman\Worker;

/**
 * Class BaseWorker
 * @property \Workerman\Worker $worker
 * @property \GlobalData\Client $global
 *
 */
Class BaseWorker{
    //Worker服务
    private $worker;
    public $global;

    //定义事件
    private $__onConnectEvents = [];
    private $__onCloseEvents = [];
    private $__onWorkerStartEvents = [];
    private $__onWorkerStopEvents = [];
    private $__onMessageEvents = [];
    private $__onPublishEvents = [];
    private $__onRequestEvents = [];

    //构造函数
    public function __construct($socket_name){
        $this->worker = new Worker($socket_name);
        $this->worker->onWorkerStart = array($this, 'onWorkerStart');
        $this->worker->onConnect     = array($this, 'onConnect');
        $this->worker->onMessage     = array($this, 'onMessage');
        $this->worker->onClose       = array($this, 'onClose');
        $this->worker->onWorkerStop  = array($this, 'onWorkerStop');
    }
    public function setName($name){
        $this->worker->name = $name;
    }
    public function setCount($count){
        $this->worker->count = $count;
    }

    //Workerman事件
    public function onConnect($connection){
        foreach ($this->__onConnectEvents as $event){
            $event($connection);
        }
    }
    public function onClose($connection){
        foreach ($this->__onCloseEvents as $event){
            $event($connection);
        }
    }
    public function onWorkerStart($worker){
        //执行事件
        foreach ($this->__onWorkerStartEvents as $event){
            $event($worker);
        }
        //监听组件
        //$this->listenChannel();
        //$this->listenGlobalData();
    }
    public function onWorkerStop($connection){
        foreach ($this->__onWorkerStopEvents as $event){
            $event($connection);
        }
    }
    public function onMessage($connection, $message) {
        foreach ($this->__onMessageEvents as $event){
            $event($connection, $message);
        }
    }

    //添加事件
    public function addOnConnectEvents($function){
        $this->__onConnectEvents[] = $function;
    }
    public function addOnCloseEvents($function){
        $this->__onCloseEvents[] = $function;
    }
    public function addOnWorkerStartEvents($function){
        $this->__onWorkerStartEvents[] = $function;
    }
    public function addOnWorkerStopEvents($function){
        $this->__onWorkerStopEvents[] = $function;
    }
    public function addOnMessageEvents($function){
        $this->__onMessageEvents[] = $function;
    }
    public function addOnPublishEvents($function){
        $this->__onPublishEvents[] = $function;
    }
    public function addOnRequestEvents($function){
        $this->__onRequestEvents[] = $function;
    }

    //监听信道
    public function listenChannel($ip = "127.0.0.1",$prot = 2206){
        //定义this
        $self = $this;

        //创建一个回调函数
        $channel = function($worker)use($self,$ip,$prot){
            //建立连接
            \Channel\Client::connect($ip, $prot);
            //事件处理:消息发布
            \Channel\Client::on("publish", function($event_data)use($self){
                //发布信息(群发), 并触发事件
                $self->publish($event_data);
            });
            //事件处理:服务请求
            \Channel\Client::on("request", function($event_data)use($self){
                //触发事件
                foreach ($this->__onRequestEvents as $event){
                    $event($this->worker,$event_data);
                }
            });
        };
        //添加到事件列表：onConnectEvents
        $this->addOnWorkerStartEvents($channel);
    }

    //共享数据
    public function listenGlobalData($ip = "127.0.0.1", $prot = 2207){
        //定义this
        $this->global = new \GlobalData\Client("$ip:$prot");
    }

    //外部函数
    static public function runAll(){
        Worker::runAll();
    }

    //发布信息(群发), 并触发事件
    public function publish($msg){
        //群发信息
        foreach($this->worker->connections as $connection) {
            $connection->send($msg);
        }
        //触发事件
        foreach ($this->__onPublishEvents as $event){
            $event($this->worker,$msg);
        }
    }
}