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
Assert::same('#FF0000', Colors::rgbToHex(['r'=>'255', 'g'=>'0', 'b'=>'0']));


Assert::exception(function(){
	Colors::rgbToHex(['255', '0']);
}, 'Nette\InvalidArgumentException');

// From string

Assert::same('#FF0000', Colors::rgbToHex('rgb(255, 0, 0)'));
Assert::same('#FFFF00', Colors::rgbToHex('255, 255, 0'));

Assert::exception(function(){
	Colors::rgbToHex('255, 0');
}, 'Nette\InvalidArgumentException');
