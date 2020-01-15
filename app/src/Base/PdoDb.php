<?php


namespace Koj\Base;


use PDO;
use RuntimeException;

class PdoDb implements DbInterface
{
    const CONFIG_NAME = 'pdo_db.php';

    private $pdo;

    public function __construct()
    {
        $config = (array) Config::getConfig(static::CONFIG_NAME);

        $this->checkConfig($config);

        $this->pdo = new PDO(
            $config['dsn'],
            $config['user'] ?? null,
            $config['password'] ?? null,
            $config['options'] ?? null
        );
    }

    /**
     * @param string $rawSql
     * @return false|int
     */
    public function exec(string $rawSql)
    {
        return $this->pdo->exec($rawSql);
    }

    /**
     * @param string $sql
     * @param array $params
     * @return bool|\PDOStatement
     */
    public function prepareExecute(string $sql, array $params = [])
    {
        $res = $this->pdo->prepare($sql);
        $res->execute($params);
        return $res;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function getAll(string $sql, array $params = [])
    {
        return $this->prepareExecute($sql, $params)->fetchAll();
    }

    /**
     * @param array $config
     */
    private function checkConfig(array $config = [])
    {
        if(empty($config['dsn']))
            throw new RuntimeException('Wrong DB config specified');
    }

    /**
     * @param string $sql
     * @param array $params
     * @return int
     */
    public function count(string $sql, array $params = [])
    {
        if(($data = $this->prepareExecute($sql, $params)))
            $data = $data->fetch(PDO::FETCH_NUM);
        return isset($data[0]) ? (int) $data[0] : 0;
    }

    /**
     * @param $data
     * @return false|mixed|string
     */
    public function quote($data)
    {
        return $this->pdo->quote($data);
    }
}