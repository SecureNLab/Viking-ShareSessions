<?php
class Img
{
var $src_img; //源图片文件名;
var $new_img_w; //生成图片的宽度;
var $new_img_h; //生成图片的高度;
var $new_img_name; //生成图片的文件名;
var $mode; //图片显示模式 1=>居中,2=>裁切,3=>等比;

var $Img_srcName; //源图片文件名(绽放后);
var $Img_Water; //水印图片文件名;
var $Img_objName; //生成图片文件名;
var $Img_water_xy; //水印位置 1=>左上角;2=>居中;3=>右下角;
function Img_BigToSamll($src_img,$new_img_w,$new_img_h,$new_img_name,$mode)
{
list( $src_img_w,$src_img_h ) = @getimagesize( $src_img );
$ww = $src_img_w / $new_img_w;
$hh = $src_img_h / $new_img_h;
if( $ww > $hh )
{
    $nw = $new_img_w; 
    $nh = round($src_img_h / $ww);
   }else{
    $nw = @round($src_img_w / $hh);
    $nh = $new_img_h;
}

if($mode==1) //居中
{
   $x = 0;$y = 0;
   if($nh < $new_img_h)
   {
    $y = ($new_img_h - $nh)/2;
   }
   if($nw < $new_img_w)
   {
    $x= ($new_img_w -$nw)/2;
   }
   $bg = @imagecreatetruecolor( $new_img_w,$new_img_h );
   $fg = @imagecreatefromjpeg( $src_img ); 
   @imagecopyresampled( $bg,$fg,$x,$y,0,0,$nw,$nh,$src_img_w,$src_img_h );
}

if($mode==2) //裁切
{ 
   @$bili = $nh/$nw;
   if($nw > $new_img_w){$nw = $new_img_w;$nh = round($nw*$bili);}
   if($nh > $new_img_h){$nh = $new_img_h;$nw = round($nh/$bili);}
   if($nh < $new_img_h){$nh = $new_img_h;$nw = round($nh/$bili);}
   if($nw < $new_img_w){$nw = $new_img_w;$nh = round($nw*$bili);}
   $x = 0; $y = 0;
   if($nw > $new_img_w) {$x   = $nw-$new_img_w;}
   if($nh > $new_img_h) {$y   = $nh-$new_img_h;}
   $bg = @imagecreatetruecolor( $new_img_w,$new_img_h );
   $fg = @imagecreatefromjpeg( $src_img ); 
   @imagecopyresampled( $bg,$fg,0,0,$x,$y,$nw,$nh,$src_img_w,$src_img_h );
   //echo "nw".$nw."nh".$nh."x".$x."y".$y.$bili;
}
if($mode==3) //等比
{
   $bg = @imagecreatetruecolor( $nw,$nh );
   $fg = @imagecreatefromjpeg( $src_img ); 
   @imagecopyresampled($bg,$fg,0,0,0,0,$nw,$nh,$src_img_w,$src_img_h);
}
@imagejpeg($bg,$new_img_name);
@imagedestroy($bg);
return $new_img_name;
}

function Img_Watermark($Img_srcName,$Img_Water,$Img_objName,$Img_water_xy)
{
list($IS_w,$IS_h,$IS_t) = @getimagesize($Img_srcName);
switch($IS_t)
{
   case 1:$Img_Source = @imagecreatefromgif($Img_srcName);break;
   case 2:$Img_Source = @imagecreatefromjpeg($Img_srcName);break;
}
list($IW_w,$IW_h,$IW_t) = @getimagesize($Img_Water);
switch($IW_t)
{
   case 1:$Img_Water   = @imagecreatefromgif($Img_Water);break;
   case 3:$Img_Water   = @imagecreatefrompng($Img_Water);break;
}
switch($Img_water_xy)
{
   case 1:$x = 10;$y = 0;break; 
   case 2:$x = ($IS_w-$IW_w)/2;$y = ($IS_h-$IW_h)/2;break; 
   case 3:$x = $IS_w-$IW_w-10;$y = $IS_h-$IW_h;break; 
   default:$x = 10;$y = 0;
}
@imagecopy($Img_Source,$Img_Water,$x,$y,0,0,$IW_w,$IW_h);
@imagejpeg($Img_Source,$Img_objName);
return $Img_objName;
}
}
?>