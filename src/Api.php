<?php
namespace AmmadKhalid\Cli;
use AmmadKhalid\Cli\interfaces\Api as ApiInterface;

/**
 * Class Api
 *
 * This extends the API class.
 *
 * @package AmmadKhalid\Cli
 */
class Api implements ApiInterface
{
	/**
	 * @var string
	 */
	private $interpreter;
	/**
	 * @var string
	 */
	private $program;
	/**
	 * @var string
	 */
	protected $cli;
	/**
	 * @var array
	 */
	protected $arguments = [];
	/**
	 * @var array
	 */
	protected $positionalArguments = [];
	/**
	 * Argument Dashes.
	 * @var string
	 */
	protected $dashes = "--";

	/**
	 * Positional Argument Dashes.
	 * @var string
	 */
	protected $positionalArgumentDashes = null;

	/**
	 * Python environmental variable name.
	 * @var string
	 */
	private $pythonEnv = "PYTHONIOENCODING";

	/**
	 * for storing shell cli
	 * i.e PYTHONENCODING=UTF-8
	 * @var string
	 */
	public $encoding;

	/**
	 * Api constructor.
	 *
	 * @param string $interpreter
	 * @param string $program
	 */
	public function __construct($interpreter, $program)
	{
		$this->interpreter = $interpreter;
		$this->program = $program;
	}

	/**
	 * This will set Python environmental var.
	 * @param string $encoding
	 *
	 * @return $this
	 */
	public function setPythonEncoding($encoding = 'UTF-8')
	{
		$this->encoding = $this->pythonEnv."=".$encoding;
		return $this;
	}

	/**
	 * This will set dashes for arguments.
	 * For example we have given username
	 * and then it will convert it with --username.
	 *
	 * @param string $dash
	 *
	 * @return \AmmadKhalid\Cli\Api
	 */
	public function setArgumentDashes($dash)
	{
		$this->dashes = $dash;

		return $this;
	}


	/**
	 * same as setArgumentDashes but difference is,
	 * it is for positional arguments.
	 * @param $dash
	 *
	 * @return \AmmadKhalid\Cli\Api
	 */
	public function setPositionalArgumentDashes($dash)
	{
		$this->positionalArgumentDashes = $dash;

		return $this;
	}

	/**
	 * This adds Arguments.
	 *
	 * @param string|array $argument
	 * @param null $value
	 *
	 * @return $this
	 */
	public function addArgument($argument, $value = null)
	{
		if(gettype($argument) != "array")
		{
			$argument = [$argument  =>  $value];
		}

		$this->arguments = array_merge($this->arguments, $argument);

		return $this;
	}

	/**
	 * This will generate command for shell.
	 *
	 * @param  string  $program program name i.e `test --user` where `test` is program.
	 * @param bool $removeDuplicates use to remove duplicate arguments.
	 *
	 * @return string
	 */
	protected function generateShellExec($program, $removeDuplicates = true)
	{
		if($removeDuplicates) {
			/**
			 * Remove all duplicates.
			 */
			$this->positionalArguments = array_unique($this->positionalArguments);
			$this->arguments = array_unique($this->arguments, SORT_REGULAR);
		}

		/**
		 * Apply Program.
		 *
		 * E.g: python main.py or test
		 *
		 */
		$this->cli = $program." ";

		/**
		 * add positional arguments first.
		 */
		foreach ($this->positionalArguments as $arg) {
			$this->cli .= $this->positionalArgumentDashes.$arg." ";
		}

		/**
		 * add positional arguments first.
		 */
		foreach ($this->arguments as $arg => $value) {
			$value = escapeshellarg($value);

			$this->cli .= $this->dashes.$arg." ".$value." ";
		}

		return is_null($this->encoding) ? $this->cli : $this->encoding." ".$this->cli;
	}

	/**
	 * This will give program command to execute.
	 * But only with program name. i.e `pft --user user --password`
	 *
	 * @param bool $removeDuplicates
	 *
	 * @return string
	 */
	public function getProgramCommand($removeDuplicates = false) {
		return $this->generateShellExec($this->program, $removeDuplicates);
	}

	/**
	 * This will give program command to execute with interpreter.
	 * i.e `python3 main.py --user user --password`
	 * @param bool $removeDuplicates
	 *
	 * @return string
	 */
	public function getCommand($removeDuplicates = false)
	{
		return $this->generateShellExec($this->interpreter." ".$this->program, $removeDuplicates);
	}

	/**
	 * add positional argument.
	 * @param $name
	 *
	 * @return $this
	 */
	public function addPositionalArgument($name)
	{
		$this->positionalArguments[] = $name;

		return $this;
	}


}