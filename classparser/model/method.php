<?php

class Method
{
	
	private $_name;
	private $_return;
	private $_isFinal;
	private $_isStatic;
	private $_isAbstract;
	private $_visibility;
	private $_description;
	private $_comments = array();
	
	public function getName()
	{
		return $this->_name;
	}
	
	public function getFinal()
	{
		return $this->_isFinal;
	}
	
	public function getStatic()
	{
		return $this->_isStatic;
	}
	
	public function getAbstract()
	{
		return $this->_isAbstract;
	}
	
	public function getVisibility()
	{
		return $this->_visibility;
	}
	
	public function getReturn()
	{
		return $this->_return;
	}
	
	public function getDescription()
	{
		return $this->_description;
	}
	
	public function getComments() {
		return $this->_comments;
	}
	
	public function setName($name)
	{
		$this->_name = $name;
	}
	
	public function setFinal($isFinal)
	{
		$this->_isFinal = $isFinal;
	}
	
	public function setStatic($isStatic)
	{
		$this->_isStatic = $isStatic;
	}
	
	public function setAbstract($isAbstract)
	{
		$this->_isAbstract = $isAbstract;
	}
	
	public function setVisibility($visibility)
	{
		$this->_visibility = $visibility;
	}
	
	public function setReturn($return)
	{
		$this->_return = $return;
	}
	
	public function setDescription($description)
	{
		$this->_description = $description;
	}
	
	public function setComments($comments = array())
	{
		$this->_comments = $comments;
	}
}
