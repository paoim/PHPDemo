<?php

class ArrayDemo {
	
	function __construct() {
		
	}
	
	public function display() {
		$this->_foreachKeyFirst();
		$this->_foreachKeySecond();
		$this->_foreachKeySolution();
		$this->_arrayToObject();
		
		$math1 = "+300";
		$math2 = "-125";
		$result = abs($math1) - abs($math2);
		echo "<pre>"; print_r(abs($math1)); echo "</pre>";
		echo "<pre>"; print_r(abs($math2)); echo "</pre>";
		echo "<pre>"; print_r("result: $result"); echo "</pre>";
		
		echo "<pre>"; print_r("======================================================================"); echo "</pre>";
		$arrayFirst = array(
				'ID'		=> 1,
				'Name'		=> 'First Array'
		);
		$arraySecond = array(
				'ID'		=> 1,
				'Name'		=> 'Second Array'
		);
		array_walk($arrayFirst, function ($item1, $key, &$arraySecond) {
			echo "<pre>"; print_r("First Walk"); echo "</pre>";
			array_walk($arraySecond, function ($item2, $key){
				echo "<pre>"; print_r("Second Walk"); echo "</pre>";
			});
		}, $arraySecond);
	}
	
	private function _foreachKeyFirst() {
		$dataArray = array(
				array(
						'order_total_id'	=> 214950,
						'order_id'			=> 4779,
						'code'				=> 'd_payment_fee',
						'title'				=> 'COD',
						'text'				=> '1,00€',
						'value'				=> 1.0000,
						'sort_order'		=> 2
				),
				array(
						'order_total_id'	=> 214951,
						'order_id'			=> 4779,
						'code'				=> 'shipping',
						'title'				=> 'Free',
						'text'				=> '0,00€',
						'value'				=> 0.0000,
						'sort_order'		=> 3
				)
		);
		
		foreach ($dataArray as $arrays) {
			if ($arrays['code'] == 'd_payment_fee') {
				echo "<pre>"; print_r('d_payment_fee'); echo "</pre>";
				$dpaymentfeetext = ' - ' .$arrays['title'];
				$dpaymentfeevalue = $arrays['value']/1.20;
			}
		
			if ($arrays['code'] == 'shipping') {
				echo "<pre>"; print_r('shipping'); echo "</pre>";
				$test = array(
						'name'			=> $arrays['title'] .$dpaymentfeetext,
						'quantity'		=> 1,
						'unit'			=> 'ks',
						'unit_price'	=> ($arrays['value'] + $dpaymentfeevalue)*1.20
				);
				echo "<pre>"; print_r($test); echo "</pre>";
			}
		}
		echo "<pre>"; print_r('======================================================='); echo "</pre>";
	}
	
	private function _foreachKeySecond() {
		$total_data = array(
				array(
						'order_total_id'	=> 216352,
						'order_id'			=> 4796,
						'code'				=> 'shipping',
						'title'				=> 'Free shipping',
						'text'				=> '2,50€',
						'value'				=> 2.5000,
						'sort_order'		=> 2
				),
				array(
						'order_total_id'	=> 216353,
						'order_id'			=> 4796,
						'code'				=> 'd_payment_fee',
						'title'				=> 'COD',
						'text'				=> '1,00€',
						'value'				=> 1.0000,
						'sort_order'		=> 3
				)
		);
		
		
		$index = 0;
		$dpaymentfeetextArray = array();
		$dpaymentfeevalueArray = array();
		foreach ($total_data as $arrays) {
			if ($arrays['code'] == 'd_payment_fee') {
				echo "<pre>"; print_r('d_payment_fee'); echo "</pre>";
				$dpaymentfeetextArray[$index] = ' - ' .$arrays['title'];
				$dpaymentfeevalueArray[$index] = $arrays['value']/1.20;
				$index++;
			}
		}
		$index = 0;
		foreach ($total_data as $arrays) {
			if ($arrays['code'] == 'shipping') {
				echo "<pre>"; print_r('shipping'); echo "</pre>";
				$test = array(
						'name'			=> $arrays['title'] .(isset($dpaymentfeetextArray[$index]) ? $dpaymentfeetextArray[$index] : ' '),
						'quantity'		=> 1,
						'unit'			=> 'ks',
						'unit_price'	=> ($arrays['value'] + (isset($dpaymentfeevalueArray[$index]) ? $dpaymentfeevalueArray[$index] : 0))*1.20
				);
				$index++;
				echo "<pre>"; print_r($test); echo "</pre>";
			}
		}
		echo "<pre>"; print_r('======================================================='); echo "</pre>";
	}
	
	private function _foreachKeySolution() {
		$total_data = array(
				array(
						'order_total_id'	=> 216352,
						'order_id'			=> 4796,
						'code'				=> 'shipping',
						'title'				=> 'Free shipping',
						'text'				=> '2,50€',
						'value'				=> 2.5000,
						'sort_order'		=> 2
				),
				array(
						'order_total_id'	=> 216353,
						'order_id'			=> 4796,
						'code'				=> 'd_payment_fee',
						'title'				=> 'COD',
						'text'				=> '1,00€',
						'value'				=> 1.0000,
						'sort_order'		=> 3
				)
		);
		
		
		$fees_found = false;
		$shipping_found = false;
		foreach ($total_data as $arrays) {
			if ($arrays['code'] == 'd_payment_fee') {
				echo "<pre>"; print_r('d_payment_fee'); echo "</pre>";
				$dpaymentfeetext = ' - ' .$arrays['title'];
				$dpaymentfeevalue = $arrays['value']/1.20;
				$fees_found = true;
			} else if ($arrays['code'] == 'shipping') {
				echo "<pre>"; print_r('shipping'); echo "</pre>";
				$title = $arrays['title'];
				$value = $arrays['value'];
				$shipping_found = true;
			}
			if ($fees_found && $shipping_found) {
				break;
			}
		}
		$test = array(
				'name'			=> $title .$dpaymentfeetext,
				'quantity'		=> 1,
				'unit'			=> 'ks',
				'unit_price'	=> ($value + $dpaymentfeevalue)*1.20
		);
		echo "<pre>"; print_r($test); echo "</pre>";
		echo "<pre>"; print_r('======================================================='); echo "</pre>";
	}
	
	private function _arrayToObject() {
		$total_data = array(
				array(
						'order_total_id'	=> 216352,
						'order_id'			=> 4796,
						'code'				=> 'shipping',
						'title'				=> 'Free shipping',
						'text'				=> '2,50€',
						'value'				=> 2.5000,
						'sort_order'		=> 2
				),
				array(
						'order_total_id'	=> 216353,
						'order_id'			=> 4796,
						'code'				=> 'd_payment_fee',
						'title'				=> 'COD',
						'text'				=> '1,00€',
						'value'				=> 1.0000,
						'sort_order'		=> 3
				)
		);
		
		
		$fees_found = false;
		$shipping_found = false;
		foreach ($total_data as $arrays) {
			if ($arrays['code'] == 'd_payment_fee') {
				echo "<pre>"; print_r('d_payment_fee'); echo "</pre>";
				$dpaymentfeetext = ' - ' .$arrays['title'];
				$dpaymentfeevalue = $arrays['value']/1.20;
				$fees_found = true;
			} else if ($arrays['code'] == 'shipping') {
				echo "<pre>"; print_r('shipping'); echo "</pre>";
				$title = $arrays['title'];
				$value = $arrays['value'];
				$shipping_found = true;
			}
			if ($fees_found && $shipping_found) {
				break;
			}
		}
		$associateArray = array(
				'name'			=> $title .$dpaymentfeetext,
				'quantity'		=> 1,
				'unit'			=> 'ks',
				'unit_price'	=> ($value + $dpaymentfeevalue)*1.20
		);
		//Convert Associated Array to Json Object
		$JsonObject = json_encode($associateArray);
		// Convert Json Object to Json PHP (Object in PHP)
		$JsonPhpObject = json_decode($JsonObject);
		
		// Short Convert
		$TestObject = (object) $associateArray;
		
		echo "<pre>"; print_r($associateArray); echo "</pre>";
		echo "<pre>"; print_r($JsonObject); echo "</pre>";
		echo "<pre>"; print_r($JsonPhpObject); echo "</pre>";
		echo "<pre>"; print_r($TestObject); echo "</pre>";
		echo "<pre>"; print_r('======================================================='); echo "</pre>";
	}
}
