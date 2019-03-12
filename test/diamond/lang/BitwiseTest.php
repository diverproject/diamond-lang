<?php

namespace test\diamond\lang;

use diamond\lang\Bitwise;

/**
 * Bitwise test case.
 */
class BitwiseTest extends AbstractDiamondTest
{
	/**
	 * @var int
	 */
	public const FIRST = 0x01;
	/**
	 * @var int
	 */
	public const SECOND = 0x02;
	/**
	 * @var int
	 */
	public const THIRD = 0x04;
	/**
	 * @var int
	 */
	public const FOURTH = 0x08;

	/**
	 * @var Bitwise
	 */
	private $bitwise;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->bitwise = new Bitwise(['FIRST', 'SECOND', 'THIRD', 'FOURTH']);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->bitwise = null;

		parent::tearDown();
	}

	/**
	 * Tests Bitwise->toRawData()
	 */
	public function testToRawData()
	{
		$this->bitwise->setValue(self::FOURTH);
		$this->assertEquals(self::FOURTH, $this->bitwise->toRawData());
	}

	/**
	 * Tests Bitwise->fromRawData()
	 */
	public function testFromRawData()
	{
		$this->bitwise->fromRawData(self::THIRD);
		$this->assertEquals(self::THIRD, $this->bitwise->toRawData());
	}

	/**
	 * Tests Bitwise->getValue() and
	 * Tests Bitwise->setValue()
	 */
	public function testGetterSetterValue()
	{
		$testValues = [0, self::FIRST, self::SECOND, self::THIRD, self::FOURTH];

		foreach ($testValues as $value)
		{
			$this->bitwise->setValue($value);
			$this->assertEquals($value, $this->bitwise->getValue());
		}
	}

	/**
	 * Tests Bitwise->has() and
	 * Tests Bitwise->set() and
	 * Tests Bitwise->remove()
	 */
	public function testHas()
	{
		$this->bitwise->setValue(0);
		$randomProperties = [self::FIRST, self::SECOND, self::THIRD, self::FOURTH];
		shuffle($randomProperties);

		foreach ($randomProperties as $propertie)
		{
			$this->bitwise->set($propertie);
			$this->assertTrue($this->bitwise->has($propertie));
		}

		foreach ($randomProperties as $propertie)
		{
			$this->bitwise->remove($propertie);
			$this->assertFalse($this->bitwise->has($propertie));
		}
	}
}

