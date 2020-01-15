<?php


namespace Koj\Base;


/**
 * Class Hash
 * @package Koj\Base
 */
class Hash implements HashInterface
{
    /**
     * @param string $string
     * @param int $algorithm
     * @return mixed|void
     */
    public static function make(string $string, int $algorithm = PASSWORD_DEFAULT)
    {
        return password_hash($string, $algorithm);
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool|mixed
     */
    public static function checkPassword(string $password, string $hash)
    {
        return password_verify($password, $hash);
    }
}