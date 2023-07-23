<?php
function filter($str){
    return str_replace('bb', 'ccc', $str);
}
class A{
   public $name='bbb';
   public $pass='123456';
//     public $name='bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb";s:4:"pass";s:6:"hacker";}';
//     public $pass='123456';
}
$AA=new A();
echo serialize($AA);$res=filter(serialize($AA));
echo '</br>';
echo $res;
echo '</br>';
$c=unserialize($res);
echo $c->pass;
echo '</br>';
echo $c->name;
?>