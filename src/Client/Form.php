<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    License: BSD 2-Clause

    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
*/

namespace Jinx\Client;

use Jinx\Model;
use Jinx\Client\Fields\InputField;

class Form
{
    public static function begin($class, $action, $method)
    {
        // Assigns the class, action, and method for the form
        echo sprintf('<form class="%s" action="%s" method="%s">', $class, $action, $method);
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }
}

?>