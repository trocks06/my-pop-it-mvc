<?php

namespace Src\Validator;

abstract class AbstractValidator
{
    protected string $field = '';
    protected $value;
    protected array $args = [];
    protected array $messageKeys = [];
    protected string $message = '';

    public function __construct(string $fieldName, $value, $args = [], string $message = null)
    {
        $this->field = $fieldName;
        $this->value = $value;
        $this->args = $args;
        $this->message = $message ?? $this->message;

        // Для файлов используем оригинальное имя вместо всего массива
        $displayValue = is_array($value) && isset($value['name'])
            ? $value['name']
            : $value;

        $this->messageKeys = [
            ":value" => $displayValue,
            ":field" => $this->field
        ];
    }

    public function validate()
    {
        if (!$this->rule()) {
            return $this->messageError();
        }
        return true;
    }

    private function messageError(): string
    {
        $message = $this->message;
        foreach ($this->messageKeys as $key => $value) {
            $message = str_replace($key, (string)$value, $message);
        }
        return $message;
    }

    abstract public function rule(): bool;
}