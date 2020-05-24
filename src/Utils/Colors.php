<?php
/**
 * @author Honza Cerny (http://honzacerny.com)
 */

namespace Aprila\Utils;

use InvalidArgumentException;

class Colors
{
	/**
	 * @param array|string $rgb
	 * @param bool|TRUE $withHash
	 *
	 * @return string
	 */
	public static function rgbToHex($rgb, $withHash = TRUE)
	{
		if (is_string($rgb)) {
			$rgbString = $rgb;

			$rgbString = str_replace(' ','', $rgbString);
			$rgbString = str_replace('rgb','', $rgbString);
			$rgbString = str_replace('(','', $rgbString);
			$rgbString = str_replace(')','', $rgbString);

			if (strpos($rgbString, ',') !== 0){
				$rgb = explode(',', $rgbString);
			} else {
				throw new InvalidArgumentException('Param was not an RGB in string');
			}
		}

		if (is_array($rgb)){
			if (isset($rgb['r']) && isset($rgb['g']) && isset($rgb['b'])){
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


		// Convert RGB to HEX
		$hex[0] = dechex($rgb[0]);
		$hex[1] = dechex($rgb[1]);
		$hex[2] = dechex($rgb[2]);

		if ($withHash) {
			return strtoupper('#' . sprintf("%02s%02s%02s", $hex[0], $hex[1], $hex[2]));

		} else {
			return strtoupper(sprintf("%02s%02s%02s", $hex[0], $hex[1], $hex[2]));
		}
	}
}