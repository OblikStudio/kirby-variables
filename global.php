<?php

use Oblik\Variables\Manager;

function p($key)
{
    $args = func_get_args();
    array_shift($args);
    return Manager::getPlural($key, $args);
}
