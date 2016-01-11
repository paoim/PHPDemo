<?php


class PrintUtil
{
	public static function display($value = null)
	{
		echo "<pre>"; print_r($value); echo "</pre>";
	}
	
	public static function close($value = null)
	{
		//PrintUtil::display($value);
		die($value);
	}
}
