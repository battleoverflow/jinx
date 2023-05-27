<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    License: BSD 2-Clause

    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
*/

namespace Jinx\middleware;

use Jinx\Application;
use Jinx\exceptions\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];

    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        // Validates user is not logged in
        if (Application::isGuest()) {
            // Check if the provided value exists in the array
            if (empty($this->actions) || in_array(Application::$jinx->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
}

?>
