<?php

namespace Abridger\Controller;

use \Abridger\Controller;

class Api extends Controller
{
    public function abrdige()
    {
        return $this->res->getBody()->write('Test');
    }
}
