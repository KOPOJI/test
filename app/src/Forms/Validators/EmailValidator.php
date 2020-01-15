<?php

namespace Koj\Forms\Validators;


/**
 * Class EmailValidator
 * @package Koj\Forms\Validators
 */
class EmailValidator extends BaseValidator
{
    /**
     *
     */
    const DEFAULT_MESSAGE = 'Неверный формат E-mail';

    /**
     * @return bool|mixed
     */
    public function validate()
    {
        return !($this->hasError = !filter_var($this->checkValue, FILTER_VALIDATE_EMAIL));
    }
}