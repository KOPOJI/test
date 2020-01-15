<?php


namespace Koj\Base;


interface DbInterface
{
    /**
     * @param string $sql
     * @param array $params
     * @return int
     */
    public function count(string $sql, array $params = []);

    /**
     * @param $data
     * @return mixed
     */
    public function quote($data);

    /**
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public function getAll(string $sql, array $params = []);

    /**
     * @param string $rawSql
     * @return false|int
     */
    public function exec(string $rawSql);

    /**
     * @param string $sql
     * @param array $params
     * @return bool|\PDOStatement
     */
    public function prepareExecute(string $sql, array $params = []);
}