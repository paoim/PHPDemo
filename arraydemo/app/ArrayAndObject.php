<?php

require_once 'InterfaceDisplay.php';
require_once '../util/arrayparser/ArrayParser.php';


class ArrayAndObject implements InterfaceDisplay
{
	
	public function display()
	{
		echo "<pre>"; print_r("======================Array and Object Demo==================="); echo "</pre>";
		$parser = ArrayParser::instance();
		
		$associateArray = $this->_getData();
		$firstData = $parser->convertAssociateArrayToObjectFirst($associateArray);
		$secondData = $parser->convertAssociateArrayToObjectSecond($associateArray);
		
		echo "<pre>"; print_r($associateArray); echo "</pre>";
		echo "<pre>"; print_r($firstData); echo "</pre>";
		echo "<pre>"; print_r($secondData); echo "</pre>";
	}
	
	private function _getData()
	{
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
		return $associateArray;
	}
}
