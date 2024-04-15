<?php
/*
    Project: Jinx Framework (https://github.com/battleoverflow/jinx)
    License: BSD 2-Clause

    Author: battleoverflow (https://github.com/battleoverflow)
*/

namespace Jinx;

class Response {
    public function setStatusCode(int $code) {
        // Handles status code responses
        http_response_code($code);
    }

    public function redirect(string $uriPath) {
        header('Location: '.$uriPath);
    }
}
