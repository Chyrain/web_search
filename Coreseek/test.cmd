@CLS
@SET VERSION=3.2.14
@SET VERDATE=2011��1��12��
@SET VERCONF=csft.conf
@SET VERINDEX=xml
@SET VERINFO=���ķִ�����
@SET VERTEST=test_coreseek.php
@IF NOT "%1" == "" @SET VERCONF=%1
@IF NOT "%2" == "" @SET VERINDEX=%2
@IF NOT "%3" == "" @SET VERINFO=%3
@IF NOT "%4" == "" @SET VERTEST=%4

@SET TITLE=coreseek-%VERSION% win32����ƽ̨��%VERDATE%���¡���%VERINFO%���ԡ�
@TITLE %TITLE%
@ECHO %TITLE%
@PROMPT coreseek-%VERSION% [ $D $T ] $_$$$G
@SET path=.;bin;%path%
@ECHO. && @ECHO ���ü�飺indexer -c etc\%VERCONF%
@indexer -c etc\%VERCONF%
@ECHO. &&@ECHO ȫ��������indexer -c etc\%VERCONF% --all
@indexer -c etc\%VERCONF% --all
@ECHO. &&@ECHO ָ��������indexer -c etc\%VERCONF% %VERINDEX%
@indexer -c etc\%VERCONF% %VERINDEX%
@ECHO. &&@ECHO ȫ��������search  -c etc\%VERCONF%
@search  -c etc\%VERCONF%
@ECHO. &&@ECHO ����������search  -c etc\%VERCONF% -a Twittter Opera
@search  -c etc\%VERCONF% -a Twittter Opera
@ECHO ��ʾ����ΪWin32�����в�֧��UTF-8���룬������������ָ���޷�ֱ�Ӳ��ԣ�
@ECHO ָ�search  -c etc\%VERCONF% -a Twittter��Opera���ṩ����������
@ECHO.
@ECHO ��ʾ�����ʹ��iconv��ʹ��������������ָ����в��ԣ�
@ECHO ָ�ECHO �������� ^| iconv -f gbk -t utf-8 ^| search -c etc\%VERCONF% --stdin ^| iconv -f utf-8 -t gbk
@ECHO.
@ECHO �������� | iconv -f gbk -t utf-8 | search -c etc\%VERCONF% --stdin | iconv -f utf-8 -t gbk
@ECHO. && @ECHO ����ʹ���ĵ�����鿴��http://www.coreseek.cn/products/products-install/
@ECHO. && @ECHO ���Գ�����ʹ�� api/%VERTEST% ������������ && @ECHO ָ����ԣ��� CTRL+C��Ȼ��ѡ�� N�����������в��Ի���
@ECHO. && @ECHO ��������searchd  -c etc\%VERCONF% && @ECHO ����˵����������ʾ�����Ŀ��ܲ���ʾ������Ӱ��PHP����
@searchd  -c etc\%VERCONF% 
@%ComSpec% /Q /K ECHO.
