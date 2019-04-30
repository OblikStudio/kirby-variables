<?php

include_once 'src/Handler.php';
use Easyvars\Handler;

function tvar ($key, $flatten = false) {
	$data = Handler::read(kirby()->language()->code());
	$data = Handler::find($key, $data);

	if ($flatten) {
		$data = Handler::flatten($data);
	}

	return $data;
}

Kirby::plugin('oblik/easyvars', [
  'options' => [
    'loader' => __DIR__ . DS . 'loader.php',
    'folder' => 'variables',
    'extension' => 'yml'
  ]
]);
