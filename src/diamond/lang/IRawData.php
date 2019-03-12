<?php

namespace diamond\lang;

/**
 * @author Andrew
 */
interface IRawData
{
	/**
	 *
	 * @return mixed
	 */
	public function toRawData();

	/**
	 *
	 * @param mixed ...$args
	 */
	public function fromRawData(... $args);
}

