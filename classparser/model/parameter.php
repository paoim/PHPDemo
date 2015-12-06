<?php

class Parameter
{
	
	private $_name;
	private $_desc;
	
	public function getName()
	{
		return $this->_name;
	}
	
	public function getDesc()
	{
		return $this->_desc;
	}
	
	public function setName($name)
	{
		$this->_name = $name;
	}
	
	public function setDesc($desc)
	{
		$this->_desc = $desc;
	}
}
