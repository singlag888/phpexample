在线记事本
========

区分用户功能

登陆后左侧方格显示简要信息 及 新建按纽

右边显示分类 ：根据颜色分类

右上角新建按纽

便签内容支持：文字 。待办事项列表。图片。 上下排序，不支持排版。



数据表：
用户表
  注册和登陆
    id,name,password,email, date

颜色标签
  代码固定内容

便签表
  用户id，颜色标签，
  id,  内容？先使用文本, date 


create table user(
id int unsigned not null auto_increment primary key,
name char(8) not null,
pwd char(16) not null,
email char(20) not null,
date timestamp not null
);


create table note(
id int unsigned not null auto_increment primary key,
note text,
user_id int not null,
label int,
create_time timestamp not null,
update_time timestamp not null
)
    
  
 
