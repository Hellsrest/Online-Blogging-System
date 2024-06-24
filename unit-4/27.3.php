<?php
class man{
    private $name;

    function __construct($name){
        $this->name=$name;
    }

    function namecall(){
        return "my name is ".$this->name."<br/>";
    }
}
class child extends man{
    private $ccolor;
    function __construct($name, $ccolor) {
        parent::__construct($name); 
        $this->ccolor = $ccolor;
    }

    function colorcall(){
        return "my color is ".$this->ccolor."<br/>";
    }

}



$child=new child("Bisham","Black");
echo $child->namecall();
echo $child->colorcall();
?>