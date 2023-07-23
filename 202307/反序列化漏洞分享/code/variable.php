<?php
highlight_file(__FILE__);
class Test{
private $test;
public function __construct($test)
{
$this->test = $test;
}
public function __destruct()
{
eval($this->test);
}
}unserialize($_GET['a']);
?>