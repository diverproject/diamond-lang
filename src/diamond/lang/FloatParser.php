<?php

namespace diamond\lang;

use diamond\lang\exceptions\NumberException;

/**
 * Classe utilitária para trabalhar com a análise e verificações básicas de números flutuantes.
 *
 * @author Driw
 */
class FloatParser extends NumberParser
{
	/**
	 * @var float valor mínimo permitido para números float (arquitetura 32bits).
	 */
	public const MIN_FLOAT_32 = '1.17549e-38';
	/**
	 * @var float valor máximo permitido para números float (arquitetura 32bits).
	 */
	public const MAX_FLOAT_32 = '3.40282e+38';
	/**
	 * @var float valor mínimo permitido para números float (arquitetura 64bits).
	 */
	public const MIN_FLOAT_64 = '2.2250738585072e-308';
	/**
	 * @var float valor máximo permitido para números float (arquitetura 64bits).
	 */
	public const MAX_FLOAT_64 = '1.7976931348623e+308';
	/**
	 * @var float número de precisão segura para número float (arquitetura 32bits).
	 */
	public const FLOAT_PRECISION_32 = 7;
	/**
	 * @var float número de precisão segura para número float (arquitetura 64bits).
	 */
	public const FLOAT_PRECISION_64 = 15;

	/**
	 * Não é permitido instâncias desta classe, sem utilidade.
	 */
	private function __construct() { }

	/**
	 * Dependendo da arquitetura do sistema (32 ou 64 bits) os limites de números flutuantes mudam.
	 * @return float aquisição do valor mínimo para números flutuantes.
	 */
	public static function getMinValue(): float
	{
		return floatval(System::isArchitecture32() ? self::MIN_FLOAT_32 : self::MIN_FLOAT_64);
	}

	/**
	 * Dependendo da arquitetura do sistema (32 ou 64 bits) os limites de números flutuantes mudam.
	 * @return float aquisição do valor máximo para números flutuantes.
	 */
	public static function getMaxValue(): float
	{
		return floatval(System::isArchitecture32() ? self::MAX_FLOAT_32 : self::MAX_FLOAT_64);
	}

	/**
	 * Dependendo da arquitetura do sistema (32 ou 64 bite) a precisão de números flutuantes mudam.
	 * @return int aquisição do limite de precisão <b>COM SEGURANÇA</b>.
	 */
	public static function getPrecision(): int
	{
		return System::isArchitecture32() ? self::FLOAT_PRECISION_32 : self::FLOAT_PRECISION_64;
	}

	/**
	 * Verifica se um valor em string possui um formato numérico flutuante,
	 * também verifica se o valor está dentro dos limites permitidos para um float.
	 * @param string $string valor do qual deseja verificar se é compatível.
	 * @return bool true se for compatível ou false caso contrário.
	 */
	public static function isFloat(string $string): bool
	{
		return self::parseFloatPrecision($string, self::getPrecision());
	}

	/**
	 * Analisa um valor em string para tentar convertê-lo em um valor numérico flutuante.
	 * @param string $string valor do qual deseja analisar e converter.
	 * @param bool $throws [optional] habilitar o uso de exceção em caso de falha.
	 * @throws NumberException caso habilitado <code>throws</code> e o valor for inválido.
	 * @return float|NULL número flutuante obtido ou NULL se for inválido.
	 */
	public static function parseFloat(string $string, ?bool $throws = null): ?float
	{
		if (!self::isFloat($string))
		{
			if (Diamond::isEnabledParseThrows($throws))
				throw new NumberException(NumberException::NE_PARSE_FLOAT);

			return null;
		}

		return floatval($string);
	}

	/**
	 * Limita um número flutuante para estar entre uma faixa de valores.
	 * @param float $float valor do qual deseja limitar.
	 * @param float $min valor mínimo permitido na análise.
	 * @param float $max valor máximo permitido na análise.
	 * @return float aquisição de um valor dentro dos limites informados.
	 */
	public static function cap(float $float, float $min, float $max): float
	{
		return $float < $min ? $min : ($float > $max ? $max : $float);
	}

	/**
	 * Limita um número flutuante para possuir um valor mínimo.
	 * @param float $float valor do qual deseja limitar.
	 * @param float $min valor mínimo permitido na análise.
	 * @return float aquisição de um valor dentro do limite informado.
	 */
	public static function capMin(float $float, float $min): float
	{
		return $float < $min ? $min : $float;
	}

	/**
	 * Limita um número flutuante para possuir um valor máximo.
	 * @param float $float valor do qual deseja limitar.
	 * @param float $max valor mínimo permitido na análise.
	 * @return float aquisição de um valor dentro do limite informado.
	 */
	public static function capMax(float $float, float $max): float
	{
		return $float > $max ? $max : $float;
	}

	/**
	 * Verifica se um valor numérico flutuante possui um valor mínimo.
	 * @param float $float valor do qual será analisado.
	 * @param float $min valor mínimo permitido na analise.
	 * @return bool true se estiver dentro do limite ou false caso contrário.
	 */
	public static function hasMin(float $float, float $min): bool
	{
		return $float >= $min;
	}

	/**
	 * Verifica se um valor numérico flutuante possui um valor máximo.
	 * @param float $float valor do qual será analisado.
	 * @param float $max valor máximo permitido na analise.
	 * @return bool true se estiver dentro do limite ou false caso contrário.
	 */
	public static function hasMax(float $float, float $max): bool
	{
		return $float <= $max;
	}

	/**
	 * Verifica se um valor numérico flutuante está dentro de uma faixa de valores.
	 * @param float $float valor do qual será analisado.
	 * @param float $min valor mínimo da faixa de valores.
	 * @param float $max valor máximo da faixa de valores.
	 * @return bool true se estiver dentro da faixa ou false caso contrário.
	 */
	public static function hasBetween(float $float, float $min, float $max): bool
	{
		return self::hasMin($float, $min) && self::hasMax($float, $max);
	}
}

