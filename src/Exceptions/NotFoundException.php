<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
    License: BSD 2-Clause
*/

namespace Jinx\Exceptions;

class NotFoundException extends \Exception {
    protected $message = "Not found";
    protected $code = 404;
}

?>
