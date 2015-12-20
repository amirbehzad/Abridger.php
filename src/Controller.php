<?php

namespace Abridger;

abstract class Controller
{
    protected $container;
    protected $req;
    protected $res;
    protected $args;

    public function __construct($container, $req, $res, $args)
    {
        $this->container = $container;
        $this->req = $req;
        $this->res = $res;
        $this->args = $args;
    }

    protected function getParam($key, $default = null)
    {
        if (array_key_exists($key, $this->args)) {
            return $this->args[$key];
        }
        return trim($this->getRequest()->getParam($key, $default));
    }

    protected function getRequest()
    {
        return $this->req;
    }

    protected function getResponse()
    {
        return $this->res;
    }

    protected function getService($service)
    {
        return $this->container->get($service);
    }

    protected function render($view)
    {
        $html = file_get_contents(__DIR__ . '/View/' . $view . '.html');
        return $this->getResponse()->write($html);
    }
}
