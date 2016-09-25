<?php

class LastDayOfMonth
{
	public function __construct() {
		$this->display();
	}
	
	private function display() {
		echo "<pre>"; print_r(date("Y-m-t", strtotime(date('Y-m-d')) )); echo "</pre>";
		echo "<pre>"; print_r(date("Y-m-1", strtotime(date('Y-m-d')))); echo "</pre>";
		echo "<pre>"; print_r(date("Y-m-t", strtotime(date('Y-m-d', strtotime('08/31/2016'))))); echo "</pre>";
		// how to fix 08/31/2016 error when adding one month
		// To Fix it by:
		// First convert it to Y-m-1
		// Second, after format it to Y-m-1 and then we can add one month to it by: date('Y-m-t', strtotime('+1 month', strtotime(Your Input Date)))
		//echo "<pre>"; print_r(date("Y-m-t", strtotime('+1 month', strtotime(date('Y-m-1', strtotime('08/31/2016')))))); echo "</pre>";
		echo "<pre>"; print_r($this->_addMonthToDateAndGetLastDayOfMonth($n, '08/31/2016')); echo "</pre>";
		
		$date = '08/31/1990';
		$newDate = date('m/d/Y', strtotime($date .' + 1 month')); // does not work well
		echo "<pre>"; print_r($newDate); echo "</pre>";
		
		$this->_divisionDemo(480);
		$this->_divisionDemo(288);
		$this->_divisionDemo(172.80);
		$this->_divisionDemo(103.68);
		
		$this->_divisionDemo(8317.80);
		$this->_divisionDemo(2000);
	}

	private function _addMonthToDateAndGetLastDayOfMonth($n, $date) {
		$firstDayOfMonth = date('Y-m-1', strtotime($date));
		$lastDateOfMonth = date('m/t/Y', strtotime("+{$n} month", strtotime($firstDayOfMonth))); //add $n month
		return $lastDateOfMonth;
	}
	
	private function _divisionDemo($n) {
		echo "<pre>"; print_r($n . ' => ' . ($n/12) . '], [' . ($n%12) . '], [' . round(($n/12), 2, PHP_ROUND_HALF_DOWN) . '], [' . round(($n/12), 2, PHP_ROUND_HALF_UP) . ']'); echo "</pre>";
		$this->_getDivisionArray($n);
	}
	
	private function _getDivisionArray($n) {
		$division = ($n / 12);
		$result = round($division, 2);
		if (($result * 12) == $n) {
			echo "<pre>"; print_r("Result: $result"); echo "</pre>";
		} else {
			$strArray = explode('.', $division);
			if (count($strArray) > 1) {
				echo "<pre>"; print_r($strArray); echo "</pre>";
				echo "<pre>"; print_r(('0.' .$strArray[1]) * 12); echo "</pre>";
			}
		}
	}
}