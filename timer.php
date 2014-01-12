<?php
class timer
{
	var $time_start;
	var $time_end;

	function __construct()
	{
		$this->time_start = 0;
		$this->time_end = 0;
	}

	function timer()
	{
		$this->__construct();
	}

	function start()
	{
		list($usec,$sec) = explode(" ",microtime());
		$this->time_start = (float)$usec + (float)$sec;
	}

	function stop()
	{
		list($usec,$sec) = explode(" ",microtime());
		$this->time_end = (float)$usec + (float)$sec;
	}

	function show($output = false)
	{ 
		$total = $this->time_end - $this->time_start;
		if ($output) {
			echo $total," sec";
			return true;
		}
		return $total;
	}
}

function m_substr($str,$start,$len){	//取字串，防止中英混合串结尾出现中文只有一半
	$t = explode(" ",microtime());
	$tt = round($t[0],5);
	$j = 0; //记录截取的字符串的字符位置
	$s = 0; //记录已经截取的字符长度
	$str_temp = "";//记录截取的字符串
	$k = strlen($str);
	for($i=0;$i<$k;){//循环全部字
	     if($s>=$len) break;//如果已经截取的字符串长度超过要截取的长度 跳出循环 返回结果
	     if(ord(substr($str,$i,1))>0xa0){ //判断是否为汉字
			 if($j+1>=$start){//如果当前截取字符位置大于等于要截取的字符串的开始位置并且当前已经截取的字符长度还没有超出要截取的字符串的长度 则将此字符为要截取的字符
			     $str_temp .= substr($str,$i,3);
				 $s++;//已经截取的字符串长度加1
			 }
			 $j++;//当前截取的字符串的位置加1
			 $i+=3;//确定为汉字 在utf8编码下占三个英文字符的长度 则需要记录三个字符
		 }else{
			 if($j+1>=$start){
				 $str_temp .= substr($str,$i,1); //截取英文字符
			     $s++;//已经截取的字符串长度加1
			 }
			 $j++;//当前截取的字符串的位置加1
			 $i++;//非汉字字符占一个字符的长度
		 }
	}
	$t = explode(" ",microtime());
	$ttt = round($t[0],5);
	//return $ttt-$tt;
	return $str_temp;
}

?>