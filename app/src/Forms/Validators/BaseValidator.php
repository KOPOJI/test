<?php

namespace Koj\Forms\Validators;


/**
 * Class BaseValidator
 * @package Koj\Forms\Validators
 */
abstract class BaseValidator implements ValidatorInterface
{
    protected $checkField = null;
    protected $checkValue = null;
    protected $errorMessage = null;
    protected $additionalParams = array();
    protected $hasError = false;
    protected $error = null;
    protected $showAllErrors = false;

    const DEFAULT_MESSAGE = '';


    /**
     * BaseValidator constructor.
     * @param $name
     * @param $value
     * @param array $additional
     */
    public function __construct($name, $value, array $additional = array())
    {
        $this->checkField = $name;
        $this->checkValue = $value;

        isset($additional) && $this->setAdditionalParams($additional);

        $this->setErrorMessage();

        $this->validate();
    }

    /**
     * @return string
     */
    public function getError()
    {
        $this->setError();
        return $this->error;
    }

    /**
     * @return bool
     */
    public function showAllErrors()
    {
        return $this->showAllErrors;
    }


    /**
     * @param array $additional
     */
    protected function setAdditionalParams(array $additional = [])
    {
        foreach($additional as $name => $value)
        {
            if(method_exists($this, 'setData' . $name))
                $this->{'setData' . $name}($value);
        }
    }

    /**
     * @param null $errorMessage
     */
    protected function setErrorMessage($errorMessage = null)
    {
        $replace = array(
            '{name}' => $this->checkField
        );

        $message = $this->errorMessage;
        if(empty($errorMessage) && empty($message))
            $message = strtr(static::DEFAULT_MESSAGE, $replace);

        if(is_array($errorMessage) && !empty($errorMessage[0]))
        {
            $message = $errorMessage[0];
            if(isset($errorMessage[1]) && is_array($errorMessage[1]))
            {
                foreach($errorMessage[1] as $name => $value)
                    $replace['{' . $name . '}'] = $value;
            }
        }

        if(!empty($this->additionalParams))
        {
            foreach($this->additionalParams as $name => $value)
                $replace['{' . $name . '}'] = $value;
        }

        $this->errorMessage = strtr((empty($this->errorMessage) ? $message : $this->errorMessage), $replace);
    }

    /**
     * @param string $message
     */
    protected function setDataMessage(string $message)
    {
        $this->errorMessage = $message;
    }

    /**
     *
     */
    protected function setError()
    {
        $this->error = empty($this->errorMessage) ? static::DEFAULT_MESSAGE : $this->errorMessage;
    }

    /**
     * @param bool $showAll
     */
    protected function setDataShowAllErrors(bool $showAll)
    {
        $this->showAllErrors = $showAll;
    }
}
