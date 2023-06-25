<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    License: BSD 2-Clause

    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
*/

namespace Jinx;

class Request
{

    public function getPath()
    {
        // Retrieves the uri on the root
        $path = $_SERVER['REQUEST_URI'] ?? "/";
        $position = strpos($path, "?");

        // Checks if a query or "?" is present
        if ($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
    }

    public function method()
    {
        // Manage the request method
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getMethod()
    {
        // Access the request method (GET)
        return $this->method() === "get";
    }

    public function postMethod()
    {
        // Access the request method (POST)
        return $this->method() === "post";
    }

    public function getBody()
    {
        $body = [];

        // Sanatize GET request
        if ($this->getMethod()) {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        // Sanatize POST request
        if ($this->postMethod()) {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}