<?php

namespace Oblik\Variables;

use Kirby\Toolkit\F;
use Kirby\Data\Yaml;

class Handler
{
    const EXT = '.yml';

    public $file;
    public $data;

	public static function load($lang)
	{
        return (new static($lang))->read()->flatten()->data;
    }
    
    public function __construct(string $lang)
    {
        $this->file = kirby()->root('languages') . "/$lang" . self::EXT;
    }

    /**
     * Loads all variables of a language.
     */
	public function read()
	{
		if ($contents = F::read($this->file)) {
            $this->data = Yaml::decode($contents);
		} else {
			$this->data = null;
        }
        
        return $this;
	}

	public static function write()
	{
        return F::write($this->file, Yaml::encode($this->data));
	}

	public static function replaceKey($stringPath, $value, &$data, $createKeys = false)
	{
		$path = explode('.', $stringPath);
		$leaf = array_pop($path);

		foreach ($path as $key) {
			if (!empty($data[$key])) {
				$data = &$data[$key];
			} else {
				if ($createKeys) {
					$data[$key] = [];
					$data = &$data[$key];
				} else {
					return false;
				}
			}
		}

		$data[$leaf] = $value;
	}

	public static function find($stringPath, $data)
	{
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

	public static function inflate($array, $delimiter = '.')
	{
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

	public function flatten()
	{
		if (is_array($this->data)) {
			$this->data = Util::flatten($this->data);
		}
		
		return $this;
	}
}
