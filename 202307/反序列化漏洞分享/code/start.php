<?php
highlight_file(__FILE__);
class CTF{
    public $flag='flag{welc0me_7o_serialize_wor1d!}';
    public $name='psych';
    //public $age='3';          // s:3:"age";
    protected $age = '3';     //s:6:"*age";    "\00*\00age"
    //private $age='3';          //s:8:"ctfage"     "\00ctf\00age"

}

$ctfer=new CTF(); 
echo urlencode(serialize($ctfer));     //urlencode()
?>