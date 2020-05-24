<?php

/**
 * Test: Aprila\Utils\Arrays
 */

use Aprila\Utils\Arrays;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


$testArray = [
	2 => 'strawberry',
	3 => 'watermelon',
	4 => 'banana',
	10 => 'carrot',
	'x' => 'leek',
	'y' => 'raspberry'
];

Assert::count(6, $testArray);

// previous key
Assert::same('x', Arrays::getPreviousKey($testArray, 'y'));
Assert::same(3, Arrays::getPreviousKey($testArray, 4));
Assert::same('y', Arrays::getPreviousKey($testArray, 2));

// next key
Assert::same('y', Arrays::getNextKey($testArray, 'x'));
Assert::same(10, Arrays::getNextKey($testArray, 4));
Assert::same(2, Arrays::getNextKey($testArray, 'y'));

// previous value
Assert::same('strawberry', Arrays::getPreviousValue($testArray, 'watermelon'));
Assert::same('carrot', Arrays::getPreviousValue($testArray, 'leek'));
Assert::same('raspberry', Arrays::getPreviousValue($testArray, 'strawberry'));

// next value
Assert::same('carrot', Arrays::getNextValue($testArray, 'banana'));
Assert::same('leek', Arrays::getNextValue($testArray, 'carrot'));
Assert::same('strawberry', Arrays::getNextValue($testArray, 'raspberry'));

$testNestedArray = [
	2 => ['x','1'],
	3 => ['c','4'],
	33 => ['d','5'],
	'a' => ['f','7'],
	'b' => ['g','9'],
];

// next value
Assert::same(['c','4'], Arrays::getNextValue($testNestedArray, ['x','1']));
Assert::same(['x','1'], Arrays::getNextValue($testNestedArray, ['g','9']));
Assert::same(['f','7'], Arrays::getNextValue($testNestedArray, ['d','5']));

// previous value
Assert::same(['c','4'], Arrays::getPreviousValue($testNestedArray, ['d','5']));
Assert::same(['g','9'], Arrays::getPreviousValue($testNestedArray, ['x','1']));
Assert::same(['d','5'], Arrays::getPreviousValue($testNestedArray, ['f','7']));
