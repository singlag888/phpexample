

php设定错误和异常处理三函数:
register_shutdown_function(array(‘Debug’,’fatalError’)); //定义PHP程序执行完成后执行的函数
set_error_handler(array(‘Debug’,’appError’)); // 设置一个用户定义的错误处理函数
set_exception_handler(array(‘Debug’,’appException’)); //自定义异常处理。


[php 发送与接收流文件](http://blog.csdn.net/fdipzone/article/details/40098169)  

[http协议中:GET/POST/PUT/DELETE/TRACE/OPTIONS/HEAD方法](http://www.cnblogs.com/lurenq/p/6890881.html)  
[自建证书配置HTTPS服务器](http://www.liuchungui.com/blog/2015/09/25/zi-jian-zheng-shu-pei-zhi-httpsfu-wu-qi/)
apache配置https

