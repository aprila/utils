<?php

declare(strict_types=1);

/**
 * @author Honza Cerny (http://honzacerny.com)
 */

namespace Aprila\Utils;

use InvalidArgumentException;

class Colors
{
    /**
     * @param array|string $rgb
     * @param bool $withHash
     *
     * @return string
     */
    public static function rgbToHex(array|string $rgb, bool $withHash = true): string
    {
        if (is_string($rgb)) {
            // Use regex to extract RGB values from string formats like "rgb(255, 0, 0)" or "255, 255, 0"
            if (preg_match('/^(?:rgb\s*\()?\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)?$/', $rgb, $matches)) {
                $rgb = [$matches[1], $matches[2], $matches[3]];
            } else {
                throw new InvalidArgumentException('Invalid RGB string format. Expected "rgb(r, g, b)" or "r, g, b"');
            }
        }

        if (is_array($rgb)) {
            if (isset($rgb['r']) && isset($rgb['g']) && isset($rgb['b'])) {
                $rgb[0] = $rgb['r'];
                $rgb[1] = $rgb['g'];
                $rgb[2] = $rgb['b'];
            }

            if (empty($rgb) || !isset($rgb[0]) || !isset($rgb[1]) || !isset($rgb[2])) {
                throw new InvalidArgumentException('Param was not an RGB array');
            }
        } else {
            throw new InvalidArgumentException('Param was not an RGB array or string');
        }

        // Validate RGB values are within 0-255 range
        for ($i = 0; $i < 3; $i++) {
            $value = (int) $rgb[$i];
            if ($value < 0 || $value > 255) {
                throw new InvalidArgumentException("RGB value {$value} is out of range (0-255)");
            }
            $rgb[$i] = $value;
        }

        // Convert RGB to HEX
        $hex = sprintf("%02x%02x%02x", $rgb[0], $rgb[1], $rgb[2]);

        if ($withHash) {
            return strtoupper('#' . $hex);
        }

        return strtoupper($hex);
    }

    /**
     * @param string $hex
     * @return array
     */
    public static function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        if (strlen($hex) !== 6 || !ctype_xdigit($hex)) {
            throw new InvalidArgumentException("Invalid HEX color");
        }

        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2)),
        ];
    }
}
