<?php
/*
    Project: Jinx Framework (https://github.com/battleoverflow/jinx)
    License: BSD 2-Clause

    Author: battleoverflow (https://github.com/battleoverflow)
*/

namespace Jinx;

use Jinx\Database\DatabaseModel;

abstract class UserModel extends DatabaseModel {
    abstract public function getUserName(): string;
}

?>
