<?php
/*
    Project: Jinx Framework (https://github.com/battleoverflow/jinx)
    License: BSD 2-Clause

    Author: battleoverflow (https://github.com/battleoverflow)
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
        return sprintf('%s', $this->renderContent());
    }
}

?>
