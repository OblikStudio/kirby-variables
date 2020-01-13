<?php

namespace Oblik\Variables;

use Kirby\Toolkit\F;
use Kirby\Data\Yaml;

class Handler
{
    public $file;
    public $data;

    public function __construct(string $lang)
    {
        $folder = kirby()->option('oblik.variables.folder');
        $this->file = "$folder/$lang.yml";
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

    public function replace($path, $value, $force = true) {
        Util::replace($path, $value, $this->data, $force);
        return $this;
    }

    public function write()
    {
        if (!empty($this->data)) {
            return F::write($this->file, Yaml::encode($this->data));
        } else {
            return F::remove($this->file);
        }
    }

    public function find($path)
    {
        return Util::find($path, $this->data);
    }
}
