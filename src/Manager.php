<?php

namespace Oblik\Variables;

class Manager
{
    private static $handlers = [];

    private static function createHandler($lang)
    {
        return self::$handlers[$lang] = new Handler($lang);
    }

    /**
     * @return Handler|null
     */
    public static function getHandler($lang)
    {
        return self::$handlers[$lang] ?? null;
    }

    public static function loadTranslations()
    {
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
}
