<?php

namespace diamond\lang;

/**
 * @see Countable
 * @see Iterator
 * @author Andrew
 */
interface IDataParser extends \Countable, \Iterator
{
	/**
	 *
	 * @param mixed $key
	 * @return bool
	 */
	public function has(string $key): bool;

	/**
	 *
	 * @param mixed $key
	 * @return bool
	 */
	public function remove(string $key): bool;

	/**
	 *
	 * @param string $key
	 */
	public function getValue(string $key);

	/**
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function setValue(string $key, $value);

	/**
	 *
	 * @param string $key
	 * @return string|NULL
	 */
	public function getString(string $key): ?string;

	/**
	 *
	 * @param string $key
	 * @param string $value
	 */
	public function setString(string $key, ?string $value);

	/**
	 *
	 * @param string $key
	 * @return int|NULL
	 */
	public function getInt(string $key): ?int;

	/**
	 *
	 * @param string $key
	 * @param int $value
	 */
	public function setInt(string $key, ?int $value);

	/**
	 *
	 * @param string $key
	 * @return float|NULL
	 */
	public function getFloat(string $key): ?float;

	/**
	 *
	 * @param string $key
	 * @param float $value
	 */
	public function setFloat(string $key, ?float $value);

	/**
	 *
	 * @param string $key
	 * @return bool|NULL
	 */
	public function getBool(string $key): ?bool;

	/**
	 *
	 * @param string $key
	 * @param bool $value
	 */
	public function setBool(string $key, ?bool $value);

	/**
	 *
	 * @param string $key
	 * @return array|NULL
	 */
	public function getArray(string $key): ?array;

	/**
	 *
	 * @param string $key
	 * @param array $value
	 */
	public function setArray(string $key, ?array $value);

	/**
	 *
	 * @param string $key
	 */
	public function getRawData(string $key, IRawData $rawData);

	/**
	 *
	 * @param string $key
	 * @param IRawData $value
	 */
	public function setRawData(string $key, IRawData $value);
}

