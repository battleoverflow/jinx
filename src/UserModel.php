<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
    License: BSD 2-Clause
*/

namespace Jinx;

use Jinx\ORM\CloudModel;

abstract class UserModel extends CloudModel {
    abstract public function getUserName(): string;
}

?>
