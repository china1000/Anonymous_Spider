Anonymous_Spider
================

This project is a anonymous spider which mimics user action, by creating fake referer, fake user-agent,fake cookies. And the most important thing is that this spider can not be detected by php, js and ajax. It's so great and easy to use!!

该项目基于phantomjs开发了一个匿名的爬虫，该爬虫修改了 referer, User-Agent, http-header，把自己伪装成客户的浏览行为。并且该爬虫无法被js/php/ajax识别。

第1章	 匿名爬虫
1.1phantomjs简介
Phantomjs介绍：phantomjs是一个无界面webkit内核的javascript API接口。它速度很快并且支持各种网页标准：DOM、CSS、JSON、Canvas、SVG。
官网：http://phantomjs.org/
Phantomjs使用说明：http://www.tuicool.com/articles/nieEVv

1.1.1 安装和服务搭建：
1. 请直接将phantomjs程序拷贝到/bin/目录下。
2.  安装apache：yum install apache.
3.  准备目录： 
mkdir /search

mkdir /search/usr

mkdir /search/usr/httpd
4. 安装目录：
useradd test –G root 
visudo 之后添加如下代码（可以不一定需要，但是建议这么做）：
		           test    ALL=(ALL)       NOPASSWD:ALL
6. service httpd start.

1.1.2 注意：
1.     修改/search/usr/httpd的目录权限：
	    Chown test:root
	     Phantomjs的接口javascript程序。
2.      jump.php
接收http请求并给 fake-referer.js和bad-url.sh传递相关的参数。Fake-referre.js多次执行控制和结果校检。
Php 代码比较简单，主要是就是调用shell_exec，调用phantomjs对网页进行处理。


1.1.3 其他的问题：
1. 其他的问题请联系聂鹏宇。QQ:778959011， mail: spider_npy@163.com


2. 遇到phantomjs使用问题，参考前面提到的官网和使用说明，注意官网中的issue可以提供很多的知识。


3. phantomjs 还只是一个新的开源项目，目前存在一些bug，软件并发效率还有待提升。目前测试网页跳转qps在4以上，预期网页跳转+网页内容会低于4，截图效率会更低。


4. phantomjs很吃内存，可能会出现内存占用太大导致机器死机。建议定时重启，建议定期kill所有的phantomjs进程。
