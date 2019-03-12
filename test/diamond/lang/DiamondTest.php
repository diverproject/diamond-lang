<?php

namespace test\diamond\lang;

use diamond\lang\Diamond;

/**
 * Diamond test case.
 */
class DiamondTest extends AbstractDiamondTest
{
	/**
	 * Tests Diamond::getType()
	 */
	public function testGetType()
	{
		$this->assertEquals(Diamond::getType(true), Diamond::TYPE_BOOLEAN);
		$this->assertEquals(Diamond::getType(false), Diamond::TYPE_BOOLEAN);
		$this->assertEquals(Diamond::getType([]), Diamond::TYPE_ARRAY);
		$this->assertEquals(Diamond::getType(array()), Diamond::TYPE_ARRAY);
		$this->assertEquals(Diamond::getType(1.1), Diamond::TYPE_FLOAT);
		$this->assertEquals(Diamond::getType(1), Diamond::TYPE_INTEGER);
		$this->assertEquals(Diamond::getType(null), Diamond::TYPE_NULL);
		$this->assertEquals(Diamond::getType(new \DateTime()), Diamond::TYPE_OBJECT);
		$this->assertEquals(Diamond::getType('string'), Diamond::TYPE_STRING);
	}

	/**
	 * Tests Diamond::isEnabledParseThrows() and
	 * Tests Diamond::setEnabledParseThrows()
	 */
	public function testEnabledParseThrows()
	{
		Diamond::setEnabledParseThrows(true);
		$this->assertTrue(Diamond::isEnabledParseThrows());

		Diamond::setEnabledParseThrows(false);
		$this->assertFalse(Diamond::isEnabledParseThrows());
	}
}

