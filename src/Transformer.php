<?php
namespace Easyvars;

use F;
use yaml;

class Transformer {
  private $lang = null;
  private $file = null;

  function __construct ($langFile) {
    preg_match('/languages(?:\\/|\\\)(.*)\\.php/', $langFile, $matches);

    if (count($matches) === 2) {
      $this->lang = $matches[1];

      $filePath = kirby()->root('languages');
      $folder = option('oblik.easyvars.folder');

      if (!empty($folder)) {
        $filePath .= DS . $folder;
      }

      $this->file = $filePath . DS . $this->lang . '.yml';
    }
  }

  private function flattenData ($data, &$result = [], $prefix = '') {
    foreach ($data as $key => $value) {
      if (is_array($value)) {
        $this->flattenData($value, $result, $prefix . $key . '.');
      } else {
        $result[$prefix . $key] = $value;
      }
    }

    return $result;
  }

  public function read () {
    if (file_exists($this->file)) {
      $content = F::read($this->file);
      $data = yaml::decode($content);
      return $this->flattenData($data);
    } else {
      return [];
    }
  }
}
