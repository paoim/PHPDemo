<?php

require_once 'namespacedemo/GlobalDemo.php';
require_once 'namespacedemo/MultipleDemo.php';

$demoMe = new DemoMe();
$demoMe->display();

$demo = new \MyFirstDemo\FirstDemo();
$demo->display();

use MyFirstDemo\SecondDemo;
$demo = new SecondDemo();
$demo->display();

$demo = new \MySecondDemo\FirstDemo();
$demo->display();

$demo = new \MySecondDemo\SecondDemo();
$demo->display();
