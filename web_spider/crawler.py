#-*- coding:utf8 -*-
#注：需安装MySQLdb,BeautifulSoup(bs4),urllib2的python运行环境
#** ******************************************************************************
#* crawler.py : python写的以mysql为存储引擎的网络爬虫，兼具去重、权重等功能。    *
#* *******************************************************************************
#* 声明：专为python以及信息采集需求者提供的“学习型”python爬虫，性能有待改善，	 *
#* *******************************************************************************
#* 可更具需要自由修改和应用本代码，版权归本人所有，并保留所有权利。              *
#* 			——网站地址: http://chyrain.com/  有问题可联系：chy19910810@163.com 	 *
#* *******************************************************************************
#* $Author: 陈海勇 $From BUPT    				                                 *
#* $Date: 2013-12-18 16:59:00 $                                                  * 
#* *******************************************************************************

import urllib2
import re
from bs4 import BeautifulSoup
import MySQLdb
import sys
import time
import os

#setdefaultencoding 用于对中文编码的处理
reload(sys)
sys.setdefaultencoding('utf8')

try:
	db=MySQLdb.connect(host='127.0.0.1',user='root',passwd='chy123456',db='blogdata',port=3306,charset='utf8',use_unicode=False)
	cur=db.cursor()
except MySQLdb.Error,e:
	print "No.1 Mysql Error %d: %s" % (e.args[0], e.args[1])
	os.system('pause')


def save_link(url,title,keywords,description,fullcontent,text):
	fileHandle = open ( 'config.ini','r+');
	now = int(fileHandle.readline());
	now = now+1
	point =int(fileHandle.readline())
	try:	
		count=cur.execute('select id from links where url=\''+str(url)+'\'')
	except MySQLdb.Error,e:
		print "No.2 Mysql Error %d: %s" % (e.args[0], e.args[1])
		cur.close()
		db.close()
		os.system('pause')
	if (count == 0):
		try:
			cur.execute('insert into links(id,url)values(\''+\
						str(now)+'\',\''+str(url)+'\')')
			db.commit()
		except MySQLdb.Error,e:
			print "No.3 Mysql Error %d: %s" % (e.args[0], e.args[1])
			cur.close()
			db.close()
			os.system('pause')
		
		fileHandle.close()
		fileHandle = open ( 'config.ini','w');
		fileHandle.write(str(now)+'\n'+str(point))
		fileHandle.close()
		
		fileHandle = open ( 'D:/mysql/pages/'+str(now)+'.html','w');###保存下载网页到文本文件,需要自己修改指定路径
		fileHandle.write(text)							###保存下载网页到文本文件
		
		doc_now=str(now)
		doc_url=str(url)
		doc_key=str(keywords)
		doc_key=doc_key.replace("\"",'')	#去单双引号，防止mysql插入语法错误
		doc_key=doc_key.replace("\'",'')
		doc_tit=str(title)
		doc_tit=doc_tit.replace("\"",'')
		doc_tit=doc_tit.replace("\'",'')
		doc_des=str(description)
		doc_des=doc_des.replace("\"",'')
		doc_des=doc_des.replace("\'",'')
		doc_ful=''.join(str(fullcontent).split())
		doc_ful=doc_ful.replace("\"",'')
		doc_ful=doc_ful.replace("\'",'')
		doc_ful=''.join(doc_ful.split())
		cur.execute('set names utf8')
		try:
		#	sql='insert into sina_documents(id,link_id,url,title,keywords,description,fullcontent)values(\''+\
		#				doc_now+'\',\''+doc_now+'\',\''+doc_url+'\',\''+doc_tit+'\',\''+doc_key+'\',\''+doc_des+'\',\"'+doc_ful+'\")'
			confir=cur.execute('insert into sina_documents(id,link_id,url,title,keywords,description,fullcontent)values(\''+\
						doc_now+'\',\''+doc_now+'\',\''+doc_url+'\',\''+doc_tit+'\',\''+doc_key+'\',\''+doc_des+'\',\"'+doc_ful+'\")')
			db.commit()
		except MySQLdb.Error,e:
			print "No.4 Mysql Error %d: %s" % (e.args[0], e.args[1])
			cur.close()
			db.close()
			os.system('pause')
		if confir:
			print "&&&--> Get-Page-(%d) <--&&&" % now
		else:
			print "Insert False!"
	else:
		print "**** ALREADY EXISTS ****"	#已存在则更新链接链入权重（可用于网页质量权重）
		try:
			id = cur.fetchone()[0]
			db.commit()
			doc_now =str(id)		
			cur.execute('update sina_documents set hits=hits+1 WHERE id = \''+doc_now+'\'')	#hits加一
			db.commit()
		except MySQLdb.Error,e:
			print "No.5 Mysql Error %d: %s" % (e.args[0], e.args[1])
	fileHandle.close()
	print time.strftime('%Y-%m-%d %H:%M:%S',time.localtime(time.time()))+'\n\n'
	#print "================= Finish One =================\n\n"

	
def crawler_myself(url_str):
	try:
		req = urllib2.Request(url_str)
		text = urllib2.urlopen(req).read()
	except urllib2.URLError,e:
		print "No.1 URLError %d: %s" % (e.args[0], e.args[1])
	soup = BeautifulSoup(text)
	title = soup.find('title').contents[0]
	metas = soup.findAll('meta')
	re_description = re.compile(r'Description|description|DESCRIPTION')	#大小写可能出现情况
	re_keyword = re.compile(r'Keywords|keywords|KEYWORDS')
	for meta in metas:
		if re.search(re_keyword,str(meta)):
			keywords = meta.get('content')
		if re.search(re_description,str(meta)):
			description = meta.get('content')
	for tag in soup.findAll('script'):	#去掉js和css代码内容
		tag.extract()
	for tag in soup.findAll('style'):
		tag.extract()
	fullcontent = soup.get_text()
	save_link(url_str,title,keywords,description,fullcontent,text)

	
def crawler_others(url,rules):
	try:
		req = urllib2.Request(url)
		text_tmp = urllib2.urlopen(req)
	except urllib2.URLError,e:
		print "No.2 URLError %d: %s" % (e.args[0], e.args[1])
	text=text_tmp.read()
	lines=''.join(text.splitlines())
	re_url = re.compile(rules)
	re_description = re.compile(r'Description|description|DESCRIPTION')
	re_keyword = re.compile(r'Keywords|keywords|KEYWORDS')
	mainsoup = BeautifulSoup(lines)######.decode('gb2312','ignore'))
	anchors = mainsoup.findAll('a')
	for anchor in anchors:
		temp_str = str(anchor)
		if anchor:
			temp_url = re.search(re_url,temp_str)
			if temp_url:
				url_str=anchor.get('href')	#通过bs4 get找出url
				#temp_str=temp_url.group(0) #通过正则找出url
				#url_str=temp_str[6:-1]	#获得http://...内容(可能因空格出现失误)
				print "URL: "+url_str
				try:
					req = urllib2.Request(url_str)
					text = urllib2.urlopen(req).read()
				except urllib2.URLError,e:
					print "No.3 URLError %d: %s" % (e.args[0], e.args[1])
				soup = BeautifulSoup(text)
				title = str(soup.find('title').contents[0])
				metas = soup.findAll('meta')
				for meta in metas:
					if re.search(re_keyword,str(meta)):
						keywords = meta.get('content')
					if re.search(re_description,str(meta)):
						description = meta.get('content')
				for tag in soup.findAll('script'):	#去掉js和css代码内容
					tag.extract()
				for tag in soup.findAll('style'):
					tag.extract()
				fullcontent = soup.get_text()
			#	print str(fullcontent)
			#	print "TITLE: "+title#+"\n"
			#	print "KEYWORDS: "+str(keywords)
			#	print "description: "+str(description)
			#	print "fullcontent: "+str(fullcontent)
				save_link(url_str,title,keywords,description,fullcontent,text)							   
			  
if __name__ == '__main__':
	start_url="http://blog.sina.com.cn/"	#url种子
	rules=r'href\s*=\s*(?:\"(http://blog\.sina\.com\.cn/[^\"]+)\")'	#正则:只抓新浪博客
	while(1):
		fileHandle = open ( 'config.ini','r+')
		now=int(fileHandle.readline());
		point =int(fileHandle.readline());
		fileHandle.close()
		if now == 0:	#首次运行先解析url种子
			point = 1
			crawler_myself(start_url)
		
		cur.execute('select url from links where id=\''+str(point)+'\'')	#获取当前抓取进度(新的父节点)
		uurl=cur.fetchone()[0]
		print "SRC-URL: %s" % uurl
		if uurl:
			try:
				fileHandle = open ( 'config.ini','w')
				fileHandle.write(str(now)+'\n'+str(point+1))
				fileHandle.close()
				crawler_others(uurl,rules)
				#print "#|#|#|#|#|#|##|#|#|#|#|#|#|#|#|#"	#有时这句话无法执行，creep_others肯定出现错误直接中断了循环，但不会影响网页爬取
			except Exception , e:
				pass
	
	cur.close()
	db.close()
	
	
