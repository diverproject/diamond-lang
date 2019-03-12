<?php

namespace diamond\lang\http;

use diamond\lang\ArrayParser;

/**
 * Variáveis de Link
 *
 * Get é a classe que irá permitir trabalhar com variáveis que foram definidas através do link acessado.
 * Esse tipo de informação pode ser facilmente alterado pelos usuários no próprio navegador.
 *
 * Ao final do link de uma página pode ser encontrado um ponto de interrogação que indica o inicio do get.
 * Os valores seguintes estarão formatados seguindo de um conjunto de variáveis sem limite definido.
 * Primeiramente é definido o nome da variável seguido do sinal de igual e o valor respectivo para tal.
 * Caso haja mais valores, serão necessário inserir um símbolo do ecommerce entre cada variável.
 *
 * Para evitar o uso incorreto do sistema, dever ser definido algumas restrições no sistema desenvolvido.
 * Tal como limite para os valores, como por exemplo a listagem de conteúdos na tela, para evitar sobrecarga.
 * Ou ainda então níveis de acesso para determinado código ou valor respectivo as variáveis ou resultado.
 *
 * @see ArrayParser
 * @author andrews
 */
class Get extends ArrayParser
{
	/**
	 *
	 * @param bool $throwsable
	 */
	public function __construct(bool $throwsable = false)
	{
		parent::__construct($_GET, $throwsable);
	}
}

