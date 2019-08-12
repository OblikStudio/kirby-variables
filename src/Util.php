<?php

namespace Oblik\Variables;

class Util
{
	public static function flatten(array $data, $prefix = '', &$result = [])
	{
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				self::flatten($value, $prefix . $key . '.', $result);
			} else {
				$result[$prefix . $key] = $value;
			}
		}

		return $result;
	}
}
