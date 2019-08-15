<?php

use Kirby\Toolkit\F;

return [
    'always' => true,
    'beforeInit' => function () {
        chdir(__DIR__);
        F::remove('roots/languages/en.yml');
    }
];
