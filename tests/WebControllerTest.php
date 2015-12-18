<?php

namespace Abridger\Tests;

use \Abridger\App as App;

class WebControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testActions()
    {
        $this->assertTrue(class_exists('\Abridger\Controller\Web'));
        $this->assertStringEndsWith('Abridger\Controller', get_parent_class('\Abridger\Controller\Web'));
        $this->assertTrue(method_exists('\Abridger\Controller\Web', 'homepage'));
        $this->assertTrue(method_exists('\Abridger\Controller\Web', 'redirect'));
    }
}
