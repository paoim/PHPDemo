<?php


class Car
{
	public function accelerate($_brand, $_max)
	{
		if ($this->_speed <= $_max) {
			$this->_speed += 1;
			return true;
		} else {
			echo $this->_brand . 'Reached max speed';
		}
		function drive()
		{
			$this->accelerate();
		}
	}
	
	public $_speed = 0;
	public $_brand = 'unknown';
	public $_max = 0;
}
