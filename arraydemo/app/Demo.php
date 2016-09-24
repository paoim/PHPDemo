<?php

require_once 'KeyArray.php';
require_once 'GroupArray.php';
require_once 'MultiAssoArray.php';
require_once 'ArrayAndObject.php';


class Demo
{
	
	private static $_instance = NULL;
	
	public static function instance()
	{
		if (! self::$_instance)
			self::$_instance = new Demo();
		return self::$_instance;
	}
	
	public function run()
	{
		$this->testSubString("Shipment Welcome to Test LLC Shipp", 32);
		$this->testKeyArray();
		$this->testGroupArray();
		$this->testArrayObject();
		$this->testMultiAssociateArray();
		$this->testConvertStringToArray();
	}
	
	protected function testSubString($str, $maxLen)
	{
		if (strlen($str) > 0 && strlen($str) >= $maxLen) {
			$str = substr($str, 0, $maxLen). '...';
		}
		echo "<pre>"; print_r($str); echo "</pre>";
	}
	
	protected function testMultiAssociateArray()
	{
		$test = new MultiAssoArray();
		$test->display();
	}

	protected function testGroupArray()
	{
		$group = new GroupArray();
		$group->display();
	}
	
	protected function testKeyArray()
	{
		$demo = new KeyArray();
		$demo->display();
	}
	
	protected function testArrayObject()
	{
		$demo = new ArrayAndObject();
		$demo->display();
	}
	
	protected function testConvertStringToArray()
	{
		$str = "MemberRnD:12345";
		$strArray = explode(':', $str);
		echo "<pre>"; print_r($strArray); echo "</pre>";
		echo "<pre>"; print_r($strArray[1]); echo "</pre>";
	}
}
