<?php

namespace Abridger\Tests;

use \Abridger\App as App;

class ApiControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testActions()
    {
        $this->assertTrue(class_exists('\Abridger\Controller\Api'));
        $this->assertStringEndsWith('Abridger\Controller', get_parent_class('\Abridger\Controller\Api'));
        $this->assertTrue(method_exists('\Abridger\Controller\Api', 'abrdige'));
    }
}
