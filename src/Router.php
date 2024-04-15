<?php
/*
    Project: Jinx Framework (https://github.com/battleoverflow/jinx)
    License: BSD 2-Clause

    Author: battleoverflow (https://github.com/battleoverflow)
*/

namespace Jinx;

use Jinx\exceptions\NotFoundException;

class Router {
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }

    // GET method
    public function get($path, $callback) {
        $this->routes['get'][$path] = $callback;
    }

    // POST method
    public function post($path, $callback) {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve() {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        // 404 error code, resource can't be found
        if ($callback === false) {
            throw new NotFoundException();
        }

        if (is_string($callback)) {
            return Application::$jinx->view->renderView($callback);
        }

        // Converts incoming array to an object
        if (is_array($callback)) {
            $controller = new $callback[0]();
            Application::$jinx->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddleware() as $middleware) {
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response);
    }
}
