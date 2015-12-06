<?php

class Data
{
	
	private $_name;
	private $_description;
	private $_methods = array();
	private $_comments = array();
	private $_properties = array();
	
	public function getName()
	{
		return $this->_name;
	}
	
	public function getDescription()
	{
		return $this->_description;
	}
	
	public function getMethods()
	{
		return $this->_methods;
	}
	
	public function getComments()
	{
		return $this->_comments;
	}
	
	public function getProperties()
	{
		return $this->_properties;
	}
	
	public function setName($name)
	{
		$this->_name = $name;
	}
	
	public function setDescription($description)
	{
		$this->_description = $description;
	}
	
	public function setMethods($methods = array())
	{
		$this->_methods = $methods;
	}
	
	public function setComments($comments = array())
	{
		$this->_comments = $comments;
	}
	
	public function setProperties($properties = array())
	{
		$this->_properties = $properties;
	}
}
