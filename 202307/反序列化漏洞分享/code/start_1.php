<?php
highlight_file(__FILE__);
class CTF{
    public $flag='flag{welc0me_7o_serialize_wor1d!}';
    public $name='psych';
    public $age='3';
    public function __tosting(){
        $this ->age='5';
    }

}

$ctfer=new CTF(); 
echo serialize($ctfer);     //urlencode()
?>