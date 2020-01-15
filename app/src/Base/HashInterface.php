<?php


namespace Koj\Base;


/**
 * Interface HashInterface
 * @package Koj\Base
 */
interface HashInterface
{
    /**
     * @param string $string
     * @param int $algorithm
     * @return mixed
     */
    public static function make(string $string, int $algorithm = PASSWORD_DEFAULT);

    /**
     * @param string $hash
     * @param string $password
     * @return mixed
     */
    public static function checkPassword(string $password, string $hash);
}