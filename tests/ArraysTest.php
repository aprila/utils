<?php

declare(strict_types=1);

namespace Aprila\Tests;

use Aprila\Utils\Arrays;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../vendor/autoload.php';

class ArraysTest extends TestCase
{
    public function testGetNextKey()
    {
        $arr = ['a' => 1, 'b' => 2, 'c' => 3];

        Assert::same('b', Arrays::getNextKey($arr, 'a'));
        Assert::same('c', Arrays::getNextKey($arr, 'b'));
        Assert::same('a', Arrays::getNextKey($arr, 'c')); // Wrap around
        Assert::same('a', Arrays::getNextKey($arr, 'non-existent')); // Not found -> first
    }

    public function testGetPreviousKey()
    {
        $arr = ['a' => 1, 'b' => 2, 'c' => 3];

        Assert::same('c', Arrays::getPreviousKey($arr, 'a')); // Wrap around
        Assert::same('a', Arrays::getPreviousKey($arr, 'b'));
        Assert::same('b', Arrays::getPreviousKey($arr, 'c'));
        Assert::same('c', Arrays::getPreviousKey($arr, 'non-existent')); // Not found -> last
    }

    public function testGetNextValue()
    {
        $arr = ['a' => 1, 'b' => 2, 'c' => 3];

        Assert::same(2, Arrays::getNextValue($arr, 1));
        Assert::same(3, Arrays::getNextValue($arr, 2));
        Assert::same(1, Arrays::getNextValue($arr, 3)); // Wrap around
        Assert::same(1, Arrays::getNextValue($arr, 999)); // Not found -> first
    }

    public function testGetPreviousValue()
    {
        $arr = ['a' => 1, 'b' => 2, 'c' => 3];

        Assert::same(3, Arrays::getPreviousValue($arr, 1)); // Wrap around
        Assert::same(1, Arrays::getPreviousValue($arr, 2));
        Assert::same(2, Arrays::getPreviousValue($arr, 3));
        Assert::same(3, Arrays::getPreviousValue($arr, 999)); // Not found -> last
    }

    public function testEmptyArray()
    {
        $arr = [];
        Assert::null(Arrays::getNextKey($arr, 'a'));
        Assert::null(Arrays::getPreviousKey($arr, 'a'));
        Assert::null(Arrays::getNextValue($arr, 1));
        Assert::null(Arrays::getPreviousValue($arr, 1));
    }

    public function testNumericKeys()
    {
        $arr = [10 => 'val1', 20 => 'val2'];
        Assert::same(20, Arrays::getNextKey($arr, 10));
        Assert::same(10, Arrays::getNextKey($arr, 20));
        Assert::same(10, Arrays::getNextKey($arr, 999));

        // Loose comparison check
        // "10" matches 10
        Assert::same(20, Arrays::getNextKey($arr, "10"));
    }
}

(new ArraysTest())->run();
