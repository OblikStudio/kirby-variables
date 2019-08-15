<?php

namespace Oblik\Variables;

class Util
{
    private static function deflateRecursive(array $data, $separator, $prefix = '', &$result = [])
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $childPrefix = $prefix . $key . $separator;
                self::deflateRecursive($value, $separator, $childPrefix, $result);
            } else {
                $result[$prefix . $key] = $value;
            }
        }

        return $result;
    }

    public static function path($input, $separator = DELIMITER_KEY) {
        if (is_string($input)) {
            $input = explode($separator, $input);
        }

        if (!is_array($input)) {
            $input = [];
        }

        return $input;
    }

    public static function inflate(array $data, $delimiter = DELIMITER_KEY)
    {
        $result = [];

        foreach ($data as $key => $value) {
            $path = explode($delimiter, $key);
            $leaf = array_pop($path);
            $current = &$result;

            foreach ($path as $part) {
                if (!isset($current[$part]) || !is_array($current[$part])) {
                    $current[$part] = [];
                }

                $current = &$current[$part];
            }

            $current[$leaf] = is_array($value) ? self::inflate($value, $delimiter) : $value;
        }

        return $result;
    }

    public static function deflate(array $data, $delimiter = DELIMITER_KEY)
    {
        return self::deflateRecursive($data, $delimiter);
    }

    public static function find($path, $value)
    {
        foreach (self::path($path) as $key) {
            if (isset($value[$key])) {
                $value = $value[$key];
            } else {
                return null;
            }
        }

        return $value;
    }

    public static function replace($path, $value, &$data, $force = false)
    {
        $path = self::path($path);
        $leaf = array_pop($path);

        foreach ($path as $key) {
            if (isset($data[$key]) && is_array($data[$key])) {
                $data = &$data[$key];
            } else {
                if ($force) {
                    $data[$key] = [];
                    $data = &$data[$key];
                } else {
                    return false;
                }
            }
        }

        $data[$leaf] = $value;
    }
}
