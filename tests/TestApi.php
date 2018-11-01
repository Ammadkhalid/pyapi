<?php

use Ammadkhalid\Cli\Tests\Constant;
use PHPUnit\Framework\TestCase;
use AmmadKhalid\Cli\Api;

class TestApi extends TestCase {

    /**
     * @var Api
     */
    public $api;

    public function setUp()
    {
        parent::setUp();
        $this->api = new Api(Constant::PYTHON_INTERPRETER, Constant::PROGRAM);

    }

    public function testOutput()
    {
        $this->api->setPositionalArgumentDashes("-")->
        addPositionalArgument('run-request-bot')
            ->addArgument('user', 'Username')
            ->addArgument('Password', 'Password')
            ->addArgument('search_query', 'Query');

        // test if contains interpreter
        $this->assertContains(Constant::PYTHON_INTERPRETER, $this->api->getCommand());
        // test if contains not interpreter
        $this->assertContains(Constant::PROGRAM, $this->api->getProgramCommand());
        // test if contains program only.
        $this->assertNotContains(Constant::PYTHON_INTERPRETER, $this->api->getProgramCommand());
        // test if contains python 3 encoding
        $this->api->setPythonEncoding();
        $this->assertContains(Constant::PYTHON_ENV, $this->api->getProgramCommand());
    }


}
