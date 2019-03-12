<?php

namespace diamond\lang\utils
{
	/**
	 * @author Andrew
	 */
	class GlobalFunctions
	{
		/**
		 *
		 */
		private function __construct() { }

		/**
		 *
		 */
		public static function load() { }
	}
}

namespace
{
	/**
	 * @return string acquisition of machine timestamp considering milliseconds.
	 */
	function now(): string
	{
		$microtime = microtime();
		$microtimeData = explode(' ', $microtime);
		$seconds = intval($microtimeData[1]);
		$milliseconds = intval(floatval($microtimeData[0]) * 1000);

		return sprintf('%d%03d', $seconds, $milliseconds);
	}

	/**
	 * Format a time of milliseconds on way more readable.
	 * @param int $milleseconds amount of milliseconds to be formatted.
	 * @return string acquisition of string with time formatted.
	 */
	function strms(int $milleseconds): string
	{
		if ($milleseconds >= 1000)
			return sprintf('%ss e %03dms', intval($milleseconds / 1000), $milleseconds % 1000);

		return sprintf('%03dms', $milleseconds);
	}

	/**
	 * @param float $min valor mínimo do qual deve ser gerado.
	 * @param float $max valor máximo do qual deve ser gerado.
	 * @param int $decimals quantidade de casas decimais.
	 * @return float valor numérico flutuante aleatório.
	 */
	function frand(float $min, float $max, int $decimals = 0): float
	{
		$scale = pow(10, $decimals);

		return mt_rand($min * $scale, $max * $scale) / $scale;
	}

	/**
	 * @param int $floatPrecision number of precision of float randomic value.
	 * @return float acquisition of a float number with specified precision.
	 */
	function frand2(int $floatPrecision = FloatParser::FLOAT_PRECISION_32): float
	{
		$precision = rand(0, $floatPrecision);
		$decimalPrecision = $floatPrecision - $precision;
		$integer = rand(0, pow(10, $precision));
		$decimal = rand(0, pow(10, $decimalPrecision));

		return floatval(sprintf('%0'.$precision.'d.%0'.($decimalPrecision).'d', $integer, $decimal));
	}

	/**
	 * Retorna o nome de uma classe sem considerar o seu 'package' (namepsace).
	 * @param mixed $value referência do valor do qual deseja saber o nome da classe.
	 * @return null|string aquisição do nome da classe ou null se não for um objeto/classe.
	 */
	function nameOf($value): ?string
	{
		if (is_object($value))
			$path = explode('\\', get_class($value));
		else if (is_string($value))
			$path = explode('\\', $value);
		else
			return null;

		return array_pop($path);
	}

	/**
	 * Retorna o namespace de uma classe através de um objeto informado.
	 * @param mixed $value referência do valor do qual deseja saber o nome da classe.
	 * @return null|string aquisição do nome da classe ou null se não for um objeto/classe.
	 */
	function namespaceOf($value): ?string
	{
		if (is_object($value))
			return (new \ReflectionObject($value))->getNamespaceName();

		if (is_string($value))
		{
			$namespace = substr($value, 0, strrpos($value, '\\'));
			return $namespace;
		}

		return null;
	}
	/**
	 * jTraceEx() - provide a Java style exception trace
	 * @param $exception
	 * @param $seen      - array passed to recursive calls to accumulate trace lines already seen
	 *                     leave as NULL when calling this function
	 * @return array of strings, one entry per trace line
	 */
	function jTraceEx(\Throwable $e, ?array $seen = null): array
	{
		$starter = $seen ? 'Caused by: ' : '';
		$result = [];

		if (!$seen)
			$seen = [];

		$trace = $e->getTrace();
		$prev = $e->getPrevious();
		$result[] = sprintf('%s%s: %s', $starter, get_class($e), $e->getMessage());
		$file = $e->getFile();
		$line = $e->getLine();

		while (true)
		{
			$current = "$file:$line";

			if (is_array($seen) && in_array($current, $seen))
			{
				$result[] = sprintf(' ... %d more', count($trace) + 1);
				break;
			}

			$result[] = sprintf(' at %s%s%s(%s%s%s)', count($trace) && array_key_exists('class', $trace [0]) ? str_replace('\\', '.', $trace [0] ['class']) : '', count($trace) && array_key_exists('class', $trace [0]) && array_key_exists('function', $trace [0]) ? '.' : '', count($trace) && array_key_exists('function', $trace [0]) ? str_replace('\\', '.', $trace [0] ['function']) : '(main)', $line === null ? $file : basename($file), $line === null ? '' : ':', $line === null ? '' : $line);

			if (is_array($seen))
				$seen [] = "$file:$line";

			if (!count($trace))
				break;

			$file = array_key_exists('file', $trace [0]) ? $trace [0] ['file'] : 'Unknown Source';
			$line = array_key_exists('file', $trace [0]) && array_key_exists('line', $trace [0]) && $trace [0] ['line'] ? $trace [0] ['line'] : null;
			array_shift($trace);
		}

		$result = join(PHP_EOL, $result);

		if ($prev)
			$result .= PHP_EOL.jTraceEx($prev, $seen);

		return explode(PHP_EOL, $result);
	}

	/**
	 * Create needed folders to create a valid path.
	 * @param string $path disk path of folder to be created.
	 * @return bool true if was created or false otherwise.
	 */
	function createPath(string $path): bool
	{
		if (is_dir($path))
			return true;

		$prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
		$return = createPath($prev_path);

		return ($return && is_writable($prev_path)) ? mkdir($path) : false;
	}

	/**
	 * Add a file content in format of a log system considering:
	 * @param string $filepath the path of file to save log message.
	 * @param string $message log message to include on file informed.
	 * @param bool $utf8decode [optional] use utf8 decode message (default: true).
	 */
	function filelog(string $filepath, string $message, bool $utf8decode = true): bool
	{
		$pathinfo = pathinfo($filepath);

		if (!file_exists($pathinfo ['dirname']))
			if (!createPath($pathinfo ['dirname']))
				return false;

		if ($handle = fopen($filepath, 'a'))
		{
			if (flock($handle, LOCK_EX))
			{
				fwrite($handle, ($utf8decode ? utf8_decode($message) : $message) . PHP_EOL);
				flock($handle, LOCK_UN);
				fclose($handle);
			}
		}

		return true;
	}

	/**
	 * Format a string using arguments informed: first is the format and the others is parameters.
	 * @return string acquisition of string with formatted by arguments informed.
	 */
	function format(): string
	{
		$args = func_get_args();

		if (is_array($args[0]))
			$args = $args[0];

		return vsprintf($args[0], array_slice($args, 1));
	}

	/**
	 * @param mixed $target object or value to show data content.
	 */
	function pre($target): void
	{
		echo '<pre>' ,var_export($target), '</pre>';
	}

	/**
	 * @param mixed $value value to check if is null.
	 * @param mixed $default what return if value is null.
	 * @return mixed value is isn't null or default otherwise.
	 */
	function nvl($value, $default)
	{
		return $value === null ? $default : $value;
	}

	/**
	 * @param bool $bool boolean condition to check what do.
	 * @param mixed $true what return if condition was true.
	 * @param mixed $false what return if condition was false.
	 * @return mixed value informed on true or false depending on condition.
	 */
	function ternary(bool $bool, $true, $false)
	{
		return $bool ? $true : $false;
	}
}

