<?php
/*
    Project: Jinx Framework (https://github.com/battleoverflow/jinx)
    License: BSD 2-Clause

    Author: battleoverflow (https://github.com/battleoverflow)
*/

namespace Jinx\Client\Fields;

use Jinx\Client\BaseField;
use Jinx\Model;

class LabelField extends BaseField {
    public string $class;

    public function __construct(Model $model, string $attribute, string $class) {
        $this->class = '';
        parent::__construct($model, $attribute, $class);
    }

    public function renderContent(): string {
        return sprintf('<label class="%s" for="%s">%s</label>',
        $this->class, // Label (class)
        $this->attribute, // Label (for)
        $this->model->getLabel($this->attribute), // Label
        );
    }
}

?>
