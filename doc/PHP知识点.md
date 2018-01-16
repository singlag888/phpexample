

php设定错误和异常处理三函数:
register_shutdown_function(array(‘Debug’,’fatalError’)); //定义PHP程序执行完成后执行的函数
set_error_handler(array(‘Debug’,’appError’)); // 设置一个用户定义的错误处理函数
set_exception_handler(array(‘Debug’,’appException’)); //自定义异常处理。


