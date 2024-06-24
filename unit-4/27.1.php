<?php
class colours{
    public $red;
    public $blue;
    public $green;

    function __construct($red,$blue,$green){
        $this->red=$red;
        $this->blue=$blue;
        $this->green=$green;
    }

    function getall(){
        return [$this->red,$this->blue,$this->green];
    }
    function upred($x){
        $this->red=$x;
        return $this->red;
    }
    function upblue($x){
        $this->blue=$x;
        return $this->blue;
    }
    function upgreen($x){
        $this->green=$x;
        return $this->green;
    }

}

$obj1=new colours("This","is","object1");
$obj2=new colours("This","is","object2");
var_dump( $obj1->getall());
echo "<br>";
var_dump( $obj2->getall());
echo "<br>";
echo $obj1->upred("man");
echo "<br>";
echo $obj1->upblue("woman");
echo "<br>";
echo $obj2->upblue("child");
?>