<html>
<head>
	<TITLE>Search</TITLE>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<style>
		 body {margin:0; padding:0;font-size:15;height: 100%;line-height:150%}
		 a.fot { color: #27408B;font-size:18; font-weight:bold;}
		 a { color: #EAEAEA; }
		 a:hover { color: #436EEE; }
		 input.a {width:90px;height:36px;}
		 form {align:center;}
		 li {list-style-type:none;}
		 .top {height:35px;line-height:35px;border-bottom:1px solid #E4EDF9;background:#333333;}
		 .top_left {padding-left:10px;font-size:16;color:#EAEAEA;}
		 .top_right {float:right;padding-right:10px;font-size:16;color:#EAEAEA;}
		 .top_title {font-size:24;}
		 .foot {font-size:13;color:#8C8C8C;padding-bottom:15px;text-align:center;}
		 .pageNum {text-align:left;padding-top:30px;padding-left:5%;margin-left:10px;}
		 .content {padding-left:5%;width:800px;}
		 #word {width:40%;height:35px;font-size:20;margin-top:5px;}
		 pre {font-style:normal;margin-left:10px;}
		 p {margin-left:0px;}//#font-style:italic;}
		 b {font-size:15;font-weight:bold;color:#8B6914;font-family:verdana}
		 #bottom{width:100%;}
		 #ltt {padding-left:5%;margin-left:10px;margin-top:20px;}
	</style>
</head>
<?php
	error_reporting(0);
	require 'sphinxapi.php';
	require 'timer.php';
	if(!$_GET['word'])
		$keyword=$_POST['word'];
	else
		$keyword=$_GET['word'];
	if(!$_GET['irmod'])
		$irmod=$_POST['irmod'];
	else
		$irmod=$_GET['irmod'];	
	if(!$_GET['irmod'])
		$light=$_POST['light'];
	else
		$light=$_GET['light'];	
	$Timer2=new timer();
	$Timer2->start();////////////////
?>
<body>
	<div class="top">
	<span class="top_left">
		<span><a href="../info.php" target="_blank">phpinfo</a> |</span>
		<!--span><a href="index.html">student information search</a> |</span-->
		<span><a href="../phpmyadmin" target="_blank">phpmyadmin</a></span>
	</span>
	<span class="top_right">
		<span>Welcome! <!--|</span>
		<span><a style="font-weight:bold;" href="login.php">Login</a>--></span>
	</span>
	</div>
	<form id="ltt" name="post1" action="sphinx.php?page=1" method="post">
		<b class="top_title" onclick="javascript:window.location.href='index.php'">Blog Search</b>
		&nbsp;&nbsp;&nbsp;&nbsp;<input class="radio" type="radio" value="2" <?php if($irmod == 2) echo "checked='checked'"; ?> name="irmod"/>普通搜索
		<input class="radio" type="radio" value="1" <?php if($irmod == 1) echo "checked='checked'"; ?> name="irmod"/>高级搜索
		&nbsp;&nbsp;<input type="checkbox" name="light" value="1">开启高亮<br>
		<input id="word" type="text" name="word" value="<?php echo $keyword; ?>">
		<!--input class="a" type="submit" value="名单搜素" name="button1"-->
		<input class="a" type="submit" value="Search" name="button2" onclick="validation();">
	</form>
	<div id="content" class="content">
<?php
	$Timer1=new timer();	//计时器
	$Timer1->start();
	$sphinx=new SphinxClient();
	$sphinx->SetServer("localhost",9312);
	if($irmod == '1')
	{
		$sphinx->SetMatchMode(SPH_MATCH_EXTENDED2);
	}
//	else if($irmod == '2')
//		$sphinx->SetMatchMode(SPH_MATCH_PHRASE);
	#$sphinx->SetSortMode(SPH_SORT_RELEVANCE);
//	$sphinx->SetSortMode(SPH_SORT_EXTENDED,"@weight DESC");###########
	$sphinx->SetSortMode(SPH_SORT_EXPR,"hits*0.1+@weight*5");
	$sphinx->setLimits(0,1000,1000);
	$sphinx->SetIndexWeights( array ( "title"=>50, "keywords"=>10, "description"=>5 ) );
	$result=$sphinx->query($keyword,"mysql");
	echo "<pre>";
//	print_r($result);
	echo "</pre>";
	$ids=join(",",array_keys($result['matches']));
	$row_num = $result['total'];
	$Timer1->stop();
	if($row_num <=0 )
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;<font style='font-weight:bold;color:#f00;'>没有您想要的结果...</font>";
	}
	else
	{	
	#	$Timer2=new timer();
	#	$Timer2->start();////////////////
		$gPageSize=10;	//每页显示记录数
		$page = $_GET['page'];	//页数
		if(!isset($page)) $page=1;
		if($page==0) $page=1;
		$start = ($page-1)*$gPageSize;
		$end = $page*$gPageSize;
		mysql_connect("localhost","root","chy123456");
		mysql_select_db("blogdata");
		$sql="select id, url, title, description, updatetime,hits,fullcontent from sina_documents where id in({$ids}) order by field(id,{$ids}) limit {$start},{$end}"; ##";hits desc 
		mysql_query("set names utf8");
		$rst=mysql_query($sql);
		$opts=array(
			"before_match"=>"<font style='color:#f00;'>",
			"after_match"=>"</font>"
		);
		//#$row_num=mysql_num_rows($rst);###
		
		$MaxPage=(int)ceil($row_num/$gPageSize);
		if((int)$page>$MaxPage)
			$page=$MaxPage;
		$format_number1 = number_format($Timer1->show(false), 3, '.', '');
		echo "<p style='margin-left:10px;'>共搜索到<b style='color:red;'>{$row_num}</b>条记录，耗时 {$result['time']} / {$format_number1} s。<br></p>";
		if($rst)
		{
			$pg = 0;
			//循环显示当前纪录集
			$i = $start;
			for($pg;$pg<$gPageSize&&$i<$row_num;$pg++)
			{
			#	$Timer2->start();////////////////
				if($light)
				{
					$row=mysql_fetch_assoc($rst);
					if(strlen($row['description']))	
						$row['description']=m_substr($row['description'],0,80);
					else
						$row['description']=m_substr($row['fullcontent'],0,80);
					if($row['title'])	
						$row['title']=m_substr($row['title'],0,80);
					else
						$row['title']=m_substr($row['url'],0,80);
					$rst2=$sphinx->buildExcerpts($row,"mysql",$keyword,$opts);	//"mysql"为索引名！
				}
				else
					$rst2=mysql_fetch_array($rst);
				$i=$i+1;
				echo "<pre>";
				#echo "Hits:{$rst2[5]}  ";
				echo "<a href=\"{$rst2[1]}\" class='fot' target='_blank'>{$rst2[2]}</a><br>";
			//	echo "关键字：{$rst2[3]}<br>";
				echo "{$rst2[3]}<br>";
				echo "<span style='color:#006400;'>{$rst2[4]} | {$rst2[1]}</span><br>";
				echo "</pre>";
			#	$Timer2->stop();////////////////
			#	$format_number2 = number_format($Timer2->show(false), 3, '.', '');
			#	echo "<p>本条耗时<b style='color:red;'>{$format_number2}s</b>。<br></p>";
			}
		}
	}
	$Timer2->stop();////////////////
	$format_number2 = number_format($Timer2->show(false), 3, '.', '');
	echo "<p style='margin-left:10px;'>本页共<b style='color:red;'>{$gPageSize}</b>条记录，耗时{$format_number2}s。<br></p>";
?>
	</div>
	<div class="pageNum">
         <?php
		if($row_num>0) #=mysql_num_rows($rst))>0)
		{
 		 $prevPage=$page-1;
		 $nextPage=$page+1;
		 echo   "<span style='font-weight:bold;'><a class='fot' href='sphinx.php?page=1&word=$keyword&irmod=$irmod'>首页</a><<";    
		 echo   "<a class='fot' href='sphinx.php?page=$prevPage&word=$keyword&irmod=$irmod'>上一页</a><</span>";
		 if($page>10)
		 {
			for($j=$page-7;$j<=$page+7&&$j<=$MaxPage;$j++)
			{	
				$k=$j;
				if($j==$page)
					echo   "<span>".$j." </span>";
				else
					echo   "<a class='fot' href='sphinx.php?page=$k&word=$keyword&irmod=$irmod'>".$j." </a>";
			}
		}
		else
		{
			for($j=1;$j<=15&&$j<=$MaxPage;$j++)
			{	
				$k=$j;
				if($j==$page)
					echo   "<span>".$k." </span>";
				else
					echo   "<a class='fot' href='sphinx.php?page=$k&word=$keyword&irmod=$irmod'>".$k." </a>";
			}
		}
		echo   "<span style='font-weight:bold;'>><a class='fot' href='sphinx.php?page=$nextPage&word=$keyword&irmod=$irmod'>下一页</a>>>";
		echo   " <a class='fot' href='sphinx.php?page=$MaxPage&word=$keyword&irmod=$irmod'>末页</a></span>";
		}
         ?>
	</div>
	<div id="bottom">
		<ul class="foot">
			<li><span>Power By <a style="color:#858;" href="http://chyrain.com">Chyrain</a>|</span>@BUPT 2010-2014</li>
			<li>Copyright © message to Email:chy19910810@163.com</li>
		</ul>
	</div>
</body>
</html>
