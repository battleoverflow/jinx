<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
    License: BSD 2-Clause
*/

namespace Jinx\Client\Fields;

use Jinx\Client\BaseField;
use Jinx\Model;

class LabelField extends BaseField {
    public string $class;

    public function __construct(Model $model, string $attribute, string $class) {
        $this->class = "";
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
