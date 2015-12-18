<?php

namespace Abridger;

use \Slim\App as FrontController;

final class App
{

    const CONFIG_PATH = '/../cfg/%s.ini';

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

    private function getConfig()
    {
        $conf_file = $this->getConfigFilepath();
        if (! is_readable($conf_file)) {
            throw new \Exception(sprintf('Configuration file (%s) not found', $conf_file));
        }
        $conf = parse_ini_file($conf_file, true);
        if (! $conf) {
            throw new \Exception('Unable to parse configuration data');
        }
        return $conf;
    }

    private function getConfigFilepath()
    {
        return realpath(sprintf(__DIR__ . self::CONFIG_PATH, $this->getEnvironment()));
    }

    public function start()
    {
        $this->app->run();
    }
}
