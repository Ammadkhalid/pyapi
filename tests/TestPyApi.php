<?php


use AmmadKhalid\Cli\PyApi;
use Ammadkhalid\Cli\Tests\Constant;
use Symfony\Component\Process\Exception\ProcessFailedException;

class TestPyApi extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \AmmadKhalid\Cli\PyApi
     */
    public $api;
    public function setUp()
    {
        parent::setUp();
        $this->api = new PyApi(Constant::PYTHON_INTERPRETER, Constant::PROGRAM);
    }

    public function testRun()
    {
        $this->assertTrue(is_string($this->api->run()));
    }

    public function testRunWithInterpreter()
    {
        $this->expectException(ProcessFailedException::class);
        $this->api->run($useInterpreter=True);
    }

    public function testRunInBg()
    {
        $this->api->runInBg();
    }
}
