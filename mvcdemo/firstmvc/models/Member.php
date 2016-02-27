<?php

class Member extends Model
{
	public function __construct()
	{
		//PrintUtil::display("I am inside " .__CLASS__);
		$table = strtolower(__CLASS__);
		parent::__construct($table);
	}
}
