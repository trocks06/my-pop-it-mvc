<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class PasswordValidator extends AbstractValidator
{
    protected string $message = 'Password must be at least 8 characters long and contain at least one digit, one uppercase and one lowercase letter';

    public function rule(): bool
    {
        $value = $this->value;

        // Проверка длины (минимум 8 символов)
        if (strlen($value) < 8) {
            return false;
        }

        // Проверка наличия хотя бы одной цифры
        if (!preg_match('/\d/', $value)) {
            return false;
        }

        // Проверка наличия хотя бы одной заглавной буквы
        if (!preg_match('/[A-Z]/', $value)) {
            return false;
        }

        // Проверка наличия хотя бы одной строчной буквы
        if (!preg_match('/[a-z]/', $value)) {
            return false;
        }

        return true;
    }
}