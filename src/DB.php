<?php

namespace Abridger;

class DB
{

    private static $db = null;

    public function __construct($dsn, $username, $password)
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
    }

    private static function getConnection()
    {
        if (self::$db === null) {
            self::$db = new \PDO(
                self::$dsn,
                self::$username,
                self::$password,
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'")
            );
        }
        return self::$db;
    }

    public function __call($func, $args)
    {
        $dbh = self::getConnection();
        return $dbh->$func($args);
    }
}
