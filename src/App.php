<?php

namespace Abridger;

use \Slim\App as FrontController;

final class App
{

    protected $app;
    protected $env;

    protected function getSystemEnvironment()
    {
        return strtolower(getenv(strtoupper(__NAMESPACE__)));
    }

    public function __construct()
    {
        $env = $this->getSystemEnvironment();
        $this->setEnvironment($env);
        $this->app = new FrontController();
    }

    public function setEnvironment($env)
    {
        if (! in_array($env, ['test', 'development', 'production'])) {
            throw new \UnexpectedValueException('Invalid value given for environment variable');
        }
        $this->env = $env;
        return true;
    }

    public function getEnvironment()
    {
        return $this->env;
    }

    public function start()
    {
        $this->app->run();
    }
}
