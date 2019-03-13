<?php

include_once 'src/Transformer.php';

Kirby::plugin('oblik/easyvars', [
  'options' => [
    'loader' => __DIR__ . DS . 'loader.php',
    'folder' => 'variables'
  ]
]);
