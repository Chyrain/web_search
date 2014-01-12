@CLS
@SET VERSION=3.2.14
@SET VERDATE=2011年1月12日
@SET VERCONF=csft.conf
@SET VERINDEX=xml
@SET VERINFO=中文分词搜索
@SET VERTEST=test_coreseek.php
@IF NOT "%1" == "" @SET VERCONF=%1
@IF NOT "%2" == "" @SET VERINDEX=%2
@IF NOT "%3" == "" @SET VERINFO=%3
@IF NOT "%4" == "" @SET VERTEST=%4

@SET TITLE=coreseek-%VERSION% win32测试平台【%VERDATE%更新】【%VERINFO%测试】
@TITLE %TITLE%
@ECHO %TITLE%
@PROMPT coreseek-%VERSION% [ $D $T ] $_$$$G
@SET path=.;bin;%path%
@ECHO. && @ECHO 配置检查：indexer -c etc\%VERCONF%
@indexer -c etc\%VERCONF%
@ECHO. &&@ECHO 全部索引：indexer -c etc\%VERCONF% --all
@indexer -c etc\%VERCONF% --all
@ECHO. &&@ECHO 指定索引：indexer -c etc\%VERCONF% %VERINDEX%
@indexer -c etc\%VERCONF% %VERINDEX%
@ECHO. &&@ECHO 全部搜索：search  -c etc\%VERCONF%
@search  -c etc\%VERCONF%
@ECHO. &&@ECHO 内容搜索：search  -c etc\%VERCONF% -a Twittter Opera
@search  -c etc\%VERCONF% -a Twittter Opera
@ECHO 提示：因为Win32命令行不支持UTF-8输入，以下中文搜索指令无法直接测试：
@ECHO 指令：search  -c etc\%VERCONF% -a Twittter和Opera都提供了搜索服务
@ECHO.
@ECHO 提示：如果使用iconv，使用如下中文搜索指令进行测试：
@ECHO 指令：ECHO 网络搜索 ^| iconv -f gbk -t utf-8 ^| search -c etc\%VERCONF% --stdin ^| iconv -f utf-8 -t gbk
@ECHO.
@ECHO 网络搜索 | iconv -f gbk -t utf-8 | search -c etc\%VERCONF% --stdin | iconv -f utf-8 -t gbk
@ECHO. && @ECHO 最新使用文档，请查看：http://www.coreseek.cn/products/products-install/
@ECHO. && @ECHO 测试程序：请使用 api/%VERTEST% 测试搜索服务 && @ECHO 指令测试：按 CTRL+C，然后选择 N，进入命令行测试环境
@ECHO. && @ECHO 搜索服务：searchd  -c etc\%VERCONF% && @ECHO 服务说明：以下提示中中文可能不显示，但不影响PHP搜索
@searchd  -c etc\%VERCONF% 
@%ComSpec% /Q /K ECHO.
