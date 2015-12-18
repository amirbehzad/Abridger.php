<?php

namespace Abridger;

trait Config
{
    protected function getConfig($filepath)
    {
        if (! is_readable($filepath)) {
            throw new \Exception(sprintf('Configuration file (%s) not found', $filepath));
        }
        $conf = parse_ini_file($filepath, true);
        if (! $conf) {
            throw new \Exception('Unable to parse configuration data');
        }
        return $conf;
    }
}
