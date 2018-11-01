<?php
namespace AmmadKhalid\Cli;

use Symfony\Component\Process\Process;

/**
 * Class PyApi
 *
 * Which uses the Symfony Process.
 *
 * @package AmmadKhalid\Cli
 */
class PyApi extends Api
{
	/**
	 * Checks and gives command.
	 * For example any command is given then it will only give it.
	 * Otherwise it will auto generate it and then it will give.
	 *
	 * @param null $command
	 * @param bool $useInterpreter
	 *
	 * @return null|string
	 */
	protected function checkCommand($command = null, $useInterpreter = False)
	{
		if(is_null($command)) {
			$command = !$useInterpreter ? $this->getProgramCommand() : $this->getCommand();
		}

		return $command;
	}

	/**
	 * It will run command instantly and will give output.
	 *
	 * @param      $command
	 * @param bool $useInterpreter
	 * params are for checkCommand
	 * @return string
	 */
	public function run($command = null, $useInterpreter = False)
	{
		$command = $this->checkCommand($command, $useInterpreter);

		$process = new Process($command);
		$process->mustRun();

		return $process->getOutput();
	}

	/**
	 * This will command in background only.
	 * will not give any output.
	 *
	 * @param      $command
	 *
	 * @param bool $useInterpreter
	 *
	 * @return null
	 */
	public function runInBg($command = null, $useInterpreter = False)
	{
		$command = $this->checkCommand($command, $useInterpreter);

		$process = new Process($command);
		return $process->start();
	}

}