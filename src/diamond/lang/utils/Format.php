<?php

namespace diamond\lang\utils;

GlobalFunctions::load();

/**
 * @author Andrew
 */
class Format
{
	/**
	 * @param string $format
	 * @return string
	 */
	public static function string(string $format): string
	{
		return format(func_get_args());
	}

	/**
	 * @param int $size
	 */
	public static function bytes(int $size, int $precision = 2): string
	{
		$unit = array('B','KB','MB','GB','TB','PB');
		$bytes = @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2);

		return format('%.'.$precision.'f %s', $bytes, $unit[$i]);
	}
}

