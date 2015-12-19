<?php

namespace Abridger\Tests;

use \Abridger\Hasher;

class HasherTest extends \PHPUnit_Framework_TestCase
{

    public function testEncode()
    {
        $this->assertEquals('zlwrymre', Hasher::encode(1));
        $this->assertEmpty(Hasher::encode(''));
    }

    public function testDecode()
    {
        $this->assertEquals(1, Hasher::decode('zlwrymre'));
        $this->assertFalse(Hasher::decode(''));
    }
}
