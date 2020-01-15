<?php

namespace Koj\Forms\Validators;


/**
 * Class EmptyValidator
 * @package Koj\Forms\Validators
 */
class EmptyValidator extends BaseValidator
{
    /**
     *
     */
    const DEFAULT_MESSAGE = 'Введите {name}';

    /**
     * @return bool|mixed
     */
    public function validate()
    {
        return !($this->hasError = trim($this->checkValue) === '');
    }
}