<?php
 class greeting{
    public static $x=" This is static variable";

    public static function greet(){
        echo("This is static method<br/>");
    }

}

greeting::greet();
echo(greeting::$x);
?>