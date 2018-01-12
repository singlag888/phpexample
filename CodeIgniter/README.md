CodeIgniter
============


## 应用程序流程图

![CI流程图](img/appflowchart.png)

1. index.php 文件作为前端控制器，初始化运行 CodeIgniter 所需的基本资源；
1. Router 检查 HTTP 请求，以确定如何处理该请求；
1. 如果存在缓存文件，将直接输出到浏览器，不用走下面正常的系统流程；
1. 在加载应用程序控制器之前，对 HTTP 请求以及任何用户提交的数据进行安全检查；
1. 控制器加载模型、核心类库、辅助函数以及其他所有处理请求所需的资源；
1. 最后一步，渲染视图并发送至浏览器，如果开启了缓存，视图被会先缓存起来用于 后续的请求。

## PhpStrom使用CI自动提示

1. 下载[phpStorm-CC-Helpers](https://github.com/topdown/phpStorm-CC-Helpers)  
2. 将`CodeIgniter`文件夹下三个文件放到项目中和`index.php`同一个目录。`DB_active_rec.php`改名为`DB_query_builder.php`,原理未知,和`database`下文件同名。
3. 将`CI`三个核心文件`system/core/Controller.php`,`system/core/Model.php`和`system/database/DB_query_builder`，右击`Make as Plain Text`。
4. 在`my_models.php`中添加需要提示的model注释。如`@property NewsModel $NewsModel`。
5.项目中model可使用`http://***.com/CodeIgniter/index.php/Welcome/listModelFile`方法获取所有`model`类名。

参考：  
[配置phpstorm完美支持Codeigniter(CI)代码自动完成(代码提示)](http://blog.csdn.net/wzj0808/article/details/54910024) 
[PHPStorm配置CodeIgniter的代码自动补全](http://www.taoyuetong.com/phpstorm%E9%85%8D%E7%BD%AEcodeigniter%E7%9A%84%E4%BB%A3%E7%A0%81%E8%87%AA%E5%8A%A8%E8%A1%A5%E5%85%A8/)   
