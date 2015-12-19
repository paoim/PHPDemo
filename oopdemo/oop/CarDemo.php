<?php

require_once 'inheritance/Camaro.php';

class CarDemo
{
	public function display()
	{
		$car1 = new Camaro();
		$car1->accelerate($car1->_brand, $car1->_max);
		echo "<pre>"; print_r($car1); echo "</pre>";
	}
}
