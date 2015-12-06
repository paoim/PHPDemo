<?php

namespace MyFirstDemo {

	class FirstDemo
	{
		public function display() {
			new \Display("I am using multiple namespace in ". __CLASS__. " Class.");
		}
	}
	
	class SecondDemo
	{
		public function display() {
			new \Display("I am using multiple namespace in ". __CLASS__. " Class.");
		}
	}
}

namespace MySecondDemo {
	
	class FirstDemo
	{
		public function display() {
			new \Display("I am using multiple namespace in ". __CLASS__. " Class.");
		}
	}
	
	class SecondDemo
	{
		public function display() {
			new \Display("I am using multiple namespace in ". __CLASS__. " Class.");
		}
	}
}

namespace {
	// Global Demo
	class Display
	{
		public function __construct($sms = "I am Global namespace.") {
			echo "<pre>"; print_r($sms); echo "</pre>";
		}
	}
}
