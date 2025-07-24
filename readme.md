# Aprila Toolkit - Utility Classes

A collection of PHP utility classes providing array navigation and color conversion functionality.

## Requirements

- PHP 8.4+ with strict types
- No external dependencies

## Installation

```bash
composer require aprila/utils
```

## Classes

### Arrays

Static utility class for navigating through array keys and values in sequence.

#### Methods

##### `getNextKey(array &$array, string|int $curr_key): string|int|null`
Returns the key that comes after the specified key in the array.

```php
use Aprila\Utils\Arrays;

$data = ['a' => 1, 'b' => 2, 'c' => 3];
$nextKey = Arrays::getNextKey($data, 'b'); // Returns 'c'
```

##### `getPreviousKey(array &$array, string|int $curr_key): string|int|null`
Returns the key that comes before the specified key in the array.

```php
$data = ['a' => 1, 'b' => 2, 'c' => 3];
$prevKey = Arrays::getPreviousKey($data, 'b'); // Returns 'a'
```

##### `getNextValue(array &$array, mixed $curr_val): mixed`
Returns the value that comes after the specified value in the array.

```php
$data = ['apple', 'banana', 'cherry'];
$nextValue = Arrays::getNextValue($data, 'banana'); // Returns 'cherry'
```

##### `getPreviousValue(array &$array, mixed $curr_val): mixed`
Returns the value that comes before the specified value in the array.

```php
$data = ['apple', 'banana', 'cherry'];
$prevValue = Arrays::getPreviousValue($data, 'banana'); // Returns 'apple'
```

**Note**: These methods modify the array's internal pointer. For non-existing keys/values, they return the first/last elements respectively.

### Colors

Static utility class for color format conversions.

#### Methods

##### `rgbToHex(array|string $rgb, bool $withHash = true): string`
Converts RGB color values to hexadecimal format.

**Parameters:**
- `$rgb`: RGB values as array `[r, g, b]`, named array `['r' => r, 'g' => g, 'b' => b]`, or string `"rgb(r, g, b)"` or `"r, g, b"`
- `$withHash`: Whether to include '#' prefix in output (default: true)

**Returns:** Hexadecimal color string (e.g., "#FF0000" or "FF0000")

```php
use Aprila\Utils\Colors;

// From array
$hex = Colors::rgbToHex([255, 0, 0]); // Returns "#FF0000"
$hex = Colors::rgbToHex([255, 0, 0], false); // Returns "FF0000"

// From named array  
$hex = Colors::rgbToHex(['r' => 255, 'g' => 0, 'b' => 0]); // Returns "#FF0000"

// From string formats
$hex = Colors::rgbToHex('rgb(255, 0, 0)'); // Returns "#FF0000"
$hex = Colors::rgbToHex('255, 0, 0'); // Returns "#FF0000"
$hex = Colors::rgbToHex('rgb( 255 , 0 , 0 )'); // Handles extra spaces
```

**Validation:**
- RGB values must be integers between 0-255
- String formats must match regex pattern for "rgb(r, g, b)" or "r, g, b"
- Throws `InvalidArgumentException` for invalid inputs or out-of-range values

## Error Handling

Both classes use strict typing and throw appropriate exceptions:

- `InvalidArgumentException`: For invalid input formats or out-of-range values
- `TypeError`: For incorrect parameter types (due to strict typing)
- `LogicException`: When trying to instantiate static classes

## Testing

Run the test suite:

```bash
./vendor/bin/tester tests
```

## License

See `license.md` for licensing information.
