<?php
abstract class Shape {
    abstract public function ar();
}

class Circle extends Shape {
    private $r;
    public function __construct($r) {
        $this->r = $r;
    }
    public function ar() {
        return "of circle=".(3.14 * $this->r ** 2);
    }
}

class Rectangle extends Shape {
    private $length;
    private $width;
    public function __construct($length, $width) {
        $this->length = $length;
        $this->width = $width;
    }
    public function ar() {
        return "of rectangle=".$this->length * $this->width;
    }
}

foreach ([new Circle(3), new Rectangle(1, 2)] as $shape) {
    echo "Area " . $shape->ar() . "<br>";
}
?>