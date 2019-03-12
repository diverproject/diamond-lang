<?php

namespace diamond\lang\exceptions;

use Exception;

/**
 * @see Exception
 * @author Driw
 */
class ArrayParserException extends Exception
{
	/**
	 * @var int
	 */
	public const APE_KEY_NOT_FOUND = 1;
	/**
	 * @var int
	 */
	public const APE_PARSER_STRING = 2;
	/**
	 * @var int
	 */
	public const APE_PARSER_INT = 3;
	/**
	 * @var int
	 */
	public const APE_PARSER_FLOAT = 4;
	/**
	 * @var int
	 */
	public const APE_PARSER_BOOL = 5;
	/**
	 * @var int
	 */
	public const APE_PARSER_ARRAY = 6;
	/**
	 * @var int
	 */
	public const APE_PARSER_OBJECT = 7;

	/**
	 *
	 * @param string $key
	 * @return ArrayParserException
	 */
	public static function newKeyNotFound(string $key): ArrayParserException
	{
		return new ArrayParserException(format(self::getMessages(self::APE_KEY_NOT_FOUND), $key), self::APE_KEY_NOT_FOUND);
	}

	/**
	 *
	 * @param string $key
	 * @return ArrayParserException
	 */
	public static function newParseString(string $key): ArrayParserException
	{
		return new ArrayParserException(format(self::getMessages(self::APE_PARSER_STRING), $key), self::APE_PARSER_STRING);
	}

	/**
	 *
	 * @param string $key
	 * @return ArrayParserException
	 */
	public static function newParseInt(string $key): ArrayParserException
	{
		return new ArrayParserException(format(self::getMessages(self::APE_PARSER_INT), $key), self::APE_PARSER_INT);
	}

	/**
	 *
	 * @param string $key
	 * @return ArrayParserException
	 */
	public static function newParseFloat(string $key): ArrayParserException
	{
		return new ArrayParserException(format(self::getMessages(self::APE_PARSER_FLOAT), $key), self::APE_PARSER_FLOAT);
	}

	/**
	 *
	 * @param string $key
	 * @return ArrayParserException
	 */
	public static function newParseBool(string $key): ArrayParserException
	{
		return new ArrayParserException(format(self::getMessages(self::APE_PARSER_BOOL), $key), self::APE_PARSER_BOOL);
	}

	/**
	 *
	 * @param string $key
	 * @return ArrayParserException
	 */
	public static function newParseArray(string $key): ArrayParserException
	{
		return new ArrayParserException(format(self::getMessages(self::APE_PARSER_ARRAY), $key), self::APE_PARSER_ARRAY);
	}

	/**
	 *
	 * @param string $key
	 * @return ArrayParserException
	 */
	public static function newParseObject(string $key): ArrayParserException
	{
		return new ArrayParserException(format(self::getMessages(self::APE_PARSER_OBJECT), $key), self::APE_PARSER_OBJECT);
	}

	/**
	 * Procedimento interno para se obter as mensagens por código de exceção.
	 * @param int $code código da exceção, verificar <code>APE_*</code>.
	 * @return NULL|string aquisição da mensagem que será exibida ou
	 * NULL caso seja informado um código inválido.
	 */
	private function getMessages(int $code): ?string
	{
		switch ($code)
		{
			case self::APE_KEY_NOT_FOUND:
				return 'parâmetro %s não encontrada';

			case self::APE_PARSER_STRING:
			case self::APE_PARSER_INT:
			case self::APE_PARSER_FLOAT:
			case self::APE_PARSER_BOOL:
			case self::APE_PARSER_ARRAY:
			case self::APE_PARSER_OBJECT:
				return 'parâmetro %s inválido';
		}

		return null;
	}
}

