<?php

namespace diamond\lang\http;

use diamond\lang\ArrayParser;

/**
 * Variáveis de Formulário
 *
 * Post é a classe que irá permitir trabalhar com variáveis que foram definidas através de formulários.
 * Esse tipo de informação apesar de ser facilmente alterado não implicada mudanças drásticas no sistema.
 * Os dados de um formulários possuem nomes especificos e devem ser validados quando enviados.
 * A informação dos formulários só poderão ser trabalhadas se houver um botão para envio do mesmo (submit)
 *
 * Para utilização desses dados, é necessário iniciar um novo formulário com <b>form</b>, tendo um <b>submit</b>.
 * Os campos podem variar de tipo, sendo caixas de texto, seleção e outros, porém sempre com um <b>name</b>.
 * No momento que for feito o submit o conteúdo dos campos será vinculado a variáveis com <b>name</b> no $_POST.
 *
 * @see ArrayParser
 * @author andrews
 */
class Post extends ArrayParser
{
	/**
	 *
	 * @param bool $throwsable
	 */
	public function __construct(bool $throwsable = false)
	{
		parent::__construct($_POST, $throwsable);
	}
}

