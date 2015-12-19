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

    public function getParam($key, $default = null)
    {
        return array_key_exists($key, $this->args) ? $this->args[$key] : $default;
    }

    public function getRequest()
    {
        return $this->req;
    }

    public function getResponse()
    {
        return $this->res;
    }

    protected function getService($service)
    {
        return $this->container->get($service);
    }
}
