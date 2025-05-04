<?php

namespace Validators;

use Src\Validator\AbstractValidator;
use Model\Subscriber;

class UniqueFullNameValidator extends AbstractValidator
{
    protected string $message = 'Абонент с такими ФИО уже существует';

    public function rule(): bool
    {

        if (is_string($this->value)) {
            $parts = explode(' ', $this->value);
            $this->value = [
                'last_name' => $parts[0] ?? '',
                'first_name' => $parts[1] ?? '',
                'middle_name' => $parts[2] ?? null,
            ];
        }

        if (empty($this->value['last_name']) || empty($this->value['first_name'])) {
            return true;
        }

        $query = Subscriber::where('last_name', $this->value['last_name'])
            ->where('first_name', $this->value['first_name']);

        if (!empty($this->value['middle_name'])) {
            $query->where('middle_name', $this->value['middle_name']);
        } else {
            $query->where(function($q) {
                $q->where('middle_name', '')
                    ->orWhereNull('middle_name');
            });
        }

        return !$query->exists();
    }
}