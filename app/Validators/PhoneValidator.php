<?php

namespace Validators;

use Model\Phone;
use Src\Validator\AbstractValidator;

class PhoneValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно содержать корректный номер телефона';

    public function rule(): bool
    {
        $pattern = '/^(\+7|8)[\s\-]?\(?\d{3}\)?[\s\-]?\d{3}[\s\-]?\d{2}[\s\-]?\d{2}$/';

        if (!preg_match($pattern, $this->value)) {
            return false;
        }

        $exists = Phone::where('phone_number', $this->value)->exists();
        if ($exists) {
            $this->message = 'Такой номер телефона уже есть';
            return false;
        }

        return true;
    }
}