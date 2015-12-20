<?php

namespace Abridger\Tests;

use \Abridger\App as App;
use \Slim\Http\Environment as Env;
use \Slim\Http\Request;
use \Slim\Http\Response;
use \Slim\Container;

class WebControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testActions()
    {
        $this->assertTrue(class_exists('\Abridger\Controller\Web'));
        $this->assertStringEndsWith('Abridger\Controller', get_parent_class('\Abridger\Controller\Web'));
        $this->assertTrue(method_exists('\Abridger\Controller\Web', 'homepage'));
        $this->assertTrue(method_exists('\Abridger\Controller\Web', 'redirect'));
    }

    public function getMockedController($token, $result)
    {
        $req = Request::createFromEnvironment(Env::mock());
        $res = new Response();
        $args = ['token' => $token];

        $db = $this->getMockBuilder('\Abridger\DB')
            ->disableOriginalConstructor()
            ->setMethods(['prepare'])
            ->getMock();

        $query = $this->getMock('\PDOStatement');
        $query->method('fetch')->willReturn($result);
        $db->method('prepare')->willReturn($query);

        $cnt = new Container(['DB' => $db]);

        return new \Abridger\Controller\Web($cnt, $req, $res, $args);
    }

    public function testRedirectNotFound()
    {
        $response = $this->getMockedController('XYZ', false)->redirect();
        $this->assertTrue($response->isNotFound());
        $this->assertFalse($response->isRedirect());
    }

    public function testRedirectOk()
    {
        $url = 'http://www.mindvally.com';
        $response = $this->getMockedController('xyz', ['url' => $url])
            ->redirect();
        $this->assertTrue($response->isRedirect());
        $this->assertContains($url, (string) $response);
    }
}
