<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class LetterValidator extends AbstractValidator
{

    protected string $message = 'Поле :field должно сождержать только буквы';

    public function rule(): bool
    {
        return preg_match("/^([А-яЁё]+)$/u", $this->value);
    }
}
