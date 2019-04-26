<?php

preg_match('/languages(?:\\/|\\\)(.*)\\.php/', $file, $matches);

if (count($matches) === 2) {
	$content = Easyvars\Handler::read($matches[1]);

	if (!empty($content)) {
		return Easyvars\Handler::flatten($content);
	}
}

return [];
