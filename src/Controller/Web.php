<?php

namespace Abridger\Controller;

use \Abridger\Controller;
use \Abridger\Hasher;

class Web extends Controller
{
    public function redirect()
    {
        $token = $this->getParam('token');
        $url_id = Hasher::decode($token);

        $query = $this->getService('DB')->prepare('SELECT * from urls WHERE id = :url_id');
        $query->bindParam(':url_id', $url_id);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_ASSOC);

        return ($result) ?
            $this->getResponse()->withRedirect($result['url']) :
            $this->getResponse()->withStatus(404)->write('Not Found');
    }

    public function homepage()
    {
    }
}
