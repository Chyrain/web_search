<html>
<head>
	<TITLE>Search</TITLE>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<style>
		 body {margin:0; padding:0;}
		 a { color: #EAEAEA; text-decoration: none; }
		 a:hover { color: #F00; }
		 input.a {width:85;height:30;}
		 form {align:center;}
		 body {font-size:15;}
		 pre {font-style:normal;margin-left:10px;}
		 li {list-style-type:none;}
		 .lfwd {font-size:20;font-weight:bold;color:#872698;font-family:"New Century Schoolbook", Times, serif ;}
		 .top {height:35px;line-height:35px;border-bottom:1px solid #E4EDF9;background:#333333;}
		 .top_left {padding-left:10px;font-size:16;color:#EAEAEA;}
		 .top_right {float:right;padding-right:10px;font-size:16;color:#EAEAEA;}
		 .submit {height:35px;width:100px;}
		 .radio {margin:20px;font-size:16;}
		 .foot {font-size:13;color:#8C8C8C;padding-top:285px;}
		 #word {width:35%;height:35px;font-size:17;}
	</style>
</head>
<body>
	<div class="top">
	<span class="top_left">
		<span><a href="../info.php" target='_blank'>phpinfo</a> |</span>
		<!--span><a href="index.html">student information search</a> |</span-->
		<span><a href="../phpmyadmin" target='_blank'>phpmyadmin</a></span>
	</span>
	<span class="top_right">
		<span>Welcome! <!--|</span>
		<span><a style="font-weight:bold;" href="login.php">Login</a>--></span>
	</span>
	</div>
<center>
	<h1 onclick="javascript:window.location.href='index.php'" style="margin-top:120;color:#8B6914;font-family:verdana">Blog Search</h1>
	<form name="post1" action="sphinx.php?page=1" method="post">
		<b class="lfwd"> Input : </b><input id="word" type="text" maxlength=100 name="word">
		<!--input class="a" type="submit" value="名单搜素" name="button1"-->
		<input class="submit" id="button2" type="submit" value="Search" name="button2"><br>
		<input class="radio" type="radio" value="2" checked="checked" name="irmod"/>普通搜索
		<input class="radio" type="radio" value="1" name="irmod"/>高级搜索
		&nbsp;&nbsp;<input type="checkbox" name="light" value="1">开启高亮
	</form>
	<ul class="foot">
		<li><span>Powered By <a style="color:#858;" href="http://chyrain.iwopop.com">Chyrain</a>|</span>@BUPT 2010-2014</li>
		<li>Copyright © message to Email:chy19910810@163.com</li>
	</ul>
</center>
</body>
</html>