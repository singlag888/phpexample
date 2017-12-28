
## 创建一个mysql 存储过程
### [我的MYSQL学习心得（十） 自定义存储过程和函数](http://www.cnblogs.com/lyhabc/p/3793524.html)

## 如果存在先删除
DROP PROCEDURE IF EXISTS test1;

## 创建存储过程
DELIMITER //
CREATE PROCEDURE test1()
BEGIN
	SELECT * FROM user;
	SELECT * FROM company;
END
//
DELIMITER ;

#调用
CALL test1();