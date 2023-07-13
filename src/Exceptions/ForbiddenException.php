<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    License: BSD 2-Clause

    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
*/

namespace Jinx\Exceptions;

class ForbiddenException extends \Exception
{
    protected $message = 'You don\'t have permission to access this page';
    protected $code = 403;
}

?>