<?php

use Oblik\Variables\Manager;

function p($key, array $data)
{
    return Manager::getPlural($key, $data);
}
