<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class AvatarValidator extends AbstractValidator
{
    protected string $message = 'Avatar must be an image (JPEG, PNG, GIF) and not exceed 2MB in size';

    public function rule(): bool
    {
        $file = $this->value;

        if (empty($this->value) || $this->value['error'] === UPLOAD_ERR_NO_FILE) {
            return true;
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            return false;
        }

        $allowedTypes = [
            'image/jpg',
            'image/jpeg',
            'image/png',
            'image/gif'
        ];

        if (!in_array(strtolower($file['type']), $allowedTypes)) {
            return false;
        }

        return true;
    }
}