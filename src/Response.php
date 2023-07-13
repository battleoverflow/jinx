<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
    License: BSD 2-Clause
*/

namespace Jinx;

class Response {
    public function setStatusCode(int $code) {
        // Handles status code responses
        http_response_code($code);
    }

    public function redirect(string $uriPath) {
        header("Location: ".$uriPath);
    }
}
