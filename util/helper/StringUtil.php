<?php

namespace util\helper
{
	class StringUtil
	{
		private static $_instance = null;
		
		public static function instance()
		{
			if (! self::$_instance)
				self::$_instance = new StringUtil();
			return self::$_instance;
		}
		
		public function escape($value = null)
		{
			if (!$value) {
				return null;
			}
			return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
		}
		
		public function applyAllEscape($data = null) {
			if (!$value) {
				return null;
			}
			if (is_array($data)) {
				// will escape
				return $data;
			} else {
				if (is_object($data)) {
					// Convert to Array
				}
			}
		}
	}
}
