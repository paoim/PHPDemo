<?php

require_once 'ArrayDemo.php';
require_once '../util/arrayparser/ArrayParser.php';


class Demo {
	
	private static $_instance = NULL;
	
	public static function instance() {
		if (! self::$_instance)
			self::$_instance = new Demo();
		return self::$_instance;
	}
	
	public function run() {
		$this->demoArray();
		$this->testGroupArray();
	}

	protected function testGroupArray() {
		$parser = new ArrayParser();
		$parser->display();
	}
	
	protected function demoArray() {
		$demo = new ArrayDemo();
		$demo->display();
	}
}