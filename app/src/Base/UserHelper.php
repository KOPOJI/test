<?php


namespace Koj\Base;


use Koj\User;

/**
 * Class UserHelper
 * @package Koj\Base
 */
class UserHelper
{

    const SESSION_KEY = 'user_id';

    /**
     * @return bool
     */
    public static function canEdit()
    {
        return !static::isGuest() && ($user = static::current()) ? $user->isAdmin() : false;
    }

    /**
     * @param array $data
     * @return User
     */
    public static function login(array $data)
    {
        $user = new User();
        if(
            !($result = $user->findByUsername($data['username'] ?? '')) ||
            !Hash::checkPassword($data['password'] ?? '', $result['password'] ?? '')
        ) {
            $user->setError('username', 'Неверный логин и/или пароль');
        }

        if(!$user->getErrors())
            static::setSessionValue($result['id']);

        return $user;
    }

    /**
     *
     */
    public static function logout()
    {
        if(isset($_SESSION[static::SESSION_KEY]))
            unset($_SESSION[static::SESSION_KEY]);
        header('Location: /');
        exit;
    }

    /**
     * @return mixed|static
     */
    public static function current()
    {
        $user = new User();
        return static::isGuest() ? $user : new User($user->findById(static::getSessionValue()));
    }

    /**
     * @return mixed|null
     */
    public static function getSessionValue()
    {
        return $_SESSION[static::SESSION_KEY] ?? null;
    }

    /**
     * @param $value
     */
    public static function setSessionValue($value)
    {
        $_SESSION[static::SESSION_KEY] = $value;
    }

    /**
     * @return bool
     */
    public static function isGuest()
    {
        return empty(static::getSessionValue());
    }
}