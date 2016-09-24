<?php

class LastDayOfMonth
{
	public function __construct() {
		$this->display();
	}
	
	private function display() {
		echo "<pre>"; print_r(date("Y-m-t", strtotime(date('Y-m-d')) )); echo "</pre>";
		echo "<pre>"; print_r(date("Y-m-1", strtotime(date('Y-m-d')))); echo "</pre>";
	}
}