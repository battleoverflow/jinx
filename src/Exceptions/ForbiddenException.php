<?php
/*
    Project: Jinx Framework (https://github.com/battleoverflow/jinx)
    License: BSD 2-Clause

    Author: battleoverflow (https://github.com/battleoverflow)
*/

namespace Jinx\exceptions;

class ForbiddenException extends \Exception {
    protected $message = 'You don\'t have permission to access this page';
    protected $code = 403;
}

?>
