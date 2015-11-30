<?php

class ArrayParser {
	
	public function display() {
		$dataArray = $this->_getData();
		$firstData = $this->_groupStyleOne($dataArray);
		$secondData = $this->_groupStyleTwo($dataArray);
		
		echo "<pre>"; print_r($dataArray); echo "</pre>";
		echo "<pre>"; print_r($firstData); echo "</pre>";
		echo "<pre>"; print_r($secondData); echo "</pre>";
	}
	
	private function _groupStyleTwo($dataArray) {
		$group = array();
		foreach ($dataArray as $data) {
			$group[$data['id']][] = $data;
		}
		$data = array();
		foreach ($group as $arr) {
			$data[] = $arr;
		}
		return $data;
	}
	
	private function _groupStyleOne($dataArray) {
		$result = array();
		foreach ($dataArray as $data) {
			$id = $data['id'];
			if (isset($result[$id])) {
				$result[$id][] = $data;
			} else {
				$result[$id] = array($data);
			}
		}
		$data = array();
		foreach ($result as $arr) {
			$data[] = $arr;
		}
		return $data;
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
