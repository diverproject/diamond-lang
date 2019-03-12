<?php

namespace diamond\lang;

/**
 * @author Driw
 */
class Diamond
{
	/**
	 * @var int código para valores do tipo objeto.
	 */
	public const TYPE_OBJECT = 0;
	/**
	 * @var int código para valores do tipo booleano.
	 */
	public const TYPE_BOOLEAN = 1;
	/**
	 * @var int código para valores do tipo número inteiro.
	 */
	public const TYPE_INTEGER = 2;
	/**
	 * @var int código para valores do tipo número flutuante.
	 */
	public const TYPE_FLOAT = 3;
	/**
	 * @var int código para valores do tipo string.
	 */
	public const TYPE_STRING = 4;
	/**
	 * @var int código para valores do tipo vetor.
	 */
	public const TYPE_ARRAY = 5;
	/**
	 * @var int código para valores do tipo recurso.
	 */
	public const TYPE_RESOURCE = 6;
	/**
	 * @var int código para valores do tipo nulo.
	 */
	public const TYPE_NULL = 7;
	/**
	 * @var int código para valores do tipo desconhecido.
	 */
	public const TYPE_UNKNOW = 8;

	/**
	 * @var int código para definir o sistema em execução dos casos de teste.
	 */
	public const ENVIRONMENT_TEST_CASE = 0;
	/**
	 * @var int código para definir o sistema em execução no ambiente de homolocação.
	 */
	public const ENVIRONMENT_HOMOLOG = 2;
	/**
	 * @var int código para definir o sistema em execução no ambiente de produção.
	 */
	public const ENVIRONMENT_PRODUCTION = 2;

	/**
	 * @var int código do ambiente de execução do sistema.
	 */
	private static $environment = self::ENVIRONMENT_PRODUCTION;
	/**
	 * @var bool habilitar o uso de exceções para análise.
	 */
	private static $enableParseThrows = false;

	/**
	 * Obtém o código do tipo da variável, variáveis podem possuir diversos tipos conforme <code>TYPE_*</code>.
	 * @param mixed $var variável do qual deseja saber o tipo.
	 * @return int aquisição do código do tipo de valor que a variável possui.
	 */
	public static function getType($var): int
	{
		switch (strtolower(gettype($var)))
		{
			case 'boolean':
			case 'bool':
				return self::TYPE_BOOLEAN;

			case 'byte':
			case 'short':
			case 'integer':
			case 'int':
			case 'long':
				return self::TYPE_INTEGER;

			case 'double':
			case 'float':
				return self::TYPE_FLOAT;

			case 'string':
			case 'str':
				return self::TYPE_STRING;

			case 'array':
				return self::TYPE_ARRAY;

			case 'resource':
				return self::TYPE_RESOURCE;

			case 'null':
				return self::TYPE_NULL;
		}

		return is_object($var) ? self::TYPE_OBJECT : self::TYPE_UNKNOW;
	}

	/**
	 * Por padrão é configurado para ambiente de Produção <code>ENVIRONMENT_PRODUCTION</code>.
	 * Para consultar os tipos de ambientes disponíveis verificar <code>ENVIRONMENT_*</code>.
	 * @return int aquisição do código do ambiente de execução do sistema.
	 */
	public static function getEnvironment(): int
	{
		return Diamond::$environment;
	}

	/**
	 * Por padrão é configurado para ambiente de Produção <code>ENVIRONMENT_PRODUCTION</code>.
	 * Para consultar os tipos de ambientes disponíveis verificar <code>ENVIRONMENT_*</code>.
	 * @param int $environment código do ambiente de execução do sistema.
	 */
	public static function setEnvironment(int $environment)
	{
		Diamond::$environment = $environment;
	}

	/**
	 * Verifica se está habilitado o uso de exceções durante procedimentos de análise.
	 * @param bool $default [optional] valor padrão sobrescreve a configuração.
	 * @return bool true se estiver habilitado ou false caso contrário.
	 */
	public static function isEnabledParseThrows(?bool $default = null): bool
	{
		if ($default === null)
			return self::$enableParseThrows;

		return $default;
	}

	/**
	 * Define se o sistema deve usar exceções durante procedimentos de análise.
	 * Por padrão o sistema vem configurado com o valor <code>FALSE</code>.
	 * @param bool $enable true para habilitar exceções e false para desabilitar.
	 */
	public static function setEnabledParseThrows(bool $enable)
	{
		self::$enableParseThrows = $enable;
	}
}

