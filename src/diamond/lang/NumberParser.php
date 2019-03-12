<?php

namespace diamond\lang;

use diamond\lang\exceptions\NumberException;

/**
 * Classe utilitária para trabalhar na validação e análise de valores numéricos.
 *
 * @author Driw
 */
class NumberParser
{
	/**
	 * @var código para validar números flutuantes apenas com ponto ou vírgula.
	 */
	public const FLOAT_TYPE = 0;
	/**
	 * @var código para validar números flutuantes apenas com ponto.
	 */
	public const FLOAT_DOT_TYPE = 1;
	/**
	 * @var código para validar números flutuantes apenas com vírgula.
	 */
	public const FLOAT_COMMA_TYPE = 2;

	/**
	 * @var string padrão regex para validação de números flutuantes (ponto ou vírgula).
	 */
	public const FLOAT_PATTERN = '/^[-+]?(?:\d+|\d*[\,\.]{1}\d+|\d+[\,\.]{1}\d*([eE][-+]\d+)?)$/';
	/**
	 * @var string padrão regex para validação de números flutuantes (somento ponto).
	 */
	public const FLOAT_DOT_PATTERN = '/^[-+]?(?:\d+|\d*\.\d+|\d+\.\d*([eE][-+]\d+)?)$/';
	/**
	 * @var string padrão regex para validação de números flutuantes (somento vírgula).
	 */
	public const FLOAT_COMMA_PATTERN = '/^[-+]?(?:\d+|\d*\,\d+|\d+\,\d*([eE][-+]\d+)?)$/';
	/**
	 * @var string padrão regex para validação de números inteiros.
	 */
	public const INTEGER_PATTERN = '/^[-+]?(0|[1-9][0-9]*)$/';
	/**
	 * @var string padrão regex para considerar uma vírgula ou um ponto.
	 */
	public const COMMA_OR_DOT_PATTERN = '/[\,\.]/';

	/**
	 * @var int tipo de número flutuante aceito na validação.
	 */
	private static $PARSE_FLOAT_TYPE = self::FLOAT_TYPE;

	/**
	 * Não é permitido instâncias desta classe, sem utilidade.
	 */
	private function __construct() { }

	/**
	 * Definir o formato padrão de números flutuantes aceitos no sistema.
	 * @param int $type código do tipo de padrão aceito: <code>FLOAT_TYPE</code>,
	 * <code>FLOAT_TYPE_DOT</code> ou <code>FLOAT_TYPE_COMMA</code>.
	 */
	public static function setFloatType(int $type)
	{
		self::$PARSE_FLOAT_TYPE = $type;
	}

	/**
	 * Verifica se uma determina string possui um valor em formato númerico flutuante.
	 * @param string $string valor do qual vai ser verificado o formato.
	 * @param int $type qual o tipo de padrão aceito como número flutuante no sistema,
	 * pode ser configurado por <code>setFloatType()</code> com padrão <code>FLOAT_TYPE</code>.
	 * @throws NumberException ocorre se o tipo for inválido.
	 * @return bool true se o valor em string estiver no formato ou false caso contrário.
	 */
	public static function hasFloatFormat(string $string, ?int $type = null): bool
	{
		if ($type === null) $type = self::$PARSE_FLOAT_TYPE;

		switch ($type)
		{
			case self::FLOAT_TYPE: return preg_match(self::FLOAT_PATTERN, $string) === 1;
			case self::FLOAT_DOT_TYPE: return preg_match(self::FLOAT_DOT_PATTERN, $string) === 1;
			case self::FLOAT_COMMA_TYPE: return preg_match(self::FLOAT_COMMA_PATTERN, $string) === 1;
		}

		throw new NumberException(NumberException::NE_FLOAT_TYPE);
	}

	/**
	 * Verifica se um valor em string possui o formato de um valor numérico inteiro.
	 * Valores numéricos inteiros são válidos quando possuirem <b>APENAS</b> números.
	 * @param string $string valor em string do qual deseja verificar.
	 * @return bool true se possuir formato numérico inteiro ou false caso contrário.
	 */
	public static function hasIntFormat(string $string): bool
	{
		return preg_match(self::INTEGER_PATTERN, $string) === 1;
	}

	/**
	 * Analisa a precisão como número flutuante de uma determinada string.
	 * @param string $string valor a ser analisado a precisão numérica.
	 * @param int $precision qual o limite de precisão do valor.
	 * @return bool true se for válido ou false caso contrário.
	 */
	public static function parseFloatPrecision(string $string, int $precision): bool
	{
		if (!self::hasFloatFormat($string))
			return false;

		if ($string{0} === '+' || $string{0} === '-')
			$string = substr($string, 1);

		$string = preg_replace(self::COMMA_OR_DOT_PATTERN, '', $string);

		return strlen($string) <= $precision;
	}

	/**
	 * Analisa o tamanho como número inteiro de uma determinada string.
	 * @param string $string valor a ser analisado o tamanho.
	 * @param int $minValue valor numérico mínimo aceito.
	 * @param int $maxValue valor numérico máximo aceito.
	 * @return bool true se for válido ou false caso contrário.
	 */
	public static function parseIntegerLength(string $string, int $minValue, int $maxValue): bool
	{
		if (!self::hasIntFormat($string))
			return false;

		return $string >= $minValue && $string <= $maxValue;
	}
}

