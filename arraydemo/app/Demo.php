<?php

require_once 'KeyArray.php';
require_once 'GroupArray.php';
require_once 'ArrayAndObject.php';


class Demo {
	
	private static $_instance = NULL;
	
	public static function instance() {
		if (! self::$_instance)
			self::$_instance = new Demo();
		return self::$_instance;
	}
	
	public function run() {
		$this->testKeyArray();
		$this->testGroupArray();
		$this->testArrayObject();
	}

	protected function testGroupArray() {
		$group = new GroupArray();
		$group->display();
	}
	
	protected function testKeyArray() {
		$demo = new KeyArray();
		$demo->display();
	}
	
	protected function testArrayObject() {
		$demo = new ArrayAndObject();
		$demo->display();
	}
}