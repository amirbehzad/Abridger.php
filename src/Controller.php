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

    protected function get($service)
    {
        return $this->container->get($service);
    }
}
