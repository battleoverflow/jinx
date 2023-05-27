<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    License: BSD 2-Clause

    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
*/

namespace Jinx\exceptions;

class NotFoundException extends \Exception
{
    protected $message = 'Not found';
    protected $code = 404;
}

?>