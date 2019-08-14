<?php

namespace Oblik\Variables;

use Kirby;

const DELIMITER_KEY = '.';
const DELIMITER_PLURAL = '=';

load([
	'Oblik\\Variables\\Handler' => 'src/Handler.php',
	'Oblik\\Variables\\Manager' => 'src/Manager.php',
	'Oblik\\Variables\\Util' => 'src/Util.php'
], __DIR__);

Kirby::plugin('oblik/variables', [
	'translations' => Manager::loadTranslations()
]);

require_once 'global.php';