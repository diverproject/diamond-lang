<?php

namespace diamond\lang;

/**
 * Bitwise
 *
 * Essa classe irá possuir um valor inicial zero do qual pode ser trabalhado na lógica de biwise/bitmask.
 * Bitwise é uma lógica computacional do qual trabalhamos com um valor numérico para funcionar como booleano.
 * Para cada bit do valor numérico será considerada um propriedade do qual podemos trabalhar em boolean.
 * Ao definir um parâmetro ele deve ser um valor em potência 2 para simbolizar uma única propriedade.
 *
 * @link https://codeforces.com/blog/entry/18169
 * @author Driw
 */
class Bitwise implements IRawData
{
	/**
	 * @var array
	 */
	public const DEFAULT_PROPERTIES = [
		// Byte
		'0x01',
		'0x02',
		'0x04',
		'0x08',
		'0x10',
		'0x20',
		'0x40',
		'0x80',
		// Short
		'0x0100',
		'0x0200',
		'0x0400',
		'0x0800',
		'0x1000',
		'0x2000',
		'0x4000',
		'0x8000',
		// Int
		'0x10000',
		'0x20000',
		'0x40000',
		'0x80000',
		'0x100000',
		'0x200000',
		'0x400000',
		'0x800000',
		'0x1000000',
		'0x2000000',
		'0x4000000',
		'0x8000000',
		'0x10000000',
		'0x20000000',
		'0x40000000',
		'0x80000000',
	];

	/**
	 * Valor do qual
	 */
	private $value;
	/**
	 * Vetor que irá guardar o nome das propriedades.
	 */
	private $propertieNames;

	/**
	 * Constrói um novo BitWise permitindo definir o nome das propriedades.
	 * @param array $propertiesName [optional] nome das propriedades separados por vírgula.
	 */
	public function __construct(array $propertiesName = self::DEFAULT_PROPERTIES)
	{
		$this->value = 0;
		$this->propertieNames = $propertiesName;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\lang\IRawData::toRawData()
	 */
	public function toRawData()
	{
		return $this->getValue();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\lang\IRawData::fromRawData()
	 */
	public function fromRawData(... $args)
	{
		$this->setValue(IntParser::parseInteger($args[0]));

		if (isset($args[1]) && is_string($args[1]))
			$this->propertieNames = $args[1];
	}

	/**
	 * As propriedades definidas a esse bitwise são guardados nesse valor.
	 * @return int aquisição do valor numérico inteiro das propriedades.
	 */
	public function getValue(): int
	{
		return $this->value;
	}

	/**
	 * Permite definir um valor as propriedades através dos bits de um número inteiro.
	 * @param $value int valor inteiro que irá guardar as propriedades desse bitwise.
	 */
	public function setValue(int $value)
	{
		$this->value = $value;
	}

	/**
	 * Verifica se esse bitwise atende uma ou mais propriedades com o seu valor atual.
	 * Irá verificar cada bit do número passado, considerando apenas os binários 1.
	 * Pode passar mais de um valor utilizando separador | como é usado em java.
	 * @param int $propertie valor da propriedade que será verificada se contém.
	 * @return bool true se contiver todas as propriedades passadas ou false caso contrário.
	 */
	public function has(int $propertie): bool
	{
		return Bitwise::hasPropertie($this->value, $propertie);
	}

	/**
	 * Define uma ou mais propriedades de acordo com a necessidade e objetivo de uso.
	 * Irá verificar cada bit do número passado, considerando apenas os binários 1.
	 * Pode passar mais de um valor utilizando separador | como é usado em java.
	 * Caso a propriedade já tenha sido definida irá continuar como definida.
	 * @param int $propertie valor da propriedade que será definido ao bitwise.
	 */
	public function set(int $propertie)
	{
		$this->value = Bitwise::setPropertie($this->value, $propertie);
	}

	/**
	 * Desconsidera uma ou mais propriedades de acordo com a necessidade e objetivo de uso.
	 * Irá verificar cada bit do número passado, considerando apenas os binários 1.
	 * Pode passar mais de um valor utilizando separador | como é usado em java.
	 * Caso a propriedade não tenha sido definida essa irá continuar sem definir.
	 * @param int $propertie valor da propriedade que será removido do bitwise.
	 */
	public function remove(int $propertie)
	{
		$this->value = Bitwise::removePropertie($this->value, $propertie);
	}

	/**
	 * Constrói uma string que irá guardar todas as propriedades descritivas desse bitwise.
	 * Irá considerar o nome das propriedades passado no construtor ou então caso não
	 * tenha sido definido ou não exista irá usar o padrão BIT{número do bit}.
	 * @return string contendo todas as propriedades definidas separadas por vírgula.
	 */
	public function __toString()
	{
		$bits = [];
		$binary = decbin($this->value);

		for ($i = 0; $i < strlen($binary); $i++)
		{
			if ($binary[$i] == '0')
				continue;

			if (isset($this->propertieNames[$i]))
				array_push($bits, $this->propertieNames[$i]);
			else
				array_push($bits, "BIT$i");
		}

		return implode(', ', $bits);
	}

	/**
	 * Verifica se esse bitwise atende uma ou mais propriedades com o seu valor atual.
	 * Irá verificar cada bit do número passado, considerando apenas os binários 1.
	 * Pode passar mais de um valor utilizando separador | como é usado em java.
	 * @param int $value valor od qual será considerado na verificação de existência.
	 * @param int $propertie valor da propriedade que será verificada se contém.
	 * @return bool true se contiver todas as propriedades passadas ou false caso contrário.
	 */
	public static function hasPropertie($value, $propertie)
	{
		return ($value & $propertie) === $propertie;
	}
	/**
	 * Define uma ou mais propriedades de acordo com a necessidade e objetivo de uso.
	 * Irá verificar cada bit do número passado, considerando apenas os binários 1.
	 * Pode passar mais de um valor utilizando separador | como é usado em java.
	 * Caso a propriedade já tenha sido definida irá continuar como definida.
	 * @param int value valor od qual será alterado conforme a propriedade passada.
	 * @param int propertie valor da propriedade que será definido ao bitwise.
	 * @return int aquisição do valor atualizado com a propriedade definida.
	 */
	public static function setPropertie($value, $propertie)
	{
		return ($value |= $propertie);
	}

	/**
	 * Desconsidera uma ou mais propriedades de acordo com a necessidade e objetivo de uso.
	 * Irá verificar cada bit do número passado, considerando apenas os binários 1.
	 * Pode passar mais de um valor utilizando separador | como é usado em java.
	 * Caso a propriedade não tenha sido definida essa irá continuar sem definir.
	 * @param int value valor od qual será alterado conforme a propriedade passada.
	 * @param int propertie valor da propriedade que será removido do bitwise.
	 * @return int aquisição do valor atualizado com a propriedade removida.
	 */
	public static function removePropertie($value, $propertie)
	{
		return ($value -= $value & $propertie);
	}
}

