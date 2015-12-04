<?php

require_once 'InterfaceDisplay.php';
require_once '../util/arrayparser/ArrayParser.php';


class GroupArray implements InterfaceDisplay {
	
	public function display() {
		echo "<pre>"; print_r("======================Group Array Demo==================="); echo "</pre>";
		$parser = ArrayParser::instance();
		
		$dataArray = $this->_getData();
		$firstData = $parser->groupArrayByIdFirstStyle($dataArray);
		$secondData = $parser->groupArrayByIdSecondStyle($dataArray);
		
		echo "<pre>"; print_r($dataArray); echo "</pre>";
		echo "<pre>"; print_r($firstData); echo "</pre>";
		echo "<pre>"; print_r($secondData); echo "</pre>";
	}
	
	private function _getData() {
		$dataArray = array(
				array(
						'id'			=> 1,
						'name'		=> 'Dara'
				),
				array(
						'id'			=> 2,
						'name'		=> 'Hello'
				),
				array(
						'id'			=> 1,
						'name'		=> 'Sam'
				)
		);
		return $dataArray;
	}
}
