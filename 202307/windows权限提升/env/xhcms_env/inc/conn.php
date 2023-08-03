<?php
	error_reporting(0);
	header('Content-Type:text/html;charset=utf-8');
	require 'conn.info.php';
	//常量参数
	define('DB_HOST',$DB_HOST);
	define('DB_USER',$DB_USER);
	define('DB_PWD',$DB_PWD);
	define('DB_NAME',$DB_NAME);
	
	//第一步，连接MYSQL服务器
	$conn = @mysql_connect(DB_HOST,DB_USER,DB_PWD) or die(header('Location: /install'));
	
	//第二步，选择指定的数据库，设置字符集
	mysql_select_db(DB_NAME) or die('数据库错误，错误信息：'.mysql_error());
	mysql_query('SET NAMES UTF8') or die('字符集设置错误'.mysql_error());
	date_default_timezone_set('PRC'); //设置中国时区
?>