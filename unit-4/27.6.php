<?php
class Animal {
    public function makeSound() {
        echo "The animal makes a sound.\n";
    }
}

class Dog extends Animal {
    public function makeSound() {
        echo "The dog barks.\n";
    }
}

class Cat extends Animal {
    public function makeSound() {
        echo "The cat meows.\n";
    }
}

$animal = new Animal();
$animal->makeSound(); // Output: The animal makes a sound.

$dog = new Dog();
$dog->makeSound(); // Output: The dog barks.

$cat = new Cat();
$cat->makeSound(); // Output: The cat meows.