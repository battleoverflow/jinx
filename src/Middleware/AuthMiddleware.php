<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
    License: BSD 2-Clause
*/

namespace Jinx\Middleware;

use Jinx\Jinx;
use Jinx\Exceptions\ForbiddenException;

class AuthMiddleware extends BaseMiddleware {
    public array $actions = [];

    public function __construct(array $actions = []) {
        $this->actions = $actions;
    }

    public function execute() {
        // Validates user is not logged in
        if (Jinx::isGuest()) {
            // Check if the provided value exists in the array
            if (empty($this->actions) || in_array(Jinx::$jinx->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
}

?>
