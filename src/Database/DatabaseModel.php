<?php
/*
    Project: Jinx Framework (https://github.com/battleoverflow/jinx)
    License: BSD 2-Clause

    Author: battleoverflow (https://github.com/battleoverflow)
*/

namespace Jinx\Database;

use Jinx\Model;
use Jinx\Application;

abstract class DatabaseModel extends Model {

    abstract public static function tableName(): string;
    abstract public function attributes(): array;
    abstract public static function primaryKey(): string;

    public function save() {
        /*
            Insert data into spcific table
        */

        $table_name = $this->tableName();
        $attributes = $this->attributes();

        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $table_name (".implode(',', $attributes).") VALUES (".implode(',', $params).")");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();
        return true;
    }

    // $user_data = [email => email@email.com, firstname => John]
    public static function findUser($user_data) {
        $table_name = static::tableName();
        $attributes = array_keys($user_data);

        // Appends "AND" to all db values associated with the user we need
        $user_info = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));

        // Extracts user info from the db
        $statement = self::prepare("SELECT * FROM $table_name WHERE $user_info");

        foreach ($user_data as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();

        // Returns extracted user info to validate information
        return $statement->fetchObject(static::class);
    }

    public static function prepare($statement) {
        /*
            Prepare a SQL statement for execution using the Jinx Framework
        */
        
        return Application::$jinx->db->prepare($statement);
    }
}

?>
