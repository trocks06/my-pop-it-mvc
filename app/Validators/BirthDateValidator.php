<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class BirthDateValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно содержать корректную дату (возраст от 18 до 120 лет)';

    public function rule(): bool
    {
        if (empty($this->value)) {
            return false;
        }

        try {
            $birthDate = new \DateTime($this->value);
            $today = new \DateTime();

            // Проверяем, что дата не в будущем
            if ($birthDate > $today) {
                $this->message = 'Поле :field не может быть в будущем';
                return false;
            }

            $age = $today->diff($birthDate)->y;

            if ($age < 18) {
                $this->message = 'Поле :field: возраст должен быть не менее 18 лет';
                return false;
            }

            if ($age > 120) {
                $this->message = 'Поле :field: возраст должен быть не более 120 лет';
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}