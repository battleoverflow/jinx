<?php
/*
    Project: Jinx Framework (https://github.com/battleoverflow/jinx)
    License: BSD 2-Clause

    Author: battleoverflow (https://github.com/battleoverflow)
*/

namespace Jinx;

abstract class Model {
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    public array $errors = [];

    // Iterates over the ingested data to set a new value
    public function loadData($data) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }   
    }

    public function rules(): array {
        return [];
    }

    public function labels(): array {
        return [];
    }

    public function getLabel($attribute) {
        // Returns the label name, not the the label default (reference: jinx\model\user\labels())
        return $this->labels()[$attribute] ?? $attribute;
    }

    public function validate() {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleName = $rule;

                if (!is_string($rule)) {
                    $ruleName = $rule[0];
                }

                // Throws an error if the required input is not present
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->ruleError($attribute, self::RULE_REQUIRED, $rule);
                }

                // Throws an error is the provided string is not a valid email
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->ruleError($attribute, self::RULE_EMAIL, $rule);
                }

                // Throws an error if the password does not meet the minimum length requirement
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->ruleError($attribute, self::RULE_MIN, $rule);
                }

                // Throws an error if the password exceeds the maximum length allowed
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->ruleError($attribute, self::RULE_MAX, $rule);
                }

                // Throws an error if the original value does not match the secondary value (i.e "Confirm password")
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->ruleError($attribute, self::RULE_MATCH, $rule);
                }

                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();

                    // Pulls data from the db to check if the provided value is unique
                    $checkValue = Application::$jinx->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");

                    $checkValue->bindValue(":attr", $value);
                    $checkValue->execute();

                    // Locates the record in the bd
                    $record = $checkValue->fetchObject();

                    // Checks if the record exists and throws an error if it isn't unique
                    if ($record) {
                        $this->ruleError($attribute, self::RULE_UNIQUE, ['field' => $this->getLabel($attribute)]);
                    }
                }
            }
        }

        // Confirms no validation errors are present
        return empty($this->errors);
    }

    public function errorMessages() {
        // Constants for error messages
        return [
            self::RULE_REQUIRED => "This field is required",
            self::RULE_EMAIL => "Requires a valid email",
            self::RULE_MIN => "Minimum length for field: {min}",
            self::RULE_MAX => "Maximum length for field: {max}",
            self::RULE_MATCH => "This field must the same as {match}",
            self::RULE_UNIQUE => "The {field} value already exists in the database",
        ];
    }

    protected function ruleError(string $attribute, string $rule, $params = []) {
        $message = $this->errorMessages()[$rule] ?? '';
        // $params['field'] ??= $attribute;
        // $errorMessages = $this->errorMessages($rule);

        // Replaces values within the error message with the actual data
        // TODO: Fix bug. Throws weird error on the frontend when the values are empty
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        // Protects us from accidentally submitting data before all requirements are met
        $this->errors[$attribute][] = $message;
    }

    public function addError(string $attribute, string $message) {
        // Protects us from accidentally submitting data before all requirements are met
        $this->errors[$attribute][] = $message;
    }

    // Checks if an error exists and returns a boolean
    public function hasError($attribute) {
        return $this->errors[$attribute] ?? false;
    }

    // Collects the first error in the array and returns a boolean
    public function getFirstError($attribute) {
        return $this->errors[$attribute][0] ?? false;
    }
}
