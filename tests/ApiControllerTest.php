<?php

namespace Abridger\Tests;

use \Abridger\App as App;
use \Slim\Http\Environment as Env;
use \Slim\Http\Request;
use \Slim\Http\Response;
use \Slim\Container;

class ApiControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testActions()
    {
        $this->assertTrue(class_exists('\Abridger\Controller\Api'));
        $this->assertStringEndsWith('Abridger\Controller', get_parent_class('\Abridger\Controller\Api'));
        $this->assertTrue(method_exists('\Abridger\Controller\Api', 'abridge'));
    }

    public function getMockedController($url, $result)
    {
        $req = Request::createFromEnvironment(Env::mock(
            [
                'REQUEST_METHOD' => 'POST',
                'url' => $url,
            ]
        ));
        $req = $req->withParsedBody(['url' => $url]);
        $res = new Response();
        $args = ['url' => $url];

        $db = $this->getMockBuilder('\Abridger\DB')
            ->disableOriginalConstructor()
            ->setMethods(['prepare', 'lastInsertId'])
            ->getMock();

        $query = $this->getMock('\PDOStatement');
        $db->method('prepare')->willReturn($query);
        $db->method('lastInsertId')->willReturn($result);

        $cnt = new Container(['DB' => $db]);

        return new \Abridger\Controller\Api($cnt, $req, $res, $args);
    }

    public function testInvalidUrl()
    {
        $response = $this->getMockedController('htp//:invalid_url.com', false)->abridge();
        $output = (string) $response->getBody();
        $json = json_decode($output);
        $this->assertNotFalse($json);
        $this->assertFalse($json->success);
        $this->assertContains('URL is malformed', $json->message);
    }

    public function testEmptyUrl()
    {
        $response = $this->getMockedController('', false)->abridge();
        $output = (string) $response->getBody();
        $json = json_decode($output);
        $this->assertNotFalse($json);
        $this->assertFalse($json->success);
        $this->assertContains('No URL', $json->message);
    }

    public function testDatabaseProblem()
    {
        $response = $this->getMockedController('http://www.valid.com', false)->abridge();
        $output = (string) $response->getBody();
        $json = json_decode($output);
        $this->assertNotFalse($json);
        $this->assertFalse($json->success);
        $this->assertContains('Unable to generate', $json->message);
    }

    public function testSuccessToken()
    {
        $response = $this->getMockedController('http://www.valid.com', 1984)->abridge();
        $output = (string) $response->getBody();
        $json = json_decode($output);
        $this->assertNotFalse($json);
        $this->assertTrue($json->success);
        $this->assertContains('OK', $json->message);
        $this->assertEquals('ypjggpvj', $json->data);
    }
}
