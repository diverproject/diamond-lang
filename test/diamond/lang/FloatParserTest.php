<?php

namespace test\diamond\lang;

use diamond\lang\FloatParser;
use diamond\lang\System;

/**
 * FloatParser test case.
 */
class FloatParserTest extends AbstractDiamondTest
{
	/**
	 * Tests FloatParser::getMinValue()
	 */
	public function testGetMinValue()
	{
		switch ($this->architecture)
		{
			case System::ARCHITECTURE_32:
				$this->assertEquals(FloatParser::MIN_FLOAT_32, FloatParser::getMinValue());
				break;

			case System::ARCHITECTURE_64:
				$this->assertEquals(FloatParser::MIN_FLOAT_64, FloatParser::getMinValue());
				break;
		}
	}

	/**
	 * Tests FloatParser::getMaxValue()
	 */
	public function testGetMaxValue()
	{
		switch ($this->architecture)
		{
			case System::ARCHITECTURE_32:
				$this->assertEquals(FloatParser::MAX_FLOAT_32, FloatParser::getMaxValue());
				break;

			case System::ARCHITECTURE_64:
				$this->assertEquals(FloatParser::MAX_FLOAT_64, FloatParser::getMaxValue());
				break;
		}
	}

	/**
	 * Tests FloatParser::getPrecision()
	 */
	public function testGetPrecision()
	{
		switch ($this->architecture)
		{
			case System::ARCHITECTURE_32:
				$this->assertEquals('7', FloatParser::getPrecision());
				break;

			case System::ARCHITECTURE_64:
				$this->assertEquals('15', FloatParser::getPrecision());
				break;
		}
	}

	/**
	 * Tests FloatParser::isFloat()
	 */
	public function testIsFloat()
	{
		$this->assertTrue(FloatParser::isFloat('1'));
		$this->assertTrue(FloatParser::isFloat('.1'));
		$this->assertTrue(FloatParser::isFloat('1.1'));
		$this->assertTrue(FloatParser::isFloat('1.1e-1'));
		$this->assertTrue(FloatParser::isFloat('1.1e+1'));

		$this->assertFalse(FloatParser::isFloat(' 1'));
		$this->assertFalse(FloatParser::isFloat('1 '));
		$this->assertFalse(FloatParser::isFloat('1e'));
		$this->assertFalse(FloatParser::isFloat('e1'));
		$this->assertFalse(FloatParser::isFloat('1.e'));
		$this->assertFalse(FloatParser::isFloat('1.1e1'));
	}

	/**
	 * Tests FloatParser::parseFloat()
	 */
	public function testParseFloat()
	{
		$this->assertEquals(1, FloatParser::parseFloat('1'));
		$this->assertEquals(.1, FloatParser::parseFloat('.1'));
		$this->assertEquals(1.1, FloatParser::parseFloat('1.1'));
		$this->assertEquals(0.12, FloatParser::parseFloat('1.2e-1'));
		$this->assertEquals(13, FloatParser::parseFloat('1.3e+1'));

		$this->assertNull(FloatParser::parseFloat(' 1'));
		$this->assertNull(FloatParser::parseFloat('1 '));
		$this->assertNull(FloatParser::parseFloat('1e'));
		$this->assertNull(FloatParser::parseFloat('e1'));
		$this->assertNull(FloatParser::parseFloat('1.e'));
		$this->assertNull(FloatParser::parseFloat('1.1e1'));
	}

	/**
	 * Tests FloatParser::cap()
	 */
	public function testCap()
	{
		$this->assertEquals(1.01, FloatParser::cap(1.00, 1.01, 1.05));
		$this->assertEquals(1.01, FloatParser::cap(1.01, 1.01, 1.05));
		$this->assertEquals(1.02, FloatParser::cap(1.02, 1.01, 1.05));
		$this->assertEquals(1.04, FloatParser::cap(1.04, 1.01, 1.05));
		$this->assertEquals(1.05, FloatParser::cap(1.05, 1.01, 1.05));
		$this->assertEquals(1.05, FloatParser::cap(1.06, 1.01, 1.05));

		$this->assertEquals(-1.05, FloatParser::cap(-1.06, -1.05, -1.01));
		$this->assertEquals(-1.05, FloatParser::cap(-1.05, -1.05, -1.01));
		$this->assertEquals(-1.04, FloatParser::cap(-1.04, -1.05, -1.01));
		$this->assertEquals(-1.01, FloatParser::cap(-1.00, -1.05, -1.01));
		$this->assertEquals(-1.01, FloatParser::cap(-1.01, -1.05, -1.01));
		$this->assertEquals(-1.02, FloatParser::cap(-1.02, -1.05, -1.01));

		$this->assertEquals(-1.01, FloatParser::cap(-1.02, -1.01, 1.05));
		$this->assertEquals(-1.01, FloatParser::cap(-1.01, -1.01, 1.05));
		$this->assertEquals(-1.00, FloatParser::cap(-1.00, -1.01, 1.05));
		$this->assertEquals(1.04, FloatParser::cap(1.04, -1.01, 1.05));
		$this->assertEquals(1.05, FloatParser::cap(1.05, -1.01, 1.05));
		$this->assertEquals(1.05, FloatParser::cap(1.06, -1.01, 1.05));
	}

	/**
	 * Tests FloatParser::capMin()
	 */
	public function testCapMin()
	{
		$this->assertEquals(1.01, FloatParser::capMin(1.00, 1.01));
		$this->assertEquals(1.01, FloatParser::capMin(1.01, 1.01));
		$this->assertEquals(1.02, FloatParser::capMin(1.02, 1.01));

		$this->assertEquals(-1.00, FloatParser::capMin(-1.00, -1.01));
		$this->assertEquals(-1.01, FloatParser::capMin(-1.01, -1.01));
		$this->assertEquals(-1.01, FloatParser::capMin(-1.02, -1.01));
	}

	/**
	 * Tests FloatParser::capMax()
	 */
	public function testCapMax()
	{
		$this->assertEquals(1.00, FloatParser::capMax(1.00, 1.01));
		$this->assertEquals(1.01, FloatParser::capMax(1.01, 1.01));
		$this->assertEquals(1.01, FloatParser::capMax(1.02, 1.01));

		$this->assertEquals(-1.01, FloatParser::capMax(-1.00, -1.01));
		$this->assertEquals(-1.01, FloatParser::capMax(-1.01, -1.01));
		$this->assertEquals(-1.02, FloatParser::capMax(-1.02, -1.01));
	}

	/**
	 * Tests FloatParser::hasMin()
	 */
	public function testHasMin()
	{
		$this->assertTrue(FloatParser::hasMin(1.02, 1.01));
		$this->assertTrue(FloatParser::hasMin(1.01, 1.01));
		$this->assertFalse(FloatParser::hasMin(1.00, 1.01));

		$this->assertTrue(FloatParser::hasMin(-1.00, -1.01));
		$this->assertTrue(FloatParser::hasMin(-1.01, -1.01));
		$this->assertFalse(FloatParser::hasMin(-1.02, -1.01));
	}

	/**
	 * Tests FloatParser::hasMax()
	 */
	public function testHasMax()
	{
		$this->assertTrue(FloatParser::hasMax(1.00, 1.01));
		$this->assertTrue(FloatParser::hasMax(1.01, 1.01));
		$this->assertFalse(FloatParser::hasMax(1.02, 1.01));

		$this->assertTrue(FloatParser::hasMax(-1.02, -1.01));
		$this->assertTrue(FloatParser::hasMax(-1.01, -1.01));
		$this->assertFalse(FloatParser::hasMax(-1.00, -1.01));
	}

	/**
	 * Tests FloatParser::hasBetween()
	 */
	public function testHasBetween()
	{
		$this->assertTrue(FloatParser::hasBetween(1.03, 1.01, 1.05));
		$this->assertTrue(FloatParser::hasBetween(1.01, 1.01, 1.05));
		$this->assertTrue(FloatParser::hasBetween(1.05, 1.01, 1.05));

		$this->assertTrue(FloatParser::hasBetween(-1.03, -1.05, -1.01));
		$this->assertTrue(FloatParser::hasBetween(-1.05, -1.05, -1.01));
		$this->assertTrue(FloatParser::hasBetween(-1.01, -1.05, -1.01));

		$this->assertFalse(FloatParser::hasBetween(1.00, 1.01, 1.05));
		$this->assertFalse(FloatParser::hasBetween(1.06, 1.01, 1.05));
		$this->assertFalse(FloatParser::hasBetween(-1.06, -1.05, -1.01));
		$this->assertFalse(FloatParser::hasBetween(-1.00, -1.05, -1.01));
	}
}

