<?php
namespace Macbook\Core;

class Validator
{
    public static array $errors = [];

    public static function isEmpty(string $valueField, string $nameField, string $msg = "Champ obligatoire!"): bool
    {
        if (empty($valueField)) {
            self::$errors[$nameField] = $msg;
            return true;
        }
        return false;
    }

    public static function add(string $key, mixed $data)
    {
        self::$errors[$key] = $data;
    }


    public static function isValid(): bool
    {
        return empty(self::$errors);
    }

    public static function isEmail(string $valueField, string $nameField, string $msg = "Le champ doit être un Email valide!")
    {
        if (!filter_var(trim($valueField), FILTER_VALIDATE_EMAIL)) {
            return self::$errors[$nameField] = $msg;
        }
    }
}
