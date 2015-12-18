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
        $this->setExpectedException('InvalidArgumentException');
        $this->app->setEnvironment('');
        $this->setExpectedException('InvalidArgumentException');
        $this->app->setEnvironment('staging');
        $this->assertTrue($this->app->setEnvironment('test'));
    }
}
