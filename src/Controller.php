<?php
/*
    Project: Jinx Framework (https://github.com/battleoverflow/jinx)
    License: BSD 2-Clause

    Author: battleoverflow (https://github.com/battleoverflow)
*/

namespace Jinx;

use Jinx\middleware\BaseMiddleware;

class Controller {
    // Default layout
    public string $layout = 'main';
    public string $action = '';
    protected array $middleware = [];

    // Set the file layout
    public function setLayout($layout) {
        $this->layout = $layout;
    }

    // Render page content
    public function render($view, $params = []) {
        return Application::$jinx->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware) {
        $this->middleware[] = $middleware;
    }

    public function getMiddleware(): array {
        return $this->middleware;
    }
}
