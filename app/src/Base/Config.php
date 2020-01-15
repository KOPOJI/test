<?php


namespace Koj\Base;


class Config
{
    /**
     * @param $filename
     * @param array $default
     * @return array|mixed
     */
    public static function getConfig($filename, $default = [])
    {
        return is_file(CONFIG_DIR . '/' . $filename) ? include CONFIG_DIR . '/' . $filename : $default;
    }
}