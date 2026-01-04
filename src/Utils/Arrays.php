<?php

declare(strict_types=1);

/**
 * @author Honza Cerny (http://honzacerny.com)
 */

namespace Aprila\Utils;

use LogicException;

class Arrays
{

    final public function __construct()
    {
        throw new LogicException("Static class - cannot be instantiated");
    }

    /**
     * @param array $array
     * @param string|int $curr_key
     * @return string|int|null
     */
    public static function getNextKey(array $array, string|int $curr_key): string|int|null
    {
        $keys = array_keys($array);
        $position = array_search($curr_key, $keys, true);

        if ($position === false) {
            return $keys[0] ?? null;
        }

        if (isset($keys[$position + 1])) {
            return $keys[$position + 1];
        }

        return $keys[0] ?? null;
    }


    /**
     * @param array $array
     * @param string|int $curr_key
     * @return string|int|null
     */
    public static function getPreviousKey(array $array, string|int $curr_key): string|int|null
    {
        $keys = array_keys($array);
        $position = array_search($curr_key, $keys, true);

        if ($position === false) {
            return $keys[count($keys) - 1] ?? null;
        }

        if (isset($keys[$position - 1])) {
            return $keys[$position - 1];
        }

        return $keys[count($keys) - 1] ?? null;
    }


    /**
     * @param array $array
     * @param mixed $curr_val
     * @return mixed
     */
    public static function getNextValue(array $array, mixed $curr_val): mixed
    {
        $values = array_values($array);
        $position = array_search($curr_val, $values, true);

        if ($position === false) {
            return $values[0] ?? null;
        }

        if (isset($values[$position + 1])) {
            return $values[$position + 1];
        }

        return $values[0] ?? null;
    }


    /**
     * @param array $array
     * @param mixed $curr_val
     * @return mixed
     */
    public static function getPreviousValue(array $array, mixed $curr_val): mixed
    {
        $values = array_values($array);
        $position = array_search($curr_val, $values, true);

        if ($position === false) {
            return $values[count($values) - 1] ?? null;
        }

        if (isset($values[$position - 1])) {
            return $values[$position - 1];
        }

        return $values[count($values) - 1] ?? null;
    }

}
