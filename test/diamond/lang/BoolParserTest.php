<?php

namespace test\diamond\lang;

use diamond\lang\BoolParser;

/**
 * BoolParser test case.
 */
class BoolParserTest extends AbstractDiamondTest
{
	/**
	 * Tests BoolParser::isBool()
	 */
	public function testIsBool()
	{
		$true = [1, '1', true, 'yes', 'true', 'on'];
		$false = [0, '0', false, 'no', 'false', 'off'];

		foreach ($true as $bool)
			$this->assertEquals(true, BoolParser::isBool($bool));

		foreach ($false as $bool)
			$this->assertEquals(true, BoolParser::isBool($bool));
	}

	/**
	 * Tests BoolParser::isBool()
	 */
	public function testIsNotBool()
	{
		$this->assertEquals(false, BoolParser::isBool('sim'));
		$this->assertEquals(false, BoolParser::isBool(2));
	}

	/**
	 * Tests BoolParser::parseBool()
	 */
	public function testParseBool()
	{
		$true = [1, '1', true, 'yes', 'true', 'on'];
		$false = [0, '0', false, 'no', 'false', 'off'];

		foreach ($true as $bool)
			$this->assertEquals(true, BoolParser::parseBool($bool));

		foreach ($false as $bool)
			$this->assertEquals(false, BoolParser::parseBool($bool));
	}

}

