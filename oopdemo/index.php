<?php

require_once 'oop/CarDemo.php';
require_once 'oop/DogDemo.php';

$demo = new DogDemo();
$demo->display();

$demo = new CarDemo();
$demo->display();
