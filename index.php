<?php

namespace Oblik\Variables;

use Kirby;

load([
	'Oblik\\Variables\\Handler' => 'src/Handler.php',
	'Oblik\\Variables\\Util' => 'src/Util.php'
], __DIR__);

function tvar($key, $flatten = false)
{
	$data = Handler::read(kirby()->language()->code());
	$data = Handler::find($key, $data);

	if ($flatten) {
		$data = Handler::flatten($data);
	}

	return $data;
}

Kirby::plugin('oblik/variables', [

]);
