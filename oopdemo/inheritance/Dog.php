<?php

class Dog
{
	
	public $id = 0;
	
	public function __construct($attributes = array())
	{
		foreach ($attributes as $field=>$value) {
			$this->$field = $value;
		}
	}
}
