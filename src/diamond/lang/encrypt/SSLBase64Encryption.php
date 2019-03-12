<?php

namespace diamond\lang\encrypt;

/**
 * @see Encrypt
 * @author Andrew
 */
class SSLBase64Encryption implements Encrypt
{
	/**
	 * @var string chave de criptografia padrão.
	 */
	public const DEFAULT_KEY = 'hg65M03DgUpdHjeuDM6rkgOa6ImBQ1';
	/**
	 * @var string método de criptografia padrão.
	 */
	public const DEFAULT_METHOD = 'AES-256-CBC';

	/**
	 * @var string chave de criptografia.
	 */
	private $key;
	/**
	 * @var string método de criptografia.
	 */
	private $method;
	/**
	 * @var string
	 */
	private $hashkey;
	/**
	 * @var string
	 */
	private $hashiv;

	/**
	 * Cria uma nova instância de um encriptador de valores.
	 * @param string $key chave de criptografia.
	 * @param string $method método de criptografia.
	 */
	public function __construct(string $key = self::DEFAULT_KEY, string $method = self::DEFAULT_METHOD)
	{
		$this->setKey($key);
		$this->setMethod($method);
	}

	/**
	 * A chave é usada para controlar parte da criptografia,
	 * sendo necessária tanto para criptografar quando descriptografar.
	 * @return string aquisição da chave de criptografia.
	 */
	public function getKey(): string
	{
		return $this->key;
	}

	/**
	 * A chave é usada para controlar parte da criptografia,
	 * sendo necessária tanto para criptografar quando descriptografar.
	 * @param string $key chave de criptografia.
	 */
	public function setkey(string $key)
	{
		$this->key = $key;
		$this->hashkey = hash('sha256', sprintf('%s_key', $key));
		$this->hashiv = substr(hash('sha256', sprintf('%s_iv', $key)), 0, 16);
	}

	/**
	 * Método de criptografia deve ser utilizado um tipo 'OpenSSL'.
	 * @return string aquisição do método de criptografia utilizado.
	 * @link http://php.net/manual/pt_BR/function.openssl-get-cipher-methods.php
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * Método de criptografia deve ser utilizado um tipo 'OpenSSL'.
	 * @param string $encryptMethod método de criptografia utilizado.
	 * @link http://php.net/manual/pt_BR/function.openssl-get-cipher-methods.php
	 */
	public function setMethod(string $encryptMethod)
	{
		$this->method = $encryptMethod;
	}

	/**
	 * Realiza a encriptografia de um valor no formato string podendo ser os bytes dos dados.
	 * @param string $string string contendo os dados que serão encriptados.
	 * @return string aquisição do conteúdo encriptado conforme dados e chave.
	 */
	public function encrypt(string $string): string
	{
		$output = openssl_encrypt($string, $this->method, $this->hashkey, 0, $this->hashiv);
		$output = base64_encode($output);

		return $output;
	}

	/**
	 * Realiza o descriptografia de um valor criptografado.
	 * <i>Vale lembrar que chave deve ser a mesma usada durante a criptografia.</i>
	 * @param string $string string contendo os dados que foram criptografados.
	 * @return string aquisição do conteúdo descriptografado conforme dados e chave.
	 */
	public function decrypt(string $string): string
	{
		$output = base64_decode($string);
		$output = openssl_decrypt($output, $this->method, $this->hashkey, 0, $this->hashiv);

		return $output;
	}
}

