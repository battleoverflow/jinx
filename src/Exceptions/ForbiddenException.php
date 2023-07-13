<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
    License: BSD 2-Clause
*/

namespace Jinx\Exceptions;

class ForbiddenException extends \Exception {
    protected $message = 'You don\'t have permission to access this page';
    protected $code = 403;
}

?>
