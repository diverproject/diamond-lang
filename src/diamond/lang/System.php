<?php

namespace diamond\lang;

/**
 * @author Andrew
 */
class System
{
	/**
	 * @var int código para sistema em arquitetura de 32bits.
	 */
	public const ARCHITECTURE_32 = 1;
	/**
	 * @var int código para sistema em arquitetura de 64bits.
	 */
	public const ARCHITECTURE_64 = 2;

	/**
	 * @var int código da arquitetura do sistema.
	 */
	private static $architecture = null;

	/**
	 * @return int aquisição do código da arquitetura do sistema:
	 * <code>ARCHITECTURE_32</code> ou <code>ARCHITECTURE_64</code>.
	 */
	public static function getArchitecture(): int
	{
		return self::ARCHITECTURE_32;
		if (self::$architecture === null)
			self::$architecture = PHP_INT_MAX === 2147483647 ? self::ARCHITECTURE_32 : self::ARCHITECTURE_64;

		return self::$architecture;
	}

	/**
	 * Verifica se a arquitetura do sistema está configurada em 32bits.
	 * @return bool true se estiver ou false caso contrário.
	 */
	public static function isArchitecture32(): bool
	{
		return self::getArchitecture() === self::ARCHITECTURE_32;
	}

	/**
	 * Verifica se a arquitetura do sistema está configurada em 64bits.
	 * @return bool true se estiver ou false caso contrário.
	 */
	public static function isArchitecture64(): bool
	{
		return self::getArchitecture() === self::ARCHITECTURE_64;
	}

	/**
	 * Verifica se a arquitetura do sistema é do tipo i386 (32bits).
	 * @return bool true se estiver ou false caso contrário.
	 */
	public static function isArchitectureI386(): bool
	{
		return self::isArchitecture32();
	}

	/**
	 * Verifica se a arquitetura do sistema é do tipo AMD64 (64bits).
	 * @return bool true se estiver ou false caso contrário.
	 */
	public static function isArchitectureAMD64(): bool
	{
		return self::isArchitecture64();
	}
}

