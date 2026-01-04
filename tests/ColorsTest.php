<?php

declare(strict_types=1);

namespace Aprila\Tests;

use Aprila\Utils\Colors;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../vendor/autoload.php';

class ColorsTest extends TestCase
{
    public function testRgbToHex()
    {
        Assert::same('#FFFFFF', Colors::rgbToHex([255, 255, 255]));
        Assert::same('#000000', Colors::rgbToHex([0, 0, 0]));
        Assert::same('#FF0000', Colors::rgbToHex([255, 0, 0]));

        Assert::same('FFFFFF', Colors::rgbToHex([255, 255, 255], false));

        Assert::same('#FFFFFF', Colors::rgbToHex(['r' => 255, 'g' => 255, 'b' => 255]));

        Assert::same('#FFFFFF', Colors::rgbToHex('255, 255, 255'));
        Assert::same('#FFFFFF', Colors::rgbToHex('rgb(255, 255, 255)'));
    }

    public function testHexToRgb()
    {
        Assert::same(['r' => 255, 'g' => 255, 'b' => 255], Colors::hexToRgb('#FFFFFF'));
        Assert::same(['r' => 255, 'g' => 255, 'b' => 255], Colors::hexToRgb('FFFFFF'));
        Assert::same(['r' => 0, 'g' => 0, 'b' => 0], Colors::hexToRgb('#000'));
        Assert::same(['r' => 255, 'g' => 0, 'b' => 0], Colors::hexToRgb('#F00'));
    }

    public function testExceptions()
    {
        Assert::exception(function() {
            Colors::rgbToHex([300, 0, 0]);
        }, \InvalidArgumentException::class);

        Assert::exception(function() {
            Colors::hexToRgb('ZZZZZZ');
        }, \InvalidArgumentException::class);
    }
}

(new ColorsTest())->run();
