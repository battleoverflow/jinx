<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    License: BSD 2-Clause

    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
*/

namespace Jinx\Client\Fields;

use Jinx\Client\BaseField;

class TextareaField extends BaseField
{
    public function renderContent(): string
    {
        return sprintf('<textarea name="%s" class="%s">%s</textarea>',
            $this->attribute, // Textarea (name)
            $this->model->hasError($this->attribute) ? "border-4 bg-red-500" : "", // Textarea (class)
            $this->model->{$this->attribute}, // Textarea (content)
        );
    }
}

?>