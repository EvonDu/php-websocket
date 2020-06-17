# PHP-WebSocket服务
### 简介
使用WorkerMan搭建基础WebSocket服务，再使用其Channel组件建立Channel服务用作与WebSocket的通信。当使用WebApi的方式调用PHP时，就会连接上Channel服务并通过其对WebSocket服务进行信息广播到连接客户端。


### 安装方法
* 克隆项目：`clone <url>`
* 安装依赖：`composer install`
* 配置文件：`config/main.php`

### 使用方法
* 启动服务：
    * windows：`run.bat start`
    * linux：`php run.php start`
* 停止服务：
    * windows：`run.bat stop`
    * linux：`php run.php stop`
* 广播接口：
    * 接口：`api/publish.php`
    * msg（参数）：发送的信息
    
### 测试页面
* 客户端：`test/client.php`
* 发送端：`test/server.php`

### 命令行发布事件
* 执行方法：`php cmd.php <事件> <消息>`
    * 例子：`php cmd.php publish "Hello Word!"`
    
### 项目配置
##### 本地化配置
* 创建`config/main-local.php`
* 然后参考`config/main.php`进行配置