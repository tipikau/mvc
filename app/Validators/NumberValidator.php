<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class NumberValidator extends AbstractValidator
{

    protected string $message = 'Поле :field должно сождержать только цифры';

    public function rule(): bool
    {
        return preg_match("/^([0-9]+)$/u", $this->value);
    }
}
