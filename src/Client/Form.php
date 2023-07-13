<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
    License: BSD 2-Clause
*/

namespace Jinx\Client;

use Jinx\Model;
use Jinx\Client\Fields\InputField;
use Jinx\Client\Fields\LabelField;

class Form {
    public static function begin($class, $action, $method) {
        // Assigns the class, action, and method for the form
        echo sprintf('<form class="%s" action="%s" method="%s">', $class, $action, $method);
        return new Form();
    }

    public static function end() {
        echo "</form>";
    }

    public function field(Model $model, $attribute, $class, $field) {
        switch ($field) {
            case "input":
                return new InputField($model, $attribute, $class);
            case "label":
                return new LabelField($model, $attribute, $class);
        }

    }
}

?>
