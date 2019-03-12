<?php

namespace diamond\lang;

/**
 * @author Driw
 */
class StringParser
{
	/**
	 * Corta uma string do inicio até uma sequência de caracteres especificada.
	 * @param string $haystack qual será a string usada como conteúdo para recorte.
	 * @param string $needle sequência do qual deverá ser encontrada como ponto final.
	 * @param bool $include [optional] incluir a sequência no corte (padrão: true).
	 * @return string|NULL conteúdo do inicio até encontrar <b>needle</b>
	 * ou NULL caso não tenha encontrado <b>needle</b>.
	 */
	public static function subAfter(string $haystack, string $needle, bool $include = true): ?string
	{
		if (($pos = strpos($haystack, $needle)) === false)
			return null;

		if ($include)
			$pos += strlen($needle);

		$haystack = substr($haystack, $pos, strlen($haystack));

		return $haystack;
	}

	/**
	 * Corta uma string de uma sequência de caracteres até o final da string.
	 * @param string $haystack qual será a string usada como conteúdo para recorte.
	 * @param string $needle string do qual deverá ser encontrada como ponto final.
	 * @param bool $include [optional] incluir a sequência no corte (padrão: true).
	 * @return string|NULL nova string com o conteúdo do inicio até encontrar <b>needle</b>
	 * ou NULL caso não tenha encontrado <b>needle</b>.
	 */
	public static function subBefore(string $haystack, string $needle, bool $include = true): ?string
	{
		if (($pos = strpos($haystack, $needle)) === false)
			return null;

		if ($include)
			$pos += strlen($needle);

			$haystack = substr($haystack, 0, $pos);

		return $haystack;
	}

	/**
	 * Verifica se uma determinada string inicia com um conteúdo especificado.
	 * @param string $haystack string do qual será verificado o inicio.
	 * @param string $needle conteúdo do qual <b>$haystack</b> deve iniciar.
	 * @return bool true se iniciar com <b>$needle</b> ou false caso contrário.
	 */
	public static function startsWith(string $haystack, string $needle): bool
	{
		return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
	}

	/**
	 * Verifica se uma determinada string termina com um conteúdo especificado.
	 * @param string $haystack string do qual será verificado o término.
	 * @param string $needle conteúdo do qual <b>$haystack</b> deve termninar.
	 * @return bool true se termninar com <b>$needle</b> ou false caso contrário.
	 */
	public static function endsWith(string $haystack, string $needle): bool
	{
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}

	/**
	 * Verifica se uma determinada string possui um determinado conteúdo especificado.
	 * @param string $haystack string contendo o valor do qual será feito a busca.
	 * @param string $needle string contendo o valor do qual será usado como busca.
	 * @return bool se $heystack contém $needle em alguma parte sua.
	 */
	public static function contains(string $haystack, string $needle): bool
	{
		return strpos($haystack, $needle) !== false;
	}

	/**
	 * Limina a quantidade de caracteres de uma string conforme o valor e tamanho especificados.
	 * @param string $string string contendo o valor (caracteres) dos quais podem ser limitados.
	 * @param int $lenght quantidade de caracteres do qual será limitado se necessário.
	 * @return string aquisição da string com caracteres limitados se necessário.
	 */
	public static function capLength(string $string, int $length): string
	{
		return strlen($string) > $length ? substr($string, 0, $length) : $string;
	}

	/**
	 * Verifica se uma string possui uma quantidade de caracteres mínimo confome especificado:
	 * @param string $string string contendo do qual deseja verificar se está no tamanho mínimo.
	 * @param int $length quantidade de caracteres mínimos que será aceito na validação.
	 * @return bool true se estiver dentro do limite ou false caso contrário.
	 */
	public static function hasMinLength(string $string, int $length): bool
	{
		return strlen($string) >= $length;
	}

	/**
	 * Verifica se uma string possui uma quantidade de caracteres máximo confome especificado:
	 * @param string $string string contendo do qual deseja verificar se está no tamanho máximo.
	 * @param int $length quantidade de caracteres máximos que será aceito na validação.
	 * @return bool true se estiver dentro do limite ou false caso contrário.
	 */
	public static function hasMaxLength(string $string, int $length): bool
	{
		return strlen($string) <= $length;
	}

	/**
	 * Verifica se uma string possui uma quantidade de caracteres mínimo e máximo confome especificado:
	 * @param string $string string contendo do qual deseja verificar se está dentro da faixa de tamanho.
	 * @param int $minLength quantidade de caracteres mínimos que será aceito na validação.
	 * @param int $maxLength quantidade de caracteres máximos que será aceito na validação.
	 * @return bool true se estiver dentro dos limites (faixa) ou false caso contrário.
	 */
	public static function hasBetweenLength(string $string, int $minLength, int $maxLength): bool
	{
		return self::hasMinLength($string, $minLength) && self::hasMaxLength($string, $maxLength);
	}

	/**
	 * Verifica se uma determinada estring está vazia, para isso precisa ter tamanho zero.
	 * @param string $string referência da string do qual será verificada.
	 * @return bool true se estiver vazia ou false caso contrário.
	 */
	public static function isEmpty(?string $string): bool
	{
		return strlen($string) === 0;
	}
}

