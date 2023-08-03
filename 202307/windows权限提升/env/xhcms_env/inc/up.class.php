<?php
class FileUpload_Single
{
//user define ------------------------------------- 
var $accessPath ;
var $fileSize=4000;
var $defineTypeList="jpg|jpeg|gif|bmp|png";//string jpg|gif|bmp  ...
var $filePrefix= "";//上传后的文件名前缀，可设置为空 
var  $changNameMode=0;//图片改名的规则，暂时只有三类，值范围 : 0 至 2 任一值
var $uploadFile;//array upload file attribute 
var $newFileName;
var $error;

function TODO() 
{//main　主类:设好参数，可以直接调用
$pass = true ;
if ( ! $this -> GetFileAttri() )
{
   $pass = false;
}
if( ! $this -> CheckFileMIMEType() )
 {
 $pass = false;
 $this -> error .= die("<script language=\"javascript\">alert('图片类型不正确，允许格式：jpg｜jpeg｜gif｜bmp。');history.back()</script>");
} 

if( ! $this -> CheckFileAttri_size() )
{
   $pass = false;
   $this -> error .= die("<script language=\"javascript\">alert('上传的文件太大，请确保在".$fileSize."K以内。');history.back()</script>");
   return false;
}
  
if ( ! $this -> MoveFileToNewPath() )
{
    $pass = false;
	$this -> error .=  die("<script language=\"javascript\">alert('上传失败！文件移动发生错误！');history.back()</script>");
}  
  return $pass;
} 
function GetFileAttri()
{
  foreach( $_FILES as $tmp )
  {
   $this -> uploadFile = $tmp;
  }
  return (empty( $this -> uploadFile[ 'name' ])) ? false : true;
}
 
function CheckFileAttri_size()
{
  if ( ! empty ( $this -> fileSize ))
  {
   if ( is_numeric( $this -> fileSize ))
   {
    if ($this -> fileSize > 0)
    {
     return ($this -> uploadFile[ 'size' ] > $this -> fileSize * 1024) ? false : true ; 
    }   
   }
   else
   {
    return false;
   }
  }
  else
  {
   return false;
  }
 }
 function ChangeFileName ($prefix = NULL  , $mode)
 {// string $prefix , int $mode
  $fullName = (isset($prefix)) ? $prefix."" : NULL ;
  switch ($mode)
  {
   case 0   : $fullName .= rand( 0 , 100 ). "_" .strtolower(date ("ldSfFYhisa")) ; break;
   case 1   : $fullName .= rand( 0 , 100 ). "_" .time(); break;
   case 2   : $fullName .= rand( 0 , 10000 ) . time();   break;
   default  : $fullName .= rand( 0 , 10000 ) . time();   break;
  }
  return $fullName;
 }
 function MoveFileToNewPath()
 {
  $newFileName = NULL;
  $newFileName = $this -> ChangeFileName( $this -> filePrefix , 2 ). "." . $this -> GetFileTypeToString();
  //检查目录是否存在,不存在则创建，当时我用的时候添加了这个功能，觉得没用的就注释掉吧
  /*
  $isFile = file_exists( $this -> accessPath);
  clearstatcache();
   if( ! $isFile && !is_dir($this -> accessPath) )
   {
	   echo $this -> accessPath;
    @mkdir($this -> accessPath);
   }*/
$array_dir=explode("/",$this -> accessPath);//把多级目录分别放到数组中
 for($i=0;$i<count($array_dir);$i++){
  $path .= $array_dir[$i]."/";
  if(!file_exists($path)){
   mkdir($path);
  }
 }
/////////////////////////////////////////////////////////////////////////////////////////////////
	if ( move_uploaded_file( $this -> uploadFile[ 'tmp_name' ] , realpath( $this -> accessPath ) . "/" . $newFileName ) ) 
	{
		$this -> newFileName = $newFileName;
			return true;
	}else{
		return false;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
} 
function CheckFileExist( $path = NULL)
 {
  return ($path == NULL) ? false : ((file_exists($path)) ? true : false);
 }
function GetFileMIME()
 {
  return $this->GetFileTypeToString();
 }
function CheckFileMIMEType()
 {
  $pass = false;
  $defineTypeList = strtolower( $this ->defineTypeList);
  $MIME = strtolower( $this -> GetFileMIME());
  if (!empty ($defineTypeList))
  {
   if (!empty ($MIME))
   {
    foreach(explode("|",$defineTypeList) as $tmp)
    {
     if ($tmp == $MIME)
     {
      $pass = true;
     }
    }
   }
   else
   {
    return false;
   }      
   }
   else
   {
   return false;
   }
   return $pass;
 }
 
 function GetFileTypeToString()
 {
  if( ! empty( $this -> uploadFile[ 'name' ] ) )
  {
   return substr( strtolower( $this -> uploadFile[ 'name' ] ) , strlen( $this -> uploadFile[ 'name' ] ) - 3 , 3 );  
  }
 }
}
?>