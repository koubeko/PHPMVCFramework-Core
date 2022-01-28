<?php
/**
 * File Name: Model.php
 * @author Ondřej Koubek
 * Date: 25.01.2022
 * Time: 15:30
 */

namespace app\core;

use JetBrains\PhpStorm\Pure;

/**
 * Class Model
 *
 * @author Ondřej Koubek
 * @namespace app\core
 */
abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public array $errors = [];

    public function loadData(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public function labels(): array
    {
        return [];
    }

    #[Pure] public function getLabel(string $attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }

    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $stmt = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $stmt->bindValue(":attr", $value);
                    $stmt->execute();
                    $record = $stmt->fetchObject();
                    if ($record) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $this->getLabel($attribute)]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    private function addErrorForRule(string $attribute, string $rule, array $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL    => 'This field must be valid email address',
            self::RULE_MIN      => 'Min length of this field must be {min}',
            self::RULE_MAX      => 'Max length of this field must be {max}',
            self::RULE_MATCH    => 'This field must be the same as {match}',
            self::RULE_UNIQUE   => 'Record with this {field} already exists',
        ];
    }

    public function hasError(string $attribute)
    {
        return $this->errors[$attribute] ?? false;
//        return (bool) $this->errors[$attribute];
    }

    public function getFirstError(?string $attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}