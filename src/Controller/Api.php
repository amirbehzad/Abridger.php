<?php

namespace Abridger\Controller;

use \Abridger\Controller;
use \Abridger\Hasher;

class Api extends Controller
{

    const MAX_URL_LEN = 255;

    public function abridge()
    {
        $url = $this->getParam('url');

        if (empty($url)) {
            return $this->output(false, 'No URL is provided');
        }
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->output(false, 'The given URL is malformed');
        }
        if (strlen($url) > self::MAX_URL_LEN) {
            return $this->output(false, 'The given URL exceeds the maximum length');
        }

        $query = $this->getService('DB')
            ->prepare('INSERT INTO urls (url) VALUES (:url) ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id)');
        $query->bindParam(':url', $url);
        $query->execute();

        $url_id = $this->getService('DB')->lastInsertId();

        if (! $url_id) {
            return $this->output(false, 'Unable to generate a token for the given URL');
        }

        $token = Hasher::encode($url_id);
        return $this->output(true, 'OK', $token);
    }

    private function output($success, $message, $data = '')
    {
        return $this->getResponse()->withJson([
          'success' => $success,
          'message' => $message,
          'data' => $data,
        ]);
    }
}
