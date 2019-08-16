<?php

namespace Oblik\Variables;

use PHPUnit\Framework\TestCase;

final class UtilTest extends TestCase
{
    public static $data = [
        'a' => [
            'a' => [
                'a' => 1
            ],
            'b' => 1,
            'c.a' => 1
        ],
        'b' => 1
    ];
    public static $deflated;
    public static $inflated;

    public function testDeflate()
    {
        self::$deflated = Util::deflate(self::$data);
        $this->assertEquals([
            'a.a.a' => 1,
            'a.b' => 1,
            'a.c.a' => 1,
            'b' => 1
        ], self::$deflated);
    }

    public function testInflate()
    {
        self::$inflated = Util::inflate(self::$deflated);
        $this->assertEquals([
            'a' => [
                'a' => [
                    'a' => 1
                ],
                'b' => 1,
                'c' => [
                    'a' => 1
                ]
            ],
            'b' => 1
        ], self::$inflated);
    }

    public function testReplace()
    {
        $arr = self::$inflated;

        Util::replace(['a', 'a', 'a'], 'new', $arr);
        Util::replace('b', 'new', $arr);
        $this->assertEquals('new', $arr['a']['a']['a']);
        $this->assertEquals('new', $arr['b']);

        Util::replace('a.a', 'new', $arr, true);
        Util::replace('a.foo.bar', 'new', $arr, true);
        $this->assertEquals('new', $arr['a']['a']);
        $this->assertEquals('new', $arr['a']['foo']['bar']);
    }
}