<?php


namespace Koj\Base;


interface AppInterface
{
    /**
     * @return mixed
     */
    public function run();

    /**
     * @return DbInterface
     */
    public static function getDb();

    /**
     * @return mixed
     */
    public static function getValidators();
}