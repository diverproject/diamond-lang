<?php

namespace test\diamond\lang;

use diamond\lang\StringParser;

/**
 * StringParser test case.
 * @see AbstractDiamondTest
 */
class StringParserTest extends AbstractDiamondTest
{
	/**
	 * Tests StringParser::subAfter()
	 */
	public function testSubAfter()
	{
		$this->assertEquals('defg', StringParser::subAfter('abcdefg', 'abc'));
		$this->assertEquals('fg', StringParser::subAfter('abcdefg', 'cde'));
		$this->assertEquals('', StringParser::subAfter('abcdefg', 'efg'));

		$this->assertEquals('abcdefg', StringParser::subAfter('abcdefg', 'abc', false));
		$this->assertEquals('cdefg', StringParser::subAfter('abcdefg', 'cde', false));
		$this->assertEquals('efg', StringParser::subAfter('abcdefg', 'efg', false));

		$this->assertNull(StringParser::subAfter('abcdefg', 'fgh'));
		$this->assertNull(StringParser::subAfter('abcdefg', 'fgh', false));
	}

	/**
	 * Tests StringParser::subBefore()
	 */
	public function testSubBefore()
	{
		$this->assertEquals('abc', StringParser::subBefore('abcdefg', 'abc'));
		$this->assertEquals('abcde', StringParser::subBefore('abcdefg', 'cde'));
		$this->assertEquals('abcdefg', StringParser::subBefore('abcdefg', 'efg'));

		$this->assertEquals('', StringParser::subBefore('abcdefg', 'abc', false));
		$this->assertEquals('ab', StringParser::subBefore('abcdefg', 'cde', false));
		$this->assertEquals('abcd', StringParser::subBefore('abcdefg', 'efg', false));

		$this->assertNull(StringParser::subBefore('abcdefg', 'fgh'));
		$this->assertNull(StringParser::subBefore('abcdefg', 'fgh', false));
	}

	/**
	 * Tests StringParser::startsWith()
	 */
	public function testStartsWith()
	{
		$this->assertTrue(StringParser::startsWith('abcdefg', 'abc'));
		$this->assertTrue(StringParser::startsWith('abcdefg', 'abcdefg'));
		$this->assertFalse(StringParser::startsWith('abcdefg', 'abcdefgh'));
		$this->assertFalse(StringParser::startsWith('abcdefg', 'cde'));
		$this->assertFalse(StringParser::startsWith('abcdefg', 'efg'));
	}

	/**
	 * Tests StringParser::endsWith()
	 */
	public function testEndsWith()
	{
		$this->assertTrue(StringParser::endsWith('abcdefg', 'efg'));
		$this->assertTrue(StringParser::endsWith('abcdefg', 'abcdefg'));
		$this->assertFalse(StringParser::endsWith('abcdefg', 'abcdefgh'));
		$this->assertFalse(StringParser::endsWith('abcdefg', 'abc'));
		$this->assertFalse(StringParser::endsWith('abcdefg', 'cde'));
	}

	/**
	 * Tests StringParser::contains()
	 */
	public function testContains()
	{
		$this->assertTrue(StringParser::contains('abcdefg', 'abc'));
		$this->assertTrue(StringParser::contains('abcdefg', 'efg'));
		$this->assertTrue(StringParser::contains('abcdefg', 'bcdef'));
		$this->assertTrue(StringParser::contains('abcdefg', 'abcdefg'));
		$this->assertFalse(StringParser::contains('abcdefg', ' abc'));
		$this->assertFalse(StringParser::contains('abcdefg', 'efgh'));
	}

	/**
	 * Tests StringParser::capLength()
	 */
	public function testCapLength()
	{
		$this->assertEquals('abcdef', StringParser::capLength('abcdefg', 6));
		$this->assertEquals('abcdef', StringParser::capLength('abcdef', 6));
		$this->assertEquals('abcde', StringParser::capLength('abcde', 6));
	}

	/**
	 * Tests StringParser::hasMinLength()
	 */
	public function testHasMinLength()
	{
		$this->assertTrue(StringParser::hasMinLength('abcdef', 5));
		$this->assertTrue(StringParser::hasMinLength('abcdef', 6));
		$this->assertFalse(StringParser::hasMinLength('abcdef', 7));
	}

	/**
	 * Tests StringParser::hasMaxLength()
	 */
	public function testHasMaxLength()
	{
		$this->assertFalse(StringParser::hasMaxLength('abcdef', 5));
		$this->assertTrue(StringParser::hasMaxLength('abcdef', 6));
		$this->assertTrue(StringParser::hasMaxLength('abcdef', 7));
	}

	/**
	 * Tests StringParser::hasBetweenLength()
	 */
	public function testHasBetweenLength()
	{
		$this->assertTrue(StringParser::hasBetweenLength('abcde', 3, 6));
		$this->assertTrue(StringParser::hasBetweenLength('abcdef', 3, 6));
		$this->assertFalse(StringParser::hasBetweenLength('abcdefg', 3, 6));

		$this->assertFalse(StringParser::hasBetweenLength('ab', 3, 6));
		$this->assertTrue(StringParser::hasBetweenLength('abc', 3, 6));
		$this->assertTrue(StringParser::hasBetweenLength('abcd', 3, 6));
	}

	/**
	 * Tests StringParser::isEmpty()
	 */
	public function testIsEmpty()
	{
		$this->assertTrue(StringParser::isEmpty(null));
		$this->assertTrue(StringParser::isEmpty(''));
		$this->assertFalse(StringParser::isEmpty(' '));
		$this->assertFalse(StringParser::isEmpty('	'));
	}
}

