<?php
highlight_file(__FILE__);
error_reporting(0);
class Test
{
    public $test;
    public function __construct($test){
        $this->test = $test;
    }

    public function __wakeup()
    {
        $this->test = 'nono';
        echo('hehe</br>');
    }

    public function __destruct()
    {
        eval($this->test);
    }
}
unserialize($_GET['a']);
?>