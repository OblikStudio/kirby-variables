<?php

use Kirby\Toolkit\F;

return [
    'beforeInit' => function () {
        F::remove(__DIR__ . '/roots/languages/bg.yml');
        F::remove(__DIR__ . '/roots/languages/en.yml');
        F::copy(__DIR__ . '/fixtures/en.yml', __DIR__ . '/roots/languages/en.yml', true);
    }
];
