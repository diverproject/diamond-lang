<?php

namespace diamond\lang\http;

use diamond\lang\ArrayParser;

/**
 * Cookie
 *
 * Classe usada para facilitar o gerenciamento e utilização de funcionalidades relacionadas aos cookies.
 * Cookies são dados que são armazenados internamente dentro dos navegadores individualmente por usuário.
 * São usados para guardar informações afim de facilitar a utilização do sistema ao solicitar informações.
 *
 * Por exemplo, para manter um usuário acessado mesmo após o fechamento do navegador, sessões não são suficientes.
 * É necessário guardar os dados (usuário, senha e tempo limite para reconetar) para refazer o acesso se necessário.
 * Assim o usuário terá a tela carregada já com sua conta acessada sem precisar preenhcer o formulário novamente.
 *
 * Outras funcionalidades podem ser aplicadas com a utilização dos cookie, como padrões de utilização.
 * Nesse caso é possível definir qual o idioma a ser usado, temas de estilização ou paginação dentre outros.
 * Cookies também são diferenciados por ser possível definir um tempo de expiração para o mesmo (validade).
 * Quando uma variável é expirada automaticamente ela não pode ser mais recuperada, sendo apagada.
 *
 * @see ArrayParser
 * @author andrews
 */
class Cookie extends ArrayParser
{
	/**
	 * @var int
	 */
	private $expire;
	/**
	 * @var bool
	 */
	private $expireOnlyOnce;

	/**
	 *
	 * @param bool $throwsable
	 */
	public function __construct(bool $throwsable = false)
	{
		parent::__construct($_COOKIE, $throwsable);
	}

	/**
	 *
	 * @return int
	 */
	public function getExpire(): int
	{
		return $this->expire;
	}

	/**
	 *
	 * @param int $expire
	 */
	public function setExpire(int $expire, bool $expireOnlyOnce = false)
	{
		$this->expire = $expire;
		$this->setExpireOnlyOnce($expireOnlyOnce);
	}

	/**
	 *
	 * @param string $expression
	 */
	public function setExpireExpression(string $expression, bool $expireOnlyOnce = false)
	{
		$this->setExpire(strtotime($expression), $expireOnlyOnce);
	}

	/**
	 *
	 * @param \DateTime $datetime
	 */
	public function setExpireDateTime(\DateTime $datetime, bool $expireOnlyOnce = false)
	{
		$this->setExpire($datetime->getTimestamp(), $expireOnlyOnce);
	}

	/**
	 * @return bool
	 */
	public function isExpireOnlyOnce(): bool
	{
		return $this->expireOnlyOnce;
	}

	/**
	 * @param bool $expireOnlyOnce
	 */
	public function setExpireOnlyOnce(bool $expireOnlyOnce)
	{
		$this->expireOnlyOnce = $expireOnlyOnce;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\lang\ArrayParser::setValue()
	 */
	public function setValue($key, $value)
	{
		parent::setValue($key, $value);
		setcookie($key, $value, $this->expire);

		if ($this->expireOnlyOnce === true)
		{
			$this->expire = null;
			$this->expireOnlyOnce = false;
		}
	}
}

