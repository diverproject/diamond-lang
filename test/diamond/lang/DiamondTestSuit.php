<?php

namespace test\diamond\lang;

use PHPUnit\Framework\TestSuite;

/**
 * Static test suite.
 */
class DiamondTestSuit extends TestSuite
{
	/**
	 * Constructs the test suite handler.
	 */
	public function __construct()
	{
		$this->setName('DiamondTestSuit');
		$this->addTestSuite(ArrayParserTest::class);
		$this->addTestSuite(BitwiseTest::class);
		$this->addTestSuite(BoolParserTest::class);
		$this->addTestSuite(DiamondTest::class);
		$this->addTestSuite(FloatParserTest::class);
		$this->addTestSuite(IntParserTest::class);
		$this->addTestSuite(NumberParserTest::class);
		$this->addTestSuite(SSLBase64EncryptionTest::class);
		$this->addTestSuite(StringParserTest::class);
	}

	/**
	 * Creates the suite.
	 */
	public static function suite()
	{
		return new self();
	}
}

