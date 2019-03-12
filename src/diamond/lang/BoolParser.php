<?php

namespace diamond\lang;

use diamond\lang\exceptions\BoolException;

/**
 * @author Andrew
 */
class BoolParser
{
	/**
	 * @var array valores válidos como verdadeiro.
	 */
	private static $VALID_TRUE_BOOL = [1, '1', true, 'yes', 'true', 'on'];
	/**
	 * @var array valores válidos como falso.
	 */
	private static $VALID_FALSE_BOOL = [0, '0', false, 'no', 'false', 'off'];

	/**
	 * Não é permitido instâncias desta classe, sem utilidade.
	 */
	private function __construct() { }

	/**
	 * Verifica se um determinado valor passado pode ser convertido para um booleano.
	 * @param integer|boolean|string $value referência do valor do qual deverá ser verificado.
	 * @return bool true se for um valor booleano ou false caso contrário.
	 */
	public static function isBool($value): bool
	{
		return self::parseBool($value) !== null;
	}

	/**
	 * Converte um determinado valor para um valor booleano se assim for possível.
	 * Valores booleanos são aquelas que possui um valor positivo e outro negativo.
	 * 1 ou 0, true ou false (boolean ou string), yes ou no, on ou off.
	 * @param integer|boolean|string $value valor do qual será convertido para booleano.
	 * @return bool|NULL valor em boolean se assim for ou null caso contrário.
	 */
	public static function parseBool($value, ?bool $throws = null): ?bool
	{
		foreach (self::$VALID_TRUE_BOOL as $true)
			if ($true === $value)
				return true;

		foreach (self::$VALID_FALSE_BOOL as $false)
			if ($false === $value)
				return false;

		if ($throws)
		{
			if (Diamond::isEnabledParseThrows($throws))
				throw BoolException::BE_PARSE_BOOL;
		}

		return null;
	}
}

