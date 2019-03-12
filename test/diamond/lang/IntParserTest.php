<?php

namespace test\diamond\lang;

use diamond\lang\IntParser;
use diamond\lang\System;

/**
 * IntParser test case.
 * @see AbstractDiamondTest
 */
class IntParserTest extends AbstractDiamondTest
{
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->architecture = System::getArchitecture();
	}

	/**
	 * Tests IntParser::getMinValue()
	 */
	public function testGetMinValue()
	{
		$actual = IntParser::getMinValue();

		switch ($this->architecture)
		{
			case System::ARCHITECTURE_32: $this->assertEquals(IntParser::MIN_INTEGER_32, $actual); break;
			case System::ARCHITECTURE_64: $this->assertEquals(IntParser::MIN_INTEGER_64, $actual); break;

			default:
				$this->fail(self::ARCHITECTURE_NOT_FOUND);
		}
	}

	/**
	 * Tests IntParser::getMaxValue()
	 */
	public function testGetMaxValue()
	{
		$actual = IntParser::getMaxValue();

		switch ($this->architecture)
		{
			case System::ARCHITECTURE_32: $this->assertEquals(IntParser::MAX_INTEGER_32, $actual); break;
			case System::ARCHITECTURE_64: $this->assertEquals(IntParser::MAX_INTEGER_64, $actual); break;

			default:
				$this->fail(self::ARCHITECTURE_NOT_FOUND);
		}
	}

	/**
	 * Tests IntParser::isInteger()
	 */
	public function testIsInteger()
	{
		$this->assertEquals(true, IntParser::isInteger('-1'));
		$this->assertEquals(true, IntParser::isInteger('0'));
		$this->assertEquals(true, IntParser::isInteger('1'));
		$this->assertEquals(false, IntParser::isInteger(' '));
		$this->assertEquals(false, IntParser::isInteger('a'));
		$this->assertEquals(false, IntParser::isInteger('a1'));
		$this->assertEquals(false, IntParser::isInteger('1a'));
		$this->assertEquals(false, IntParser::isInteger('.'));
		$this->assertEquals(false, IntParser::isInteger('1.'));
		$this->assertEquals(false, IntParser::isInteger('.1'));
		$this->assertEquals(false, IntParser::isInteger('1.1'));

		switch ($this->architecture)
		{
			case System::ARCHITECTURE_32:
				$this->assertEquals(true, IntParser::isInteger(IntParser::MIN_INTEGER_32));
				$this->assertEquals(true, IntParser::isInteger(IntParser::MAX_INTEGER_32));
				$this->assertEquals(false, IntParser::isInteger('-2147483649'));
				$this->assertEquals(false, IntParser::isInteger('2147483648'));
				break;

			case System::ARCHITECTURE_64:
				$this->assertEquals(true, IntParser::isInteger(IntParser::MIN_INTEGER_64));
				$this->assertEquals(true, IntParser::isInteger(IntParser::MAX_INTEGER_64));
				$this->assertEquals(false, IntParser::isInteger('-9223372036854775809'));
				$this->assertEquals(false, IntParser::isInteger('9223372036854775808'));
				break;

			default:
				$this->fail(self::ARCHITECTURE_NOT_FOUND);
		}
	}

	/**
	 * Tests IntParser::parseInteger()
	 */
	public function testParseInteger()
	{
		$this->assertEquals(-1, IntParser::parseInteger('-1'));
		$this->assertEquals(0, IntParser::parseInteger('0'));
		$this->assertEquals(1, IntParser::parseInteger('1'));
		$this->assertEquals(null, IntParser::parseInteger(' '));
		$this->assertEquals(null, IntParser::parseInteger('a'));
		$this->assertEquals(null, IntParser::parseInteger('a1'));
		$this->assertEquals(null, IntParser::parseInteger('1a'));
		$this->assertEquals(null, IntParser::parseInteger('.'));
		$this->assertEquals(null, IntParser::parseInteger('1.'));
		$this->assertEquals(null, IntParser::parseInteger('.1'));
		$this->assertEquals(null, IntParser::parseInteger('1.1'));

		switch ($this->architecture)
		{
			case System::ARCHITECTURE_32:
				$this->assertEquals(-2147483648, IntParser::parseInteger(IntParser::MIN_INTEGER_32));
				$this->assertEquals(2147483647, IntParser::parseInteger(IntParser::MAX_INTEGER_32));
				$this->assertEquals(null, IntParser::parseInteger('-2147483649'));
				$this->assertEquals(null, IntParser::parseInteger('2147483648'));
				break;

			case System::ARCHITECTURE_64:
				$this->assertEquals(-9223372036854775808, IntParser::parseInteger(IntParser::MIN_INTEGER_64));
				$this->assertEquals(9223372036854775807, IntParser::parseInteger(IntParser::MAX_INTEGER_64));
				$this->assertEquals(null, IntParser::parseInteger('-9223372036854775809'));
				$this->assertEquals(null, IntParser::parseInteger('9223372036854775808'));
				break;

			default:
				$this->fail(self::ARCHITECTURE_NOT_FOUND);
		}
	}

	/**
	 * Tests IntParser::cap()
	 */
	public function testCap()
	{
		$this->assertEquals(5, IntParser::cap(4, 5, 10));
		$this->assertEquals(5, IntParser::cap(5, 5, 10));
		$this->assertEquals(6, IntParser::cap(6, 5, 10));
		$this->assertEquals(9, IntParser::cap(9, 5, 10));
		$this->assertEquals(10, IntParser::cap(10, 5, 10));
		$this->assertEquals(10, IntParser::cap(11, 5, 10));

		$this->assertEquals(-10, IntParser::cap(-11, -10, -5));
		$this->assertEquals(-10, IntParser::cap(-10, -10, -5));
		$this->assertEquals(-9, IntParser::cap(-9, -10, -5));
		$this->assertEquals(-6, IntParser::cap(-6, -10, -5));
		$this->assertEquals(-5, IntParser::cap(-5, -10, -5));
		$this->assertEquals(-5, IntParser::cap(-4, -10, -5));
	}

	/**
	 * Tests IntParser::capMin()
	 */
	public function testCapMin()
	{
		$this->assertEquals(5, IntParser::capMin(4, 5));
		$this->assertEquals(5, IntParser::capMin(5, 5));
		$this->assertEquals(6, IntParser::capMin(6, 5));

		$this->assertEquals(-4, IntParser::capMin(-4, -5));
		$this->assertEquals(-5, IntParser::capMin(-5, -5));
		$this->assertEquals(-5, IntParser::capMin(-6, -5));
	}

	/**
	 * Tests IntParser::capMax()
	 */
	public function testCapMax()
	{
		$this->assertEquals(5, IntParser::capMin(4, 5));
		$this->assertEquals(5, IntParser::capMin(5, 5));
		$this->assertEquals(6, IntParser::capMin(6, 5));

		$this->assertEquals(-4, IntParser::capMin(-4, -5));
		$this->assertEquals(-5, IntParser::capMin(-5, -5));
		$this->assertEquals(-5, IntParser::capMin(-6, -5));
	}

	/**
	 * Tests IntParser::hasMin()
	 */
	public function testHasMin()
	{
		$this->assertFalse(IntParser::hasMin(4, 5));
		$this->assertTrue(IntParser::hasMin(5, 5));
		$this->assertTrue(IntParser::hasMin(6, 5));

		$this->assertTrue(IntParser::hasMin(-4, -5));
		$this->assertTrue(IntParser::hasMin(-5, -5));
		$this->assertFalse(IntParser::hasMin(-6, -5));
	}

	/**
	 * Tests IntParser::hasMax()
	 */
	public function testHasMax()
	{
		$this->assertTrue(IntParser::hasMax(4, 5));
		$this->assertTrue(IntParser::hasMax(5, 5));
		$this->assertFalse(IntParser::hasMax(6, 5));

		$this->assertFalse(IntParser::hasMax(-4, -5));
		$this->assertTrue(IntParser::hasMax(-5, -5));
		$this->assertTrue(IntParser::hasMax(-6, -5));
	}

	/**
	 * Tests IntParser::hasBetween()
	 */
	public function testHasBetween()
	{
		$this->assertFalse(IntParser::hasBetween(4, 5, 10));
		$this->assertTrue(IntParser::hasBetween(5, 5, 10));
		$this->assertTrue(IntParser::hasBetween(6, 5, 10));
		$this->assertTrue(IntParser::hasBetween(9, 5, 10));
		$this->assertTrue(IntParser::hasBetween(10, 5, 10));
		$this->assertFalse(IntParser::hasBetween(11, 5, 10));

		$this->assertFalse(IntParser::hasBetween(-11, -10, -5));
		$this->assertTrue(IntParser::hasBetween(-10, -10, -5));
		$this->assertTrue(IntParser::hasBetween(-9, -10, -5));
		$this->assertTrue(IntParser::hasBetween(-6, -10, -5));
		$this->assertTrue(IntParser::hasBetween(-5, -10, -5));
		$this->assertFalse(IntParser::hasBetween(-4, -10, -5));
	}

}

