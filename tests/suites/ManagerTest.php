<?php

namespace Oblik\Variables;

use PHPUnit\Framework\TestCase;
use Kirby\Data\Yaml;
use Kirby\Toolkit\I18n;

final class ManagerTest extends TestCase
{
    private static $initialFile = __DIR__ . '/../roots/languages/bg.yml';
    private static $initialFileData;

    public function testFileCreation()
    {
        $this->assertFileExists(self::$initialFile);
        self::$initialFileData = Yaml::decode(file_get_contents(self::$initialFile));
        
    }

    public function testInitialData()
    {
        $this->assertEquals('initial', self::$initialFileData['deflated']['value']);
        $this->assertEquals('initial', self::$initialFileData['inflated']['value']);
    }

    public function testInitialTranslations()
    {
        $this->assertEquals('initial', I18n::translate('deflated.value', null, 'bg'));
        $this->assertEquals('initial', I18n::translate('inflated.value', null, 'bg'));
    }

    /**
     * Tests whether the default translations in the PHP file are merged with
     * the ones in the YAML file.
     */
    public function testDataMerged()
    {
        $this->assertEquals('yes', I18n::translate('merged.yaml'));
        $this->assertEquals('yes', I18n::translate('merged.php'));
    }

    public function testPlurals()
    {
        $oneApple = Manager::getPlural('plurals.apples=c', [
            'count' => 1
        ]);

        $moreApples = Manager::getPlural('plurals.apples=c', [
            'count' => 2.4
        ]);

        $first = Manager::getPlural('plurals.place=o', [
            'position' => 1
        ]);

        $third = Manager::getPlural('plurals.place=o', [
            'position' => 3
        ]);

        $cookies = Manager::getPlural('plurals.cookies=r', [
            'start' => 3,
            'end' => 5
        ]);

        $this->assertEquals('1 apple', $oneApple);
        $this->assertEquals('2.4 apples', $moreApples);
        $this->assertEquals('1st', $first);
        $this->assertEquals('3rd', $third);
        $this->assertEquals('3-5 cookies', $cookies);
    }
}