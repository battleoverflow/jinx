<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    License: BSD 2-Clause

    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
*/

namespace Jinx;

use Jinx\middleware\BaseMiddleware;

class Controller
{
    // Default layout
    public string $layout = 'main';
    public string $action = '';
    protected array $middleware = [];

    // Set the file layout
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    // Render page content
    public function render($view, $params = [])
    {
        return Jinx::$jinx->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middleware[] = $middleware;
    }

    public function getMiddleware(): array
    {
        return $this->middleware;
    }
}