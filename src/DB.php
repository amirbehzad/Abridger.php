<?php

namespace Abridger;

class DB
{

    private static $db = null;
    private static $dsn;
    private static $username;
    private static $password;

    public function __construct($dsn, $username, $password)
    {
        self::$dsn = $dsn;
        self::$username = $username;
        self::$password = $password;
    }

    private static function getConnection()
    {
        if (self::$db === null) {
            self::$db = new \PDO(
                self::$dsn,
                self::$username,
                self::$password,
                array(
                  \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                  \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING
                )
            );
        }
        return self::$db;
    }

    public function __call($func, $args)
    {
        $dbh = self::getConnection();
        return call_user_func_array([$dbh, $func], $args);
    }
}
