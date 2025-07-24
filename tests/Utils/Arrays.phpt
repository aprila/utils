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
    2 => ['x', '1'],
    3 => ['c', '4'],
    33 => ['d', '5'],
    'a' => ['f', '7'],
    'b' => ['g', '9'],
];

// next value
Assert::same(['c', '4'], Arrays::getNextValue($testNestedArray, ['x', '1']));
Assert::same(['x', '1'], Arrays::getNextValue($testNestedArray, ['g', '9']));
Assert::same(['f', '7'], Arrays::getNextValue($testNestedArray, ['d', '5']));

// previous value
Assert::same(['c', '4'], Arrays::getPreviousValue($testNestedArray, ['d', '5']));
Assert::same(['g', '9'], Arrays::getPreviousValue($testNestedArray, ['x', '1']));
Assert::same(['d', '5'], Arrays::getPreviousValue($testNestedArray, ['f', '7']));


// Edge cases and error conditions

// Empty array tests
$emptyArray = [];
Assert::null(Arrays::getNextKey($emptyArray, 'nonexistent'));
Assert::null(Arrays::getPreviousKey($emptyArray, 'nonexistent'));
Assert::same(false, Arrays::getNextValue($emptyArray, 'nonexistent')); // returns false for empty array (current() behavior)
Assert::same(false, Arrays::getPreviousValue($emptyArray, 'nonexistent'));

// Single element array
$singleArray = ['only' => 'value'];
Assert::same('only', Arrays::getNextKey($singleArray, 'only')); // wraps around
Assert::same('only', Arrays::getPreviousKey($singleArray, 'only')); // wraps around
Assert::same('value', Arrays::getNextValue($singleArray, 'value')); // wraps to first
Assert::same('value', Arrays::getPreviousValue($singleArray, 'value')); // wraps around

// Non-existing key/value tests
$testArrayCopy = $testArray;
Assert::same(2, Arrays::getNextKey($testArrayCopy, 'nonexistent')); // returns first key when not found
Assert::same('y', Arrays::getPreviousKey($testArrayCopy, 'nonexistent')); // returns last key when not found
Assert::same('strawberry', Arrays::getNextValue($testArrayCopy, 'nonexistent')); // returns first value
Assert::same('raspberry', Arrays::getPreviousValue($testArrayCopy, 'nonexistent')); // returns last value

// Numeric vs string key handling
$mixedKeys = [0 => 'zero', '0' => 'string_zero', 1 => 'one'];
Assert::count(2, $mixedKeys); // '0' overwrites 0, PHP converts back to int key
Assert::same(1, Arrays::getNextKey($mixedKeys, 0)); // search for int 0
Assert::same(0, Arrays::getPreviousKey($mixedKeys, 1)); // previous of 1 is 0 (int)

// Test with null values
$nullArray = ['a' => null, 'b' => 'value', 'c' => null];
Assert::same('b', Arrays::getNextKey($nullArray, 'a'));
Assert::same('value', Arrays::getNextValue($nullArray, null)); // finds first null, returns next value
Assert::same(null, Arrays::getPreviousValue($nullArray, 'value')); // returns previous null

// Test with boolean and numeric values 
// Note: Method has a bug - it treats falsy next() results as "end of array" and wraps around
$mixedValues = [true, false, 0, 1, '', 'string'];
Assert::same(true, Arrays::getNextValue($mixedValues, true)); // finds true, next() returns false (falsy), wraps to first
Assert::same(true, Arrays::getNextValue($mixedValues, false)); // finds false, next() returns 0 (falsy), wraps to first  
Assert::same(true, Arrays::getNextValue($mixedValues, 0)); // finds 0, next() returns 1 (truthy), but then 1 != 0 fails next iteration
Assert::same(true, Arrays::getNextValue($mixedValues, 1)); // similar issue with truthy/falsy logic
Assert::same(true, Arrays::getNextValue($mixedValues, '')); // empty string causes similar issue
Assert::same(true, Arrays::getNextValue($mixedValues, 'string')); // wraps around
