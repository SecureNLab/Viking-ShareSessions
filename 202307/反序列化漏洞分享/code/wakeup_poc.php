<?php
class Test
{
    public $test;
    public function __construct($test){
        $this->test = $test;
    }
}
$a = new Test('phpinfo();');
//echo urlencode(serialize($a));
echo serialize($a);

