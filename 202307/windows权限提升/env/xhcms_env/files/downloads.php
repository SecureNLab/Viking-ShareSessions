<?php
require 'inc/conn.php';
$line=addslashes($_GET['line']);
$type=addslashes($_GET['type']);
$fileid=addslashes($_GET['cid']);
if(!is_numeric($fileid)){
echo "错误的下载请求！";
exit;}
$query = "SELECT * FROM download WHERE ( id='$fileid')";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$down= mysql_fetch_array($result);
$fileadd=$down['softadd'];
$fileadd2=$down['softadd2'];
if ($type=='soft' AND $line=='pan'){
if ($fileadd2==""){
echo "<script language=JavaScript>alert('抱歉，程序尚在开发当中，请稍后再试！');history.back();window.close();</script>";
exit;
	}
//下载计数
$query = "UPDATE download SET xiazai = xiazai+1 WhERE id='$fileid'";
@mysql_query($query) or die('修改错误：'.mysql_error()); 

header("Location: $fileadd2"); 
exit;
}
	
if ($type=='soft' AND ($line=="telcom" OR $line=="unicom")){
$filename=$down['title'];
$filename2=$down['version'];
$filename=iconv("UTF-8", "GBK", $filename);
$houzhui=substr($fileadd,strrpos($fileadd,"."));
$sourceFile = $fileadd; //要下载的临时文件名  
$outFile = $filename." ".$filename2.$houzhui; //下载保存到客户端的文件名  
$file_extension = strtolower(substr(strrchr($sourceFile, "."), 1)); //获取文件扩展名  
//echo $sourceFile;  
//if (!ereg("[tmp|txt|rar|pdf|doc]", $file_extension))exit ("非法资源下载");  
//检测文件是否存在  
if (!is_file($sourceFile)) {  
    die("<script language=JavaScript>alert('抱歉，本地下载未发现文件，请选择网盘下载！');history.back();window.close();</script>");  
}  
$len = filesize($sourceFile); //获取文件大小  
$filename = basename($sourceFile); //获取文件名字  
$outFile_extension = strtolower(substr(strrchr($outFile, "."), 1)); //获取文件扩展名  
//根据扩展名 指出输出浏览器格式  
switch ($outFile_extension) {  
    case "exe" :  
        $ctype = "application/octet-stream";  
        break;  
    case "zip" :  
        $ctype = "application/zip";  
        break;  
    case "mp3" :  
        $ctype = "audio/mpeg";  
        break;  
    case "mpg" :  
        $ctype = "video/mpeg";  
        break;  
    case "avi" :  
        $ctype = "video/x-msvideo";  
        break;  
    default :  
        $ctype = "application/force-download";  
}  
//Begin writing headers  
header("Cache-Control:");  
header("Cache-Control: public");  
  
//设置输出浏览器格式  
header("Content-Type: $ctype");  
header("Content-Disposition: attachment; filename=" . $outFile);  
header("Accept-Ranges: bytes");  
$size = filesize($sourceFile);  
//如果有$_SERVER['HTTP_RANGE']参数  
if (isset ($_SERVER['HTTP_RANGE'])) {  
    /*Range头域 　　Range头域可以请求实体的一个或者多个子范围。  
    例如，  
    表示头500个字节：bytes=0-499  
    表示第二个500字节：bytes=500-999  
    表示最后500个字节：bytes=-500  
    表示500字节以后的范围：bytes=500- 　　  
    第一个和最后一个字节：bytes=0-0,-1 　　  
    同时指定几个范围：bytes=500-600,601-999 　　  
    但是服务器可以忽略此请求头，如果无条件GET包含Range请求头，响应会以状态码206（PartialContent）返回而不是以200 （OK）。  
    */  
    // 断点后再次连接 $_SERVER['HTTP_RANGE'] 的值 bytes=4390912-  
    list ($a, $range) = explode("=", $_SERVER['HTTP_RANGE']);  
    //if yes, download missing part  
    str_replace($range, "-", $range); //这句干什么的呢。。。。  
    $size2 = $size -1; //文件总字节数  
    $new_length = $size2 - $range; //获取下次下载的长度  
    header("HTTP/1.1 206 Partial Content");  
    header("Content-Length: $new_length"); //输入总长  
    header("Content-Range: bytes $range$size2/$size"); //Content-Range: bytes 4908618-4988927/4988928   95%的时候  
} else {  
    //第一次连接  
    $size2 = $size -1;  
    header("Content-Range: bytes 0-$size2/$size"); //Content-Range: bytes 0-4988927/4988928  
    header("Content-Length: " . $size); //输出总长  
} 
//打开文件  
$fp = fopen("$sourceFile", "rb");  
//设置指针位置  
fseek($fp, $range);  
//虚幻输出  
while (!feof($fp)) {  
    //设置文件最长执行时间  
    set_time_limit(0);  
    print (fread($fp, 1024 * 8)); //输出文件  
    flush(); //输出缓冲  
    ob_flush();  
}  
fclose($fp); 
//下载计数
$query = "UPDATE download SET xiazai = xiazai+1 WhERE id='$fileid'";
@mysql_query($query) or die('修改错误：'.mysql_error()); 
exit (); 
}
?>