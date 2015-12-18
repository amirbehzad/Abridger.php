<?php

namespace Abridger\Tests;

use \Abridger\App as App;

class AppTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->app = new App();
    }

    public function testGetEnvironment()
    {
        $this->assertEquals('test', $this->app->getEnvironment());
    }

    public function testSetEnvironment()
    {
        $this->setExpectedException('UnexpectedValueException');
        $this->app->setEnvironment('');
        $this->setExpectedException('UnexpectedValueException');
        $this->app->setEnvironment('staging');
        $this->assertTrue($this->app->setEnvironment('test'));
    }

    protected function callPrivateMethod($object, $method, $argument = null)
    {
        $method = new \ReflectionMethod($object, $method);
        $method->setAccessible(true);

        $invoker = (is_array($argument)) ? 'invokeArgs' : 'invoke';

        return $method->$invoker($object, $argument);

    }

    public function testGetConfigFile()
    {
        $config_file = sprintf(App::CONFIG_PATH, $this->app->getEnvironment());
        $this->assertStringEndsWith(
            basename($config_file),
            $this->callPrivateMethod($this->app, 'getConfigFilePath')
        );
    }

    public function testGetConfig()
    {
        $this->assertTrue(
            is_array($this->callPrivateMethod($this->app, 'getConfig'))
        );
    }
}
