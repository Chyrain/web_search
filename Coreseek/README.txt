最新使用文档，请查看：http://www.coreseek.cn/products/products-install/

测试说明：
coreseek-3.x版本，需安装：Microsoft Visual C++ 2005 运行环境 (x86，2.6M)，http://www.microsoft.com/downloads/details.aspx?FamilyID=32bc1bee-a3f9-4c13-9c99-220b62a191ee&displaylang=zh-cn
coreseek-4.x版本，需安装：Microsoft Visual C++ 2008 运行环境 (x86，1.7M)，http://www.microsoft.com/downloads/details.aspx?FamilyID=9b2da534-3e03-4391-8a4d-074b9f2bc1bf&displayLang=zh-cn

test.cmd：
    测试对象：xml数据源，中文分词与搜索
    对应配置：etc/csft.conf
    测试数据：var/test/test.xml
    PHP程序：api/test_coreseek.php
    在线说明：http://www.coreseek.cn/products/products-install/install_on_windows/

test_cjk.cmd：
    测试对象：xml数据源，单字切分与搜索
    对应配置：etc/csft_cjk.conf
    测试数据：var/test/test.xml
    PHP程序：api/test_coreseek.php
    在线说明：http://www.coreseek.cn/products-install/ngram_len_cjk/

test_mysql.cmd：
    测试对象：mysql数据源，中文分词与搜索
    对应配置：etc/csft_mysql.conf
    测试数据：var/test/documents.sql
    PHP程序：api/test_coreseek.php
    测试说明：请先将测试数据导入数据库，并设置好配置文件中的MySQL用户密码数据库
    在线说明：http://www.coreseek.cn/products-install/mysql/

test_python.cmd：
    测试对象：python数据源，中文分词与搜索
    对应配置：etc/csft_demo_python.conf
    数据脚本：etc/pysource/csft_demo/__init__.py
    PHP程序：api/test_coreseek.php
    测试说明：请先安装Python 2.6 Windows (x86)
    在线说明：http://www.coreseek.cn/products-install/python/

自行测试：
    测试对象：python+mssql数据源，中文分词与搜索
    对应配置：etc/csft_demo_python_pymssql.conf
    数据脚本：etc/pysource/csft_demo_pymssql/__init__.py
    PHP程序：api/test_coreseek.php
    测试说明：请先安装Python 2.6 Windows (x86)、pymssql（py2.6）
    在线说明：http://www.coreseek.cn/products-install/python/

coreseek-4.0测试：
test_rtindex.cmd：
    测试对象：RT实时索引，中文分词与搜索
    对应配置：etc/csft_rtindex.conf
    PHP程序：api/test_coreseek_rtindex.php
    在线说明：http://www.coreseek.cn/products-install/rt-indexes/
    
test_rtindex_cjk.cmd：
    测试对象：RT实时索引，单字切分与搜索
    对应配置：etc/csft_rtindex_cjk.conf
    PHP程序：api/test_coreseek_rtindex.php
    在线说明：http://www.coreseek.cn/products-install/rt-indexes/
