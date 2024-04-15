<?php
/*
    Project: Jinx Framework (https://github.com/battleoverflow/jinx)
    License: BSD 2-Clause

    Author: battleoverflow (https://github.com/battleoverflow)
*/

namespace Jinx\exceptions;

class NotFoundException extends \Exception {
    protected $message = 'Not found';
    protected $code = 404;
}

?>
