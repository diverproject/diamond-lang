<?php

namespace diamond\lang\exceptions;

use diamond\lang\Diamond;
use Exception;
use Throwable;

/**
 * Exceção ocorrida ao trabalhar com análise e validação de números.
 *
 * @author Driw
 */
class NumberException extends Exception
{
	/**
	 * @var código para <b>formato inválido para número flutuante</b>.
	 */
	public const NE_FLOAT_TYPE = 1;
	/**
	 * @var código para <b>valor inválido para número do tipo int</b>.
	 */
	public const NE_PARSE_INT = 2;
	/**
	 * @var código para <b>valor inválido para número do tipo float</b>.
	 */
	public const NE_PARSE_FLOAT = 3;

	/**
	 * Cria uma nova instância de uma exceção para valores numéricos.
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
	 * @param int $code código da exceção, verificar <code>NE_*</code>.
	 * @return NULL|string aquisição da mensagem que será exibida ou
	 * NULL caso seja informado um código inválido.
	 */
	private function getMessages(int $code): ?string
	{
		switch ($code)
		{
			case self::NE_FLOAT_TYPE: return 'formato inválido para número flutuante';
			case self::NE_PARSE_INT: return 'valor inválido para número do tipo int';
			case self::NE_PARSE_FLOAT: return 'valor inválido para número do tipo float';
		}

		return null;
	}
}

