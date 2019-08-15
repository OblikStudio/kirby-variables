<?php

namespace Oblik\Variables;

use Kirby\Toolkit\F;
use Kirby\Data\Yaml;

class Handler
{
    const EXTENSION = '.yml';

    public $file;
    public $data;

    public function __construct(string $lang)
    {
        $this->file = kirby()->root('languages') . "/$lang" . self::EXTENSION;
    }

    public function read()
    {
        if ($contents = F::read($this->file)) {
            $this->data = Yaml::decode($contents);
        } else {
            $this->data = null;
        }

        return $this;
    }

    public function write()
    {
        return F::write($this->file, Yaml::encode($this->data));
    }

    public function find($path)
    {
        return Util::find($path, $this->data);
    }

    public function replace($path, $value, $force = true) {
        Util::replace($path, $value, $this->data, $force);
        return $this;
    }
}
