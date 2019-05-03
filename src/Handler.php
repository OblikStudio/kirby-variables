<?php
namespace Easyvars;

use F;
use yaml;

class Handler {
	public static function path ($lang) {
		$dir = kirby()->root('languages');
		$folder = option('oblik.easyvars.folder');
		$extension = option('oblik.easyvars.extension');

		if (!empty($folder)) {
			$dir .= DS . $folder;
		}

		return $dir . DS . $lang . '.' . $extension;
	}

	public static function read ($lang) {
		$filepath = self::path($lang);
		$input = F::read($filepath);

		if ($input) {
			return yaml::decode($input);
		} else {
			return false;
		}
	}

	public static function write ($lang, $data) {
		$filepath = self::path($lang);
		$content = yaml::encode($data);

		return F::write($filepath, $content);
	}

	public static function modify ($lang, $data) {
		$currentData = self::read($lang);

		if ($currentData) {
			$data = array_replace_recursive($currentData, $data);
		}

		return self::write($lang, $data);
	}

	public static function replaceKey ($stringPath, $value, &$data) {
		$path = explode('.', $stringPath);
		$leaf = array_pop($path);

		foreach ($path as $key) {
			if (!empty($data[$key])) {
				$data = $data[$key];
			} else {
				return false;
			}
		}

		$data[$leaf] = $value;
	}

	public static function find ($stringPath, $data) {
		$value = $data;
		$path = explode('.', $stringPath);

		foreach ($path as $key) {
			if (isset($value[$key])) {
				$value = $value[$key];
			} else {
				return null;
			}
		}

		return $value;
	}

	public static function inflate ($array, $delimiter = '.') {
		$result = [];

		foreach ($array as $key => $value) {
			$path = explode($delimiter, $key);
			$leaf = array_pop($path);

			$current = &$result;
			foreach ($path as $part) {
				if (
					!isset($current[$part]) ||
					!is_array($current[$part])
				) {
					$current[$part] = [];
				}

				$current = &$current[$part];
			}

			$current[$leaf] = is_array($value)
				? self::inflate($value)
				: $value;
		}

		return $result;
	}

	public static function flatten ($array, $prefix = '', &$result = []) {
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				self::flatten($value, $prefix . $key . '.', $result);
			} else {
				$result[$prefix . $key] = $value;
			}
		}

		return $result;
	}
}
