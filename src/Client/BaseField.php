<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    License: BSD 2-Clause

    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
*/

namespace Jinx\Client;

use Jinx\Model;

abstract class BaseField
{
    public Model $model;
    public string $attribute;

    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    abstract public function renderContent(): string;

    public function __toString()
    {
        return sprintf('
            <div>
                <label for="%s">%s</label>
                %s
            </div>
            
            <div>
                %s
            </div>
        ',
        $this->attribute, // Label (for)
        $this->model->getLabel($this->attribute), // Label
        $this->renderContent(), // Render client content
        $this->model->getFirstError($this->attribute) // Error message popup
        );
    }
}

?>