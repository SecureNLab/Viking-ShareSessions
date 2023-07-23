<?php
error_reporting(0);
highlight_file(__FILE__);

class w44m
{

    private $admin = 'aaa';
    protected $passwd = '123456';
    
    public function Getflag()
    {
        if ($this->admin === 'w44m' && $this->passwd === '08067') 
        {
        echo('you get the flag!');
        }
        else 
        {
        echo $this->admin;
        echo $this->passwd;
        echo 'nono';
        }
    }
}

class w22m
{
    public $w00m;

    public function __destruct()
    {
    echo $this->w00m;
    }
}

class w33m
{
    public $w00m;
    public $w22m;
    
    public function __toString()
    {
    $this->w00m->{$this->w22m}();   
    return 0;
    }
}
unserialize($_GET['a']);

?>