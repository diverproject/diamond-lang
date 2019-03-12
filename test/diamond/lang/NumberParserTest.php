<?php

namespace test\diamond\lang;

use diamond\lang\NumberParser;

/**
 * NumberParser test case.
 * @see AbstractDiamondTest
 */
class NumberParserTest extends AbstractDiamondTest
{
	/**
	 * Tests NumberParser::hasFloatFormat()
	 */
	public function testHasFloatFormat()
	{
		$dotFloats = ['1.', '.1', '1.1', '-1.', '-.1', '-1.1', '1.1e+1', '1.1e-1'];
		$commaFloats = ['1,', ',1', '1,1', '-1,', '-,1', '-1,1', '1,1e+1', '1,1e-1'];
		$dotNotFloats = ['.', 'a.', '1a.', 'a1.', '.a', '.a1', '.1a', '1.1+e1', '1.1-e1', ' 1.', '.1 '];
		$commaNotFloats = [',', 'a,', '1a,', 'a1,', ',a', ',a1', ',1a', '1,1+e1', '1,1-e1', ' 1,', ',1 '];

		foreach ($dotFloats as $float)
		{
			$this->assertTrue(NumberParser::hasFloatFormat($float, NumberParser::FLOAT_TYPE));
			$this->assertTrue(NumberParser::hasFloatFormat($float, NumberParser::FLOAT_DOT_TYPE));
			$this->assertFalse(NumberParser::hasFloatFormat($float, NumberParser::FLOAT_COMMA_TYPE));
		}

		foreach ($commaFloats as $float)
		{
			$this->assertTrue(NumberParser::hasFloatFormat($float, NumberParser::FLOAT_TYPE));
			$this->assertFalse(NumberParser::hasFloatFormat($float, NumberParser::FLOAT_DOT_TYPE));
			$this->assertTrue(NumberParser::hasFloatFormat($float, NumberParser::FLOAT_COMMA_TYPE));
		}

		foreach ($dotNotFloats as $float)
		{
			$this->assertFalse(NumberParser::hasFloatFormat($float, NumberParser::FLOAT_TYPE));
			$this->assertFalse(NumberParser::hasFloatFormat($float, NumberParser::FLOAT_DOT_TYPE));
			$this->assertFalse(NumberParser::hasFloatFormat($float, NumberParser::FLOAT_COMMA_TYPE));
		}

		foreach ($commaNotFloats as $float)
		{
			$this->assertFalse(NumberParser::hasFloatFormat($float, NumberParser::FLOAT_TYPE));
			$this->assertFalse(NumberParser::hasFloatFormat($float, NumberParser::FLOAT_DOT_TYPE));
			$this->assertFalse(NumberParser::hasFloatFormat($float, NumberParser::FLOAT_COMMA_TYPE));
		}
	}

	/**
	 * Tests NumberParser::hasIntFormat()
	 */
	public function testHasIntFormat()
	{
		$numberInts = ['1', '111', '-1', '-111'];
		$numberNotInts = [' 1 ', '1 ', ' 1', 'a', '1a', 'a1', '-1a'];

		foreach ($numberInts as $int)
			$this->assertTrue(NumberParser::hasIntFormat($int));

		foreach ($numberNotInts as $int)
			$this->assertFalse(NumberParser::hasIntFormat($int));
	}

	/**
	 * Tests NumberParser::parseFloatPrecision()
	 */
	public function testParseFloatPrecision()
	{
		$this->assertTrue(NumberParser::parseFloatPrecision('0.00000', 7));
		$this->assertTrue(NumberParser::parseFloatPrecision('0.000000', 7));
		$this->assertFalse(NumberParser::parseFloatPrecision('0.0000000', 7));

		$this->assertTrue(NumberParser::parseFloatPrecision('00000.0', 7));
		$this->assertTrue(NumberParser::parseFloatPrecision('000000.0', 7));
		$this->assertFalse(NumberParser::parseFloatPrecision('0000000.0', 7));
	}

	/**
	 * Tests NumberParser::parseIntegerLength()
	 */
	public function testParseIntegerLength()
	{
		$this->assertFalse(NumberParser::parseIntegerLength('-2147483649', -2147483648, 2147483647));
		$this->assertTrue(NumberParser::parseIntegerLength('-2147483648', -2147483648, 2147483647));
		$this->assertTrue(NumberParser::parseIntegerLength('-2147483647', -2147483648, 2147483647));

		$this->assertTrue(NumberParser::parseIntegerLength('2147483646', -2147483648, 2147483647));
		$this->assertTrue(NumberParser::parseIntegerLength('2147483647', -2147483648, 2147483647));
		$this->assertFalse(NumberParser::parseIntegerLength('2147483648', -2147483648, 2147483647));
	}
}

