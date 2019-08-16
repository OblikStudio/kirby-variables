<?php

namespace Oblik\Variables;

use Kirby\Toolkit\Str;
use const Oblik\Pluralization\LANGUAGES;

class Manager
{
    private static $handlers = [];

    private static function createHandler($lang)
    {
        return self::$handlers[$lang] = new Handler($lang);
    }

    public static function loadTranslations() {
        $translations = [];

        foreach (kirby()->languages() as $language) {
            $lang = $language->code();
            $handler = self::createHandler($lang)->read();
            $userTranslations = $language->translations();

            if (!empty($userTranslations)) {
                $userTranslations = Util::inflate($userTranslations);
                $loadedTranslations = $handler->data ?? [];

                // Kirby merges user translations on top of plugin translations,
                // so we need to do the same here.
                $handler->data = array_replace_recursive($loadedTranslations, $userTranslations);
                $handler->write();
            }

            if (is_array($handler->data)) {
                $translations[$lang] = Util::deflate($handler->data);
            }
        }

        return $translations;
    }

    public static function getPlural($path, array $data, $lang = null)
    {
        if (!is_string($lang)) {
            $lang = kirby()->language()->code();
        }

        $handler = self::$handlers[$lang] ?? null;
        $pluralizer = LANGUAGES[$lang] ?? null;

        if ($handler && $pluralizer) {
            if (is_string($path)) {
                $path = explode(DELIMITER_KEY, $path);
            }

            if (is_array($path)) {
                $plural = explode(DELIMITER_PLURAL, end($path));
                $type = $plural[1] ?? null;
                $method = null;

                switch ($type) {
                    case 'c':
                        $method = 'getCardinal';
                        $args = [$data['count']];
                        break;
                    case 'o':
                        $method = 'getOrdinal';
                        $args = [$data['position']];
                        break;
                    case 'r':
                        $method = 'getRange';
                        $args = [$data['start'], $data['end']];
                        break;
                }

                if ($method) {
                    $translations = $handler->find($path);

                    if (is_array($translations)) {
                        $form = call_user_func_array("$pluralizer::$method", $args);
                        $name = $pluralizer::formName($form);
                        $translation = $translations[$name] ?? null;

                        if ($translation) {
                            return Str::template($translation, $data);
                        }
                    }
                }
            }
        }

        return null;
    }

    public static function getHandler($lang)
    {
        return self::$handlers[$lang] ?? null;
    }
}
