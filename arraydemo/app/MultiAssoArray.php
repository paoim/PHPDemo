<?php


class MultiAssoArray
{
	public function display()
	{
		echo "<pre>"; print_r("======================Multi Associate Array Demo==================="); echo "</pre>";
		$index = 0;
		$multiAssociateArray = array();
		for ($x = 0; $x < 20; $x++) {
			$multiAssociateArray['Key_1_' .$index]['Key_2_' .$index]['Key_3_' .$index][] = $x;
			if ($x % 5 == 0) {
				$index++;
			}
		}
		$testArray = array();
		foreach ($multiAssociateArray as $k_1 => $v_1) {
			foreach ($v_1 as $k_2 => $v_2) {
				foreach ($v_2 as $k_3 => $v_3) {
					$testArray[$k_1][$k_2][$k_3] = array_sum($v_3);
				}
			}
		}
		echo "<pre>"; print_r($testArray); echo "</pre>";
	}
}
