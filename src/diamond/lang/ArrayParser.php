<?php

namespace diamond\lang;

use diamond\lang\encrypt\Encrypt;
use diamond\lang\exceptions\ArrayParserException;

/**
 * @see IDataParser
 * @author Driw
 */
class ArrayParser implements IDataParser
{
	/**
	 * @var array
	 */
	private $data;
	/**
	 * @var bool
	 */
	private $throwsable;
	/**
	 * @var Encrypt
	 */
	private $encrypt;

	/**
	 *
	 * @param array $data
	 */
	public function __construct(array &$data = [], ?bool $throwsable = null)
	{
		$this->setData($data);
	}

	/**
	 *
	 * @return array
	 */
	public function getData(): array
	{
		return $this->data;
	}

	/**
	 *
	 * @param array $data
	 */
	public function setData(array $data)
	{
		$this->data = $data;
	}

	/**
	 *
	 * @param array $data
	 */
	public function setDataLinked(array &$data)
	{
		$this->data = &$data;
	}

	/**
	 * @return bool
	 */
	public function isThrowsable(): bool
	{
		return Diamond::isEnabledParseThrows($this->throwsable);
	}

	/**
	 * @param bool $throwsable
	 */
	public function setThrowsable(?bool $throwsable)
	{
		$this->throwsable = $throwsable;
	}

	/**
	 *
	 * @return Encrypt
	 */
	public function getEncrypt(): Encrypt
	{
		return $this->encrypt;
	}

	/**
	 *
	 * @param Encrypt $encrypt
	 */
	public function setEncrypt(Encrypt $encrypt)
	{
		$this->encrypt = $encrypt;
	}

	/**
	 *
	 * @return bool
	 */
	public function isEmpty(): bool
	{
		return $this->count() === 0;
	}

	/**
	 * {@inheritDoc}
	 * @see \Countable::count()
	 */
	public function count()
	{
		return count($this->data);
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::next()
	 */
	public function next()
	{
		next($this->data);
	}

	/**
	 * {@inheritDoc}
	 * @see \\Iterator::valid()
	 */
	public function valid()
	{
		return array_key_exists($this->key(), $this->data);
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::current()
	 */
	public function current()
	{
		return current($this->data);
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::rewind()
	 */
	public function rewind()
	{
		reset($this->data);
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::key()
	 */
	public function key()
	{
		return key($this->data);
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::has()
	 */
	public function has(string $key): bool
	{
		return isset($this->data[$key]);
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::remove()
	 */
	public function remove(string $key): bool
	{
		if (!$this->has($key))
			return false;

		unset($this->data[$key]);
		return true;
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::getValue()
	 */
	public function getValue(string $key)
	{
		if (!$this->has($key))
		{
			if ($this->isThrowsable())
				throw ArrayParserException::newKeyNotFound($key);

			return null;
		}

		return $this->encrypt === null ? $this->data[$key] : $this->encrypt->decrypt(strval($this->data[$key]));
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::setValue()
	 */
	public function setValue(string $key, $value)
	{
		$this->data[$key] = $this->encrypt === null ? $value : $this->encrypt->encrypt(strval($value));
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::()
	 */
	public function getString(string $key): ?string
	{
		if (($value = $this->getValue($key)) === null)
			return $value;

		if (!is_string($value))
		{
			if ($this->isThrowsable())
				throw ArrayParserException::newParseString($key);

			return null;
		}

		return $value;
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::()
	 */
	public function setString(string $key, ?string $value)
	{
		$this->setValue($key, $value);
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::()
	 */
	public function getInt(string $key): ?int
	{
		if (($value = $this->getValue($key)) === null || is_int($value))
			return $value;

		if (($value = IntParser::parseInteger($value, false)) === null)
			if ($this->isThrowsable())
				throw ArrayParserException::newParseInt($key);

		return $value;
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::()
	 */
	public function setInt(string $key, ?int $value)
	{
		$this->setValue($key, $value);
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::()
	 */
	public function getFloat(string $key): ?float
	{
		if (($value = $this->getValue($key)) === null || is_float($value))
			return $value;

		if (($value = FloatParser::parseFloat($value, false)) === null)
			if ($this->isThrowsable())
				throw ArrayParserException::newParseFloat($key);

		return $value;
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::()
	 */
	public function setFloat(string $key, ?float $value)
	{
		$this->setValue($key, $value);
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::()
	 */
	public function getBool(string $key): ?bool
	{
		if (($value = $this->getValue($key)) === null || is_bool($value))
			return $value;

		if (($value = BoolParser::parseBool($value, false)) === null)
			if ($this->isThrowsable())
				throw ArrayParserException::newParseBool($key);

		return $value;
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::()
	 */
	public function setBool(string $key, ?bool $value)
	{
		$this->setValue($key, $value);
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::()
	 */
	public function getArray(string $key): ?array
	{
		if (($value = $this->getValue($key)) === null || is_array($value))
			return $value;

		if (($value = json_decode($value, true)) === null)
			if ($this->isThrowsable())
				throw ArrayParserException::newParseArray($key);

		return $value;
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::()
	 */
	public function setArray(string $key, ?array $value)
	{
		$this->setValue($key, $value);
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::getRawData()
	 */
	public function getRawData(string $key, IRawData $rawData)
	{
		$value = $this->getValue($key);

		try {

			$rawData->fromRawData($value);
			return $value;

		} catch (\Exception $e) {

			if ($this->isThrowsable())
				throw ArrayParserException::newParseObject($key);

			return null;
		}
	}

	/**
	 * {@inheritDoc}
	 * @see IDataParser::setRawData()
	 */
	public function setRawData(string $key, IRawData $value)
	{
		$this->setValue($key, $value->toRawData());
	}

	/**
	 *
	 * @return string
	 */
	public function __toString()
	{
		return json_encode($this->data);
	}
}

