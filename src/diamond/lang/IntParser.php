<?php

namespace diamond\lang;

use diamond\lang\exceptions\NumberException;


/**
 * Classe utilitária para trabalhar com a análise e verificações básicas de números inteiros.
 *
 * @author Driw
 */
class IntParser extends NumberParser
{
	/**
	 * @var int valor mínimo permitido para números int (arquitetura 32bits).
	 */
	public const MIN_INTEGER_32 = '-2147483648';
	/**
	 * @var int valor máximo permitido para números int (arquitetura 32bits).
	 */
	public const MAX_INTEGER_32 = '2147483647';
	/**
	 * @var int valor mínimo permitido para números int (arquitetura 64bits).
	 */
	public const MIN_INTEGER_64 = '-9223372036854775808';
	/**
	 * @var int valor máximo permitido para números int (arquitetura 64bits).
	 */
	public const MAX_INTEGER_64 = '9223372036854775807';

	/**
	 * Não é permitido instâncias desta classe, sem utilidade.
	 */
	private function __construct() { }

	/**
	 * Dependendo da arquitetura do sistema (32 ou 64 bits) os limites de números inteiros mudam.
	 * @return int aquisição do valor mínimo para números inteiros.
	 */
	public static function getMinValue(): int
	{
		return intval(System::isArchitecture32() ? self::MIN_INTEGER_32 : self::MIN_INTEGER_64);
	}

	/**
	 * Dependendo da arquitetura do sistema (32 ou 64 bits) os limites de números inteiros mudam.
	 * @return int aquisição do valor máximo para números inteiros.
	 */
	public static function getMaxValue(): int
	{
		return intval(System::isArchitecture32() ? self::MAX_INTEGER_32 : self::MAX_INTEGER_64);
	}

	/**
	 * Verifica se um valor em string possui um formato numérico inteiro,
	 * também verifica se o valor está dentro dos limites permitidos para um integer.
	 * @param string $string valor do qual deseja verificar se é compatível.
	 * @return bool true se for compatível ou false caso contrário.
	 */
	public static function isInteger(string $string): bool
	{
		return self::parseIntegerLength($string, self::getMinValue(), self::getMaxValue());
	}

	/**
	 * Analisa um valor em string para tentar convertê-lo em um valor numérico inteiro.
	 * @param string $string valor do qual deseja analisar e converter.
	 * @param bool $throws [optional] habilitar o uso de exceção em caso de falha.
	 * @throws NumberException caso habilitado <code>throws</code> e o valor for inválido.
	 * @return int|NULL número inteiro obtido ou NULL se for inválido.
	 */
	public static function parseInteger(string $string, ?bool $throws = null): ?int
	{
		if (!self::isInteger($string))
		{
			if (Diamond::isEnabledParseThrows($throws))
				throw NumberException::NE_PARSE_INT;

			return null;
		}

		return intval($string);
	}

	/**
	 * Limita um número inteiro para estar entre uma faixa de valores.
	 * @param int $int valor do qual deseja limitar.
	 * @param int $min valor mínimo permitido na análise.
	 * @param int $max valor máximo permitido na análise.
	 * @return int aquisição de um valor dentro dos limites informados.
	 */
	public static function cap(int $int, int $min, int $max): int
	{
		return $int < $min ? $min : ($int > $max ? $max : $int);
	}

	/**
	 * Limita um número inteiro para possuir um valor mínimo.
	 * @param int $int valor do qual deseja limitar.
	 * @param int $min valor mínimo permitido na análise.
	 * @return int aquisição de um valor dentro do limite informado.
	 */
	public static function capMin(int $int, int $min): int
	{
		return $int < $min ? $min : $int;
	}

	/**
	 * Limita um número inteiro para possuir um valor máximo.
	 * @param int $int valor do qual deseja limitar.
	 * @param int $max valor mínimo permitido na análise.
	 * @return int aquisição de um valor dentro do limite informado.
	 */
	public static function capMax(int $int, int $max): int
	{
		return $int > $max ? $max : $int;
	}

	/**
	 * Verifica se um valor numérico inteiro possui um valor mínimo.
	 * @param int $int valor do qual será analisado.
	 * @param int $min valor mínimo permitido na analise.
	 * @return bool true se estiver dentro do limite ou false caso contrário.
	 */
	public static function hasMin(int $int, int $min): bool
	{
		return $int >= $min;
	}

	/**
	 * Verifica se um valor numérico inteiro possui um valor máximo.
	 * @param int $int valor do qual será analisado.
	 * @param int $max valor máximo permitido na analise.
	 * @return bool true se estiver dentro do limite ou false caso contrário.
	 */
	public static function hasMax(int $int, int $max): bool
	{
		return $int <= $max;
	}

	/**
	 * Verifica se um valor numérico inteiro está dentro de uma faixa de valores.
	 * @param int $int valor do qual será analisado.
	 * @param int $min valor mínimo da faixa de valores.
	 * @param int $max valor máximo da faixa de valores.
	 * @return bool true se estiver dentro da faixa ou false caso contrário.
	 */
	public static function hasBetween(int $int, int $min, int $max): bool
	{
		return self::hasMin($int, $min) && self::hasMax($int, $max);
	}
}

