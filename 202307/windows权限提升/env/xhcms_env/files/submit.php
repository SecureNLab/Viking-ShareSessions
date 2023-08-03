<?php
session_start();
require 'inc/conn.php';
$type=addslashes($_GET['type']);
$name=$_POST['name'];
$mail=$_POST['mail'];
$url=$_POST['url'];
$content=$_POST['content'];
$cid=$_POST['cid'];
$ip=$_SERVER["REMOTE_ADDR"];
$tz=$_POST['tz'];
if ($tz==""){$tz=0;}
$jz=$_POST['jz'];

if(strtolower($_POST['randcode'])<>addslashes($_SESSION['randcode'])){ 
echo "<Script language=JavaScript>alert('抱歉，验证码错误，请重新输入！');history.back();</Script>";
exit; 
}

if (!$name<>""){
echo "<Script language=JavaScript>alert('抱歉，昵称不能为空！');history.back();</Script>";
exit;	
	}

if (!$mail<>""){
echo "<Script language=JavaScript>alert('抱歉，昵称不能为空！');history.back();</Script>";
exit;	
	}
	
if (!$content<>""){
echo "<Script language=JavaScript>alert('抱歉，您还没有告诉我您想说的话呢！');history.back();</Script>";
exit;	
	}
	
if (!preg_match("/([\x81-\xfe][\x40-\xfe])/", $content, $match)) {
echo "<Script language=JavaScript>alert('亲，再说点别的了吧？');history.back();</Script>";
exit;	
}

if ($url<>""){
if (strstr($url, "http://"))
{
$url=	$url;
}else{
$url=	"http://".$url;	
}
}
$content= addslashes(strip_tags($content));//过滤HTML

//设备类型
$useragent = $_SERVER['HTTP_USER_AGENT'];
//var_dump($user_agent);
if(stristr($useragent,'iPad')) {
$shebei= "iPad";
}else if(stristr($useragent,'Android')) {
$shebei= "Android";
}else if(stristr($useragent,'iPhone')){
$shebei= "iPhone";
}else if(stristr($useragent,'Linux')){
$shebei= "Linux";
}else{
$shebei= "PC";
}

//查询用户头像数据
$query = "SELECT * FROM interaction WHERE( mail = '$mail')";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$tx = mysql_fetch_array($result);
if (!mysql_num_rows($result)){  
$touxiang = mt_rand(1,100);
}else{
$touxiang = $tx['touxiang'];
}

if ($type=='comment'){
$fhlink="/?r=content&cid=".$cid;
$fhname="评论";
$type=1;
}
if ($type=='message'){
$fhlink="/?r=contact";
$fhname="留言";
$type=2;
}

if ($type=='download'){
$fhlink="/?r=software&cid=".$cid;
$fhname="软件评论";
$type=3;
}

//记住信息
if ($jz==1){
setcookie('name',$name,time()+3600*24*90,'/');
setcookie('mail',$mail,time()+3600*24*90,'/');
setcookie('url',$url,time()+3600*24*90,'/');
}

//查询系统高级设置
$query = "SELECT * FROM seniorset";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$advanced = mysql_fetch_array($result);
$lysh=$advanced ['lysh'];//留言审核
$plsh=$advanced ['plsh'];//评论审核
$pltz=$advanced ['pltz'];//新留言评论通知
if ($type==2){
if ($lysh==1){	
$xs="0";
}else{
$xs="1";	
}
}
if ($type==1 OR $type==3){
if ($plsh==1){	
$xs="0";
}else{
$xs="1";	
}
}

$query = "INSERT INTO interaction (
type,
xs,
cid,
name,
mail,
url,
touxiang,
shebei,
ip,
content,
tz,
date
) VALUES (
'$type',
'$xs',
'$cid',
'$name',
'$mail',
'$url',
'$touxiang',
'$shebei',
'$ip',
'$content',
'$tz',
now()
)";
@mysql_query($query) or die('新增错误：'.mysql_error());

if ($pltz==1){	
$query = "SELECT * FROM settings";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$settings = mysql_fetch_array($result);
//邮件通知
include "inc/mail.class.php";  
$smtpserver = $advanced['smtpname']; 
$port =25; //smtp服务器的端口，一般是 25 
$smtpuser = $advanced['faname']; //您登录smtp服务器的用户名 
$smtppwd = $advanced['fapass']; //您登录smtp服务器的密码 
$mailtype = "HTML"; //邮件的类型，可选值是 TXT 或 HTML ,TXT 表示是纯文本的邮件,HTML 表示是 html格式的邮件 
$sender = $advanced['faname']; 
//发件人,一般要与您登录smtp服务器的用户名($smtpuser)相同,否则可能会因为smtp服务器的设置导致发送失败 
$smtp = new smtp($smtpserver,$port,true,$smtpuser,$smtppwd,$sender); 
//$smtp->debug = true; //是否开启调试,只在测试程序时使用，正式使用时请将此行注释 
$to = $advanced['z_jsmail']; //收件人 
$subject = $settings['name']."有了新的".$fhname; 

$url=$settings['url'];
$wzname=$settings['name'];
$zz=$settings['zz'];//站长

//处理内容供邮件通知使用
$content=str_replace('<img src="/','<img src="'.$web_url.'/',$content);

if ($type==1){
$query = "SELECT * FROM content WHERE( id= $cid)";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$wz = mysql_fetch_array($result);
$title=$wz['title'];
$body ='<div style="border:1px double #090;">
<div style="background:#090; padding:10px 10px 10px 20px; color:#FFF; font-size:16px;">
<a style="text-decoration:none;color:#fff;" href="'.$url.'"  target="_blank">'.$wzname.'</a> 上有新的'.$fhname.'：
</div>
<div style=" padding:10px 10px 5px 20px; font-size:12px">亲爱的 [ '.$zz.' ] ：您好!</div>
<div style=" padding:5px 10px 10px 20px; font-size:12px">[ '.$name.' ] 在 [ '.$wzname.' ] 上对文章: 《 <a style="text-decoration:none;" href="'.$url.'/?r=content&cid='.$cid.'"  target="_blank"> '.$title.' </a> 》发表了'.$fhname.'：</div>
<div style="padding:10px 10px 10px 10px; font-size:12px; background:#f2f2f2;border:1px double #ccc; margin:0px 15px 0px 15px; line-height:25px;" >'.$content.'</div>
<div style=" padding:10px 10px 10px 20px; font-size:12px">→ 您可以点击 <a style="text-decoration:none;" href="'.$url.'/?r=content&cid='.$cid.'#Comment" target="_blank">查看完整內容</a></div>
<div style=" padding:10px 10px 10px 20px; font-size:12px"><strong>温馨提示</strong> 本邮件由系统自动发出，可以直接回复！</div>
</div>'; 
}
if ($type==2){
$body = '
<div style="border:1px double #f60;">
<div style="background:#F60; padding:10px 10px 10px 20px; color:#FFF; font-size:16px;">
<a style="text-decoration:none;color:#fff;" href="'.$url.'"  target="_blank">'.$wzname.'</a> 上有新的'.$fhname.'：
</div>
<div style=" padding:10px 10px 5px 20px; font-size:12px">亲爱的 [ '.$zz.' ] ：您好!</div>
<div style=" padding:5px 10px 10px 20px; font-size:12px">[ '.$name.' ] 在 [ '.$wzname.' ] 上发表了留言：</div>
<div style="padding:10px 10px 10px 10px; font-size:12px; background:#f2f2f2;border:1px double #ccc; margin:0px 15px 0px 15px; line-height:25px;" >'.$content.'</div>
<div style=" padding:10px 10px 10px 20px; font-size:12px">→ 您可以点击 <a style="text-decoration:none;" href="'.$url.'/?r=contact" target="_blank">查看完整內容</a></div>
<div style=" padding:10px 10px 10px 20px; font-size:12px"><strong>温馨提示</strong> 本邮件由系统自动发出，可以直接回复！</div>
</div>';
}

if ($type==3){
$query = "SELECT * FROM download WHERE( id= $cid)";
$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
$wz = mysql_fetch_array($result);
$title=$wz['title'];
$body ='<div style="border:1px double #06f;">
<div style="background:#06f; padding:10px 10px 10px 20px; color:#FFF; font-size:16px;">
<a style="text-decoration:none;color:#fff;" href="'.$url.'"  target="_blank">'.$wzname.'</a> 上有新的'.$fhname.'：
</div>
<div style=" padding:10px 10px 5px 20px; font-size:12px">亲爱的 [ '.$zz.' ] ：您好!</div>
<div style=" padding:5px 10px 10px 20px; font-size:12px">[ '.$name.' ] 在 [ '.$wzname.' ] 上对软件: 《 <a style="text-decoration:none;" href="'.$url.'/?r=software&cid='.$cid.'"  target="_blank"> '.$title.' </a> 》发表了'.$fhname.'：</div>
<div style="padding:10px 10px 10px 10px; font-size:12px; background:#f2f2f2;border:1px double #ccc; margin:0px 15px 0px 15px; line-height:25px;" >'.$content.'</div>
<div style=" padding:10px 10px 10px 20px; font-size:12px">→ 您可以点击 <a style="text-decoration:none;" href="'.$url.'/?r=software&cid='.$cid.'#Comment" target="_blank">查看完整內容</a></div>
<div style=" padding:10px 10px 10px 20px; font-size:12px"><strong>温馨提示</strong> 本邮件由系统自动发出，可以直接回复！</div>
</div>'; 
}

$send=$smtp->sendmail($to,$sender,$subject,$body,$mailtype); 

if($send==1){ 
$t_msg=",并已发送邮件通知站长"; 
}else{ 
$t_msg=",邮件通知发送失败"; 
}
 
}
if ($xs<>1){
$t_msg2=",待站长审核后显示！";	
	}

echo "<script>alert('亲爱的，".$name.','.$fhname."已经成功发表".$t_msg.$t_msg2."');location.href='".$fhlink."'</script>"; 
exit;
?>