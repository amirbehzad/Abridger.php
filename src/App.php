<?php

namespace Abridger;

use \Slim\App as FrontController;

final class App
{
    use Config;

    const CONFIG_PATH = '/../cfg/%s.ini';

    protected $app;
    protected $env;

    public function __construct()
    {
        $env = $this->getSystemEnvironment();
        $this->setEnvironment($env);
        $this->conf = $this->getConfig($this->getConfigFilePath());
        $this->app = new FrontController();
    }

    protected function getSystemEnvironment()
    {
        return strtolower(getenv(strtoupper(__NAMESPACE__)));
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

    protected function getConfigFilepath()
    {
        return realpath(sprintf(__DIR__ . self::CONFIG_PATH, $this->getEnvironment()));
    }

    public function setRoutes(array $routes)
    {
        foreach ($routes as $uri => $route) {
            list($method, $callback) = $route;
            list($controller, $action) = $callback;
            $this->app->map(
                [$method],
                $uri,
                function ($req, $res, $args) use ($controller, $action) {
                    return (new $controller($this, $req, $res, $args))->$action();
                }
            );
        }
        return true;
    }

    public function start()
    {
        // establish a lazy connection to database
        $this->app->getContainer()['DB'] = new DB(
            $this->conf['database']['dsn'],
            $this->conf['database']['username'],
            $this->conf['database']['password']
        );

        $this->setRoutes([
          '/' =>        ['GET', ['\Abridger\Controller\Web', 'homepage']],
          '/abridge' => ['POST', ['\Abridger\Controller\Api', 'abridge']],
          '/{token}' => ['GET', ['\Abridger\Controller\Web', 'redirect']],
        ]);

        $this->app->run();
    }
}
