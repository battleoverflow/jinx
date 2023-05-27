<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    License: BSD 2-Clause

    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
*/

namespace Jinx\Client\Fields;

use Jinx\Client\BaseField;
use Jinx\Model;

class InputField extends BaseField
{
    // Define all available field types
    public const TYPE_DEFAULT = 'text';
    public const TYPE_EMAIL = 'email';
    public const TYPE_PASS = 'password';
    public const TYPE_NUM = 'number';

    public string $type;

    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_DEFAULT;
        parent::__construct($model, $attribute);
    }

    // Assigns the input type for the password
    public function passwordField()
    {
        $this->type = self::TYPE_PASS;
        return $this;
    }

    public function renderContent(): string
    {
        return sprintf('<input type="%s" name="%s" placeholder="%s" value="%s">',
            $this->type, // Input (type)
            $this->attribute, // Input (name)
            $this->attribute, // Input (placeholder)
            $this->model->{$this->attribute}, // Input (value)
        );
    }
}

?>