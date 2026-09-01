<?php
/**
 * Lab 03 - PHP OOP Tasks
 * Full Name: Faisal Stanizay
 * Student ID: R0106382873
 */

// Task 1: Create and Use a Class Constant
// The MAX_BOOKS value is constant because it represents a fixed rule
// that applies to all instances of the Library class and should never change.
class Library {
    const MAX_BOOKS = 3;
}

echo "Task 1 Output: <br>";
echo " books allowed: " . Library::MAX_BOOKS . "<br>";

class StudentCounter {
    public static $count = 0;

    public static function addStudent() {
        self::$count++;
    }
}

StudentCounter::addStudent();
StudentCounter::addStudent();
StudentCounter::addStudent();

echo "Task 2 Output:<br>";
echo "Total students: " . StudentCounter::$count . "<br>";

abstract class Vehicle {
    abstract public function start();
}

class Car extends Vehicle {
    public function start() {
        echo "Car engine started. <br>";
    }
}

class Bike extends Vehicle {
    public function start() {
        echo "Bike started. <br>";
    }
}

echo "Task 3 Output:<br>";
$car = new Car();
$bike = new Bike();
$car->start();
$bike->start();
?>