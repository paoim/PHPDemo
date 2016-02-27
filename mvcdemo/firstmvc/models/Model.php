<?php

require_once 'Query.php';

class Model
{
	public $query;
	
	public function __construct($table)
	{
		//PrintUtil::display("I am inside " .__CLASS__);
		$this->query = new Query($table);
	}
}
