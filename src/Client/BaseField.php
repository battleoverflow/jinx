<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
    License: BSD 2-Clause
*/

namespace Jinx\Client;

use Jinx\Model;

abstract class BaseField {
    public Model $model;
    public string $attribute;
    public string $class;

    public function __construct(Model $model, string $attribute, $class) {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->class = $class;
    }

    abstract public function renderContent(): string;

    public function __toString() {
        return sprintf("%s", $this->renderContent());
    }
}

?>
