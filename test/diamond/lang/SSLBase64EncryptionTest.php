<?php

namespace test\diamond\lang;

use diamond\lang\encrypt\SSLBase64Encryption;

/**
 * SSLBase64Encryption test case.
 * @see AbstractDiamondTest
 */
class SSLBase64EncryptionTest extends AbstractDiamondTest
{
	/**
	 * @var SSLBase64Encryption
	 */
	private $sslBase64Encryption;
	/**
	 * @var string
	 */
	private $key;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->key = md5(time());
		$this->sslBase64Encryption = new SSLBase64Encryption($this->key);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->sslBase64Encryption = null;

		parent::tearDown();
	}

	/**
	 * Tests SSLBase64Encryption->getKey()
	 */
	public function testGetKey()
	{
		$this->assertEquals($this->key, $this->sslBase64Encryption->getKey());
	}

	/**
	 * Tests SSLBase64Encryption->setkey()
	 */
	public function testSetkey()
	{
		$this->sslBase64Encryption->setkey($this->key);
		$this->assertEquals($this->key, $this->sslBase64Encryption->getKey());
	}

	/**
	 * Tests SSLBase64Encryption->getMethod()
	 */
	public function testGetMethod()
	{
		$this->assertEquals(SSLBase64Encryption::DEFAULT_METHOD, $this->sslBase64Encryption->getMethod());
	}

	/**
	 * Tests SSLBase64Encryption->setMethod()
	 */
	public function testSetMethod()
	{
		$this->sslBase64Encryption->setMethod(SSLBase64Encryption::DEFAULT_METHOD);
		$this->assertEquals(SSLBase64Encryption::DEFAULT_METHOD, $this->sslBase64Encryption->getMethod());
	}

	/**
	 * Tests SSLBase64Encryption->encrypt() and
	 * Tests SSLBase64Encryption->decrypt()
	 */
	public function testEncryptDecrypt()
	{
		$testMessageEncryption = format('now is %d timestamp linux message encryption', time());

		$this->assertFalse(($encryptedMessage = $this->sslBase64Encryption->encrypt($testMessageEncryption)) === $testMessageEncryption);
		$this->assertEquals($testMessageEncryption, $this->sslBase64Encryption->decrypt($encryptedMessage));
	}
}

