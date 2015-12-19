<?php

namespace Abridger;

use \Hashids\Hashids;

class Hasher
{
    const MIN_HASH_LEN = 8;
    const HASH_CHARMAP = 'abcdefghijklmnopqrstuvwxyz';

    protected static $hasher = null;

    protected function __construct()
    {
    }

    protected static function getHasher()
    {
        if (is_null(self::$hasher)) {
            self::$hasher = new Hashids(
                __NAMESPACE__,
                self::MIN_HASH_LEN,
                self::HASH_CHARMAP
            );
        }
        return self::$hasher;
    }

    public static function encode($val)
    {
        return self::getHasher()->encode($val);
    }

    public static function decode($val)
    {
        $decoded = self::getHasher()->decode($val);
        return reset($decoded);
    }
}
