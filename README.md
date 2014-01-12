web_search
==========
[Info]
This project is a simple web Search Engine, use Coreseek(sphinx+mmseg) and a simple spider designed by python, and web API of PHP.

[web_spider]
A simple web spider,use python.

[Coreseek]
Sphinx(Its Chinese version with mmseg is named Coreseek) is a full-text search engine, distributed under GPL version 2. Commercial licensing (eg. for embedded use) is also available upon request.

Generally, it's a standalone search engine, meant to provide fast, size-efficient and relevant full-text search functions to other applications. Sphinx was specially designed to integrate well with SQL databases and scripting languages.

Currently built-in data source drivers support fetching data either via direct connection to MySQL, or PostgreSQL, or from a pipe in a custom XML format. Adding new drivers (eg. to natively support some other DBMSes) is designed to be as easy as possible.

Search API is natively ported to PHP, Python, Perl, Ruby, Java, and also available as a pluggable MySQL storage engine. API is very lightweight so porting it to new language is known to take a few hours.

As for the name, Sphinx is an acronym which is officially decoded as SQL Phrase Index. 

[index.php | sphinx.php | timer.php | sphinxapi.php]
The main directory has these PHP files: index.php | sphinx.php | timer.php | sphinxapi.php.
index.php | sphinx.php | timer.php : is my search page.
sphinxapi.php : is an API for PHP of Sphinx.

说明：
这整个项目内容是用于搭建一个基于sphinx全文检索的搜索引擎，包含python写的爬虫，php写的搜索页面，并用mysql作为存储引擎和检索的数据源，当然核心是基于sphinx的修改版Coreseek的中文检索，此项目可移植到Linux平台，在Linux平台会有更好的表现。
  Coreseek：
    本文件夹内容为Coreseek-3.2.14-win32版本的配置完整版，可根据自己需求配置适合自己数据源和API接口，下文是本人的修改说明：

	Coreseek/etc/csft_mysql.conf 是我修改过的配置文件，var/data下存放索引文档，可根据conf文件对mysql数据源建立索引
	mysql数据源对应的数据表见blog.mysql

	需要linux版本可到官网下载相应版本，搭建方法以及程序结构与windows版本基本一致，使用文档在官网：http://www.coreseek.cn/docs/coreseek_3.2-sphinx_0.9.9.html
	
  web_spider:
	此爬虫本是针对新浪博客内容爬取，经过正则表达式修改可用于各种网页爬取，效率不高，仅作学习测试之用。
	请先阅读：
	1.首次运行请先更改crawler.py中有注释的63行，改为你的html文件存储路径（可以不存，将62，63,64这三行注释掉即可），
	  并且按照blog.sql建立好数据表，然后修改config.ini，此文件前两行分别记录抓取网页数量和当前在抓第几个文档,首次运行请都置0
	2.在Python27环境下运行为佳，其他环境未测试
	3.第一次运行时若显示数据库插入错误，则关掉运行窗口，修改config.ini前两行都改为1，再运行就不会出错（原因是源URL自身插入后文档计数器now的问题，再运行没错可以不管）
	4.本程序支持断点操作，即在关闭后，会在config.ini记录着当前进度，下次直接运行即可接上进度
	5.若您的python环境已经安装MySQLdb和bs4则可以不需要这两个文件夹

	阅读上文并修改后请运行 crawler.py
	
  blog.sql:
	blog.sql是数据库新建和两个数据表的新建SQL语句，python爬虫抓取的网页信息就存储在该库和表中，同时是coreseek sphinx的数据源，也是PHP连接mysql的数据库和数据表。
	
  php页面：
	包括index.php sphinx.php timer.php 主要用于提供搜索所需的web页面，利用sphinxapi.php连接sphinx的searchd服务（确保searchd服务在运行才可进行搜索）
	
	


