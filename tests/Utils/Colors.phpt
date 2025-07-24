<?php

/**
 * Test: Aprila\Utils\Colors
 */

use Aprila\Utils\Colors;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

// From array
Assert::same('#FF0000', Colors::rgbToHex(['255', '00', '00']));

Assert::same('FF0000', Colors::rgbToHex(['255', '00', '00'], FALSE));

Assert::same('#FF0000', Colors::rgbToHex(['255', '0', '0']));

// From named array
Assert::same('#FF0000', Colors::rgbToHex(['r' => '255', 'g' => '0', 'b' => '0']));


Assert::exception(function () {
    Colors::rgbToHex(['255', '0']);
}, 'InvalidArgumentException');

// From string

Assert::same('#FF0000', Colors::rgbToHex('rgb(255, 0, 0)'));
Assert::same('#FFFF00', Colors::rgbToHex('255, 255, 0'));

Assert::exception(function () {
    Colors::rgbToHex('255, 0');
}, 'InvalidArgumentException');


// Edge cases and error conditions

// RGB value validation - out of range values
Assert::exception(function () {
    Colors::rgbToHex(['256', '0', '0']); // > 255
}, 'InvalidArgumentException', 'RGB value 256 is out of range (0-255)');

Assert::exception(function () {
    Colors::rgbToHex(['-1', '0', '0']); // < 0
}, 'InvalidArgumentException', 'RGB value -1 is out of range (0-255)');

Assert::exception(function () {
    Colors::rgbToHex(['0', '300', '0']); // G > 255
}, 'InvalidArgumentException');

Assert::exception(function () {
    Colors::rgbToHex(['0', '0', '-5']); // B < 0
}, 'InvalidArgumentException');

// Test boundary values
Assert::same('#000000', Colors::rgbToHex(['0', '0', '0'])); // minimum values
Assert::same('#FFFFFF', Colors::rgbToHex(['255', '255', '255'])); // maximum values

// String format edge cases
Assert::same('#FF0000', Colors::rgbToHex('rgb( 255 , 0 , 0 )')); // extra spaces
Assert::same('#00FF00', Colors::rgbToHex('0,255,0')); // no spaces
Assert::same('#0000FF', Colors::rgbToHex('rgb(0,0,255)')); // no spaces in rgb()

// Invalid string formats
Assert::exception(function () {
    Colors::rgbToHex('rgba(255, 0, 0, 1)'); // rgba not supported
}, 'InvalidArgumentException');

Assert::exception(function () {
    Colors::rgbToHex('255 255 0'); // space separated, not comma
}, 'InvalidArgumentException');

Assert::exception(function () {
    Colors::rgbToHex('rgb(255, 0)'); // missing third value
}, 'InvalidArgumentException');

Assert::exception(function () {
    Colors::rgbToHex('rgb(255, 0, 0, 0)'); // too many values
}, 'InvalidArgumentException');

Assert::exception(function () {
    Colors::rgbToHex('rgb(abc, 0, 0)'); // non-numeric values
}, 'InvalidArgumentException');

Assert::exception(function () {
    Colors::rgbToHex('255,'); // incomplete
}, 'InvalidArgumentException');

Assert::exception(function () {
    Colors::rgbToHex(''); // empty string
}, 'InvalidArgumentException');

// Out of range values in strings
Assert::exception(function () {
    Colors::rgbToHex('rgb(256, 0, 0)');
}, 'InvalidArgumentException');

Assert::exception(function () {
    Colors::rgbToHex('-1, 100, 200');
}, 'InvalidArgumentException');

// Array format edge cases
Assert::exception(function () {
    Colors::rgbToHex([]); // empty array
}, 'InvalidArgumentException');

Assert::exception(function () {
    Colors::rgbToHex(['r' => '255']); // incomplete named array
}, 'InvalidArgumentException');

Assert::exception(function () {
    Colors::rgbToHex(['r' => '255', 'g' => '0']); // missing 'b'
}, 'InvalidArgumentException');

// Mixed valid/invalid named array
Assert::exception(function () {
    Colors::rgbToHex(['r' => '300', 'g' => '0', 'b' => '0']); // out of range in named array
}, 'InvalidArgumentException');

// Integer values (should work)
Assert::same('#FF0000', Colors::rgbToHex([255, 0, 0])); // integers
Assert::same('#808080', Colors::rgbToHex(['r' => 128, 'g' => 128, 'b' => 128])); // named with integers

// Test withHash parameter with edge cases
Assert::same('000000', Colors::rgbToHex([0, 0, 0], false)); // no hash, minimum
Assert::same('FFFFFF', Colors::rgbToHex([255, 255, 255], false)); // no hash, maximum

// Invalid parameter types - integer gets converted to string but fails regex validation
Assert::exception(function () {
    Colors::rgbToHex(123); // integer becomes "123" string, fails regex
}, 'InvalidArgumentException');

Assert::exception(function () {
    Colors::rgbToHex(null); // null
}, 'TypeError');
