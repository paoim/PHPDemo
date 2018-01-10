<?php

class MathDemo
{
	public function __construct() {
		$this->display();
	}
	
	private function display() {
		$this->_getZero();
	}
	
	private function _getZero() {
		$data = abs(-.00025);
		echo "<pre>"; print_r("Hello Zero"); echo "</pre>";
		echo "<pre>"; print_r($data); echo "</pre>";
	}
}