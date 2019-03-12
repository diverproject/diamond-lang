<?php

namespace diamond\lang\http;

use diamond\lang\ArrayParser;

/**
 * Sessão
 *
 * Classe usada para facilitar o gerenciamento e utilização de funcionalidades relacionadas a sessão do navegador.
 * Um nova sessão é criada no momento em que a página for aberta pela primeira vez se o sistema assim desejar.
 * Após isso, só será encerrada manualmente ou automaticamente quando o navegador for fechado pelo usuário.
 *
 * Sessões são importantes, pois armazenam valores temporários no navegador, podendo ser usado em outras páginas.
 * Por tanto em uma página A é posível armazenar dados que uma página B, C (...) possam utilizar tranquilamente.
 * Para que isso seja possível, uma sessão deverá ser iniciada, e os valores vinculados a um nome a ser definido.
 *
 * @author andrews
 */
class Session extends ArrayParser
{
	/**
	 *
	 * @param bool $throwsable
	 */
	public function __construct(bool $throwsable = false)
	{
		parent::__construct($this->isActived() ? $_SESSION : [], $throwsable);
	}

	/**
	 *
	 * @return string
	 */
	public function getId(): string
	{
		return session_id();
	}

	/**
	 *
	 * @param string $sid
	 */
	public function setId(string $sid)
	{
		session_id($sid);
	}

	/**
	 *
	 * @return bool
	 */
	public function isNone(): bool
	{
		return session_status() === PHP_SESSION_NONE;
	}

	/**
	 *
	 * @return bool
	 */
	public function isActived(): bool
	{
		return session_status() === PHP_SESSION_ACTIVE;
	}

	/**
	 *
	 * @return bool
	 */
	public function isDisabled(): bool
	{
		return session_status() === PHP_SESSION_DISABLED;
	}

	/**
	 * Solicita a iniciação de uma nova sessão no sistema, se não houver nenhuma será criado uma.
	 * Se não houver nenhuma sessão inicia uma nova, caso haja uma desativada irá reiniciá-la.
	 */

	public function start()
	{
		if ($this->isNone())
			session_start();

		if ($this->isDisabled())
			session_reset();

		$this->setArrayData($_SESSION);
	}

	/**
	 * Solicita a destruição da sessão atual, significa apagar todos os dados existentes da mesma.
	 * Caso não haja uma sesão ativa no mesmo, nada irá acontecer ao chamar esse função.
	 */

	public function destroy()
	{
		if ($this->isActived())
			session_destroy();
	}

	/**
	 * Solicita ao sistema para restabelecer a sessão atual com seus valores orignais.
	 * Caso já exista uma sessão essa será restabelecida, restaurando os valroes originais.
	 * Se a sessão não for encontrada, então irá estabelecer uma nova sessão para o mesmo.
	 */

	public function reset()
	{
		if ($this->isActived())
			session_reset();
		else
			$this->start();
	}

	/**
	 * Solicita que os dados sejam salvos forçadamente salvos no sistema (session_write_close).
	 * Essa função só será aplicada se houver uma sessão atualmente ativa no sistema.
	 */

	public function commit()
	{
		if ($this->isActived())
			session_commit();
	}
}

