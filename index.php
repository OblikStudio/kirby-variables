<?php

include_once 'src/Handler.php';

Kirby::plugin('oblik/easyvars', [
  'options' => [
    'loader' => __DIR__ . DS . 'loader.php',
    'folder' => 'variables',
    'extension' => 'yml'
  ]
]);
