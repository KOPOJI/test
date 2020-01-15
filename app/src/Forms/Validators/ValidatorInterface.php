<?php


namespace Koj\Forms\Validators;


interface ValidatorInterface
{
    /**
     * @return mixed
     */
    public function validate();

    /**
     * @return mixed
     */
    public function getError();

    /**
     * @return mixed
     */
    public function showAllErrors();
}