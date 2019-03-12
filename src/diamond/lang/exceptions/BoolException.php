<?php

namespace diamond\lang\exceptions;

use diamond\lang\Diamond;
use Exception;
use Throwable;

/**
 * Exceção ocorrida ao trabalhar com análise e validação de booleanos.
 *
 * @author Driw
 */
class BoolException extends Exception
{
	/**
	 * @var código para <b>valor inválido para bool</b>.
	 */
	public const BE_PARSE_BOOL = 1;

	/**
	 * Cria uma nova instância de uma exceção para valores booleanos.
	 * @param string|int $message mensagem ou código da exceção gerada.
	 * @param int $code [optional] código número da exceção gerada.
	 * @param Throwable $previous [optional] exceção gerada anteriormente.
	 */
	public function __construct($message, ?int $code = null, ?Throwable $previous = null)
	{
		if (Diamond::getType($message) === Diamond::TYPE_INTEGER)
			$message = self::getMessages(($code = $message));

		parent::__construct(strval($message), $code, $previous);
	}

	/**
	 * Procedimento interno para se obter as mensagens por código de exceção.
	 * @param int $code código da exceção, verificar <code>BE_*</code>.
	 * @return NULL|string aquisição da mensagem que será exibida ou
	 * NULL caso seja informado um código inválido.
	 */
	private function getMessages(int $code): ?string
	{
		switch ($code)
		{
			case self::NE_PARSE_BOOL: return 'valor inválido para tipo bool';
		}

		return null;
	}
}

