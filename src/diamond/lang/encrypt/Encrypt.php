<?php

namespace diamond\lang\encrypt;

/**
 * Encriptador
 *
 * Classe que permite encriptar valores de forma simples e rápida.
 * Por ser uma biblioteca Open-Source recomenda-mos trocar a chave padrão.
 *
 * @author Andrew
 */
interface Encrypt
{
	/**
	 * Realiza a encriptografia de um valor no formato string podendo ser os bytes dos dados.
	 * @param string $string string contendo os dados que serão encriptados.
	 * @return string aquisição do conteúdo encriptado conforme dados e chave.
	 */
	public function encrypt(string $string);

	/**
	 * Realiza o descriptografia de um valor criptografado.
	 * <i>Vale lembrar que chave deve ser a mesma usada durante a criptografia.</i>
	 * @param string $string string contendo os dados que foram criptografados.
	 * @return string aquisição do conteúdo descriptografado conforme dados e chave.
	 */
	public function decrypt(string $string): string;
}

