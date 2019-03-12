<?php

namespace test\diamond\lang;

use diamond\lang\ArrayParser;
use diamond\lang\Bitwise;

/**
 * ArrayParser test case.
 */
class ArrayParserTest extends AbstractDiamondTest
{
	/**
	 * @var array
	 */
	private $baseArray;
	/**
	 * @var ArrayParser
	 */
	private $arrayParser;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->baseArray = [
			'genericValue' => '1',
			'string' => 'a string value',
			'int' => '123456',
			'float' => '123.456',
			'bool' => 'yes',
			'array' => [
				'a', 'random', 'string', 'values', 'array'
			],
			'bitwise' => '3',
			'removable' => 'hahaha'
		];
		$this->arrayParser = new ArrayParser($this->baseArray);
		$this->arrayParser->setThrowsable(false);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->arrayParser = null;

		parent::tearDown();
	}

	/**
	 * Tests ArrayParser->isEmpty() and
	 * Tests ArrayParser->getData() and
	 * Tests ArrayParser->setData()
	 */
	public function testGetterSetterData()
	{
		$this->assertFalse($this->arrayParser->isEmpty());

		$this->arrayParser->setData($this->baseArray);
		$this->assertFalse($this->arrayParser->isEmpty());
		$this->assertEquals($this->baseArray, $this->arrayParser->getData());

		$this->arrayParser->setDataLinked($this->baseArray);
		$this->assertFalse($this->arrayParser->isEmpty());
		$this->assertEquals($this->baseArray, $this->arrayParser->getData());
	}

	/**
	 * Tests ArrayParser->isThrowsable() and
	 * Tests ArrayParser->setThrowsable()
	 */
	public function testIsSetterThrowsable()
	{
		$this->arrayParser->setThrowsable(true);
		$this->assertTrue($this->arrayParser->isThrowsable());

		$this->arrayParser->setThrowsable(false);
		$this->assertFalse($this->arrayParser->isThrowsable());
	}

	/**
	 * Tests ArrayParser->count()
	 */
	public function testCount()
	{
		$this->assertEquals(count($this->baseArray), $this->arrayParser->count());
	}

	/**
	 * Tests ArrayParser->next() and
	 * Tests ArrayParser->valid() and
	 * Tests ArrayParser->current() and
	 * Tests ArrayParser->rewind() and
	 * Tests ArrayParser->key() and
	 */
	public function testIterator()
	{
		foreach ($this->arrayParser as $key => $value)
			$this->assertEquals($this->baseArray[$key], $value);
	}

	/**
	 * Tests ArrayParser->has()
	 */
	public function testHas()
	{
		$this->assertTrue($this->arrayParser->has('removable'));
		$this->assertTrue($this->arrayParser->remove('removable'));
		$this->assertFalse($this->arrayParser->has('removable'));
	}

	/**
	 * Tests ArrayParser->getValue() and
	 * Tests ArrayParser->setValue()
	 */
	public function testGetterSetterValue()
	{
		$this->arrayParser->setValue('getValue', true);
		$this->assertEquals(true, $this->arrayParser->getValue('getValue'));

		$this->arrayParser->setValue('getValue', 'getValue');
		$this->assertEquals('getValue', $this->arrayParser->getValue('getValue'));
	}

	/**
	 * Tests ArrayParser->getString() and
	 * Tests ArrayParser->setString()
	 */
	public function testGetterSetterString()
	{
		$key = 'string';
		$this->assertEquals('a string value', $this->arrayParser->getString($key));

		$this->arrayParser->setString($key, 'another string value');
		$this->assertEquals('another string value', $this->arrayParser->getString($key));

		$this->arrayParser->setString($key, null);
		$this->assertNull($this->arrayParser->getString($key));
	}

	/**
	 * Tests ArrayParser->getInt() and
	 * Tests ArrayParser->setInt()
	 */
	public function testGetterSetterInt()
	{
		$key = 'int';
		$this->assertEquals(123456, $this->arrayParser->getInt($key));

		$this->arrayParser->setInt($key, 654231);
		$this->assertEquals(654231, $this->arrayParser->getInt($key));

		$this->arrayParser->setInt($key, null);
		$this->assertNull($this->arrayParser->getInt($key));
		$this->assertNull($this->arrayParser->getInt('string'));
	}

	/**
	 * Tests ArrayParser->getFloat() and
	 * Tests ArrayParser->setFloat()
	 */
	public function testGetterSetterFloat()
	{
		$key = 'float';
		$this->assertEquals(123.456, $this->arrayParser->getFloat($key));

		$this->arrayParser->setFloat($key, 654.231);
		$this->assertEquals(654.231, $this->arrayParser->getFloat($key));

		$this->arrayParser->setFloat($key, null);
		$this->assertNull($this->arrayParser->getFloat($key));
		$this->assertNull($this->arrayParser->getFloat('string'));
	}

	/**
	 * Tests ArrayParser->getBool() and
	 * Tests ArrayParser->setBool()
	 */
	public function testGetterSetterBool()
	{
		$key = 'bool';
		$this->assertTrue($this->arrayParser->getBool($key));

		$this->arrayParser->setBool($key, false);
		$this->assertFalse($this->arrayParser->getBool($key));

		$this->arrayParser->setBool($key, null);
		$this->assertNull($this->arrayParser->getBool($key));
		$this->assertNull($this->arrayParser->getBool('string'));
	}

	/**
	 * Tests ArrayParser->getArray() and
	 * Tests ArrayParser->setArray()
	 */
	public function testGetterSetterArray()
	{
		$key = 'array';
		$this->assertEquals($this->baseArray['array'], $this->arrayParser->getArray($key));

		$this->arrayParser->setArray($key, ['unic value']);
		$this->assertEquals(['unic value'], $this->arrayParser->getArray($key));

		$this->arrayParser->setArray($key, null);
		$this->assertNull($this->arrayParser->getArray($key));
		$this->assertNull($this->arrayParser->getArray('string'));
	}

	/**
	 * Tests ArrayParser->getRawData() and
	 * Tests ArrayParser->setRawData()
	 */
	public function testGetterSetterRawData()
	{
		$key = 'bitwise';
		$bitwise = new Bitwise();

		$this->assertEquals(0x03, $this->arrayParser->getRawData($key, $bitwise));
		$this->assertEquals(0x03, $bitwise->getValue());

		$bitwise->setValue(0x33);
		$this->arrayParser->setRawData($key, $bitwise);
		$this->assertEquals(0x33, $this->arrayParser->getRawData($key, $bitwise));
		$this->assertEquals(0x33, $bitwise->getValue());
	}
}

