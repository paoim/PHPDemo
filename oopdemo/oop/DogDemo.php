<?php

require_once 'inheritance/Poodle.php';

class DogDemo {
	
	public function display() {
		$attributes = array('id' => 123);
		$dog = new Dog($attributes);
		echo "<pre>"; print_r($dog); echo "</pre>";
		
		$poodle = new Poodle($attributes);
		echo "<pre>"; print_r($poodle); echo "</pre>";
	}
}