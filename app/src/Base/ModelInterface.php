<?php


namespace Koj\Base;

use ArrayAccess;

interface ModelInterface extends ArrayAccess
{
    /**
     * @param int $id
     * @param string $fields
     * @return mixed
     */
    public function findById(int $id, $fields = '*');

    /**
     * @param string $fields
     * @param string $condition
     * @param array $params
     * @return mixed
     */
    public function findAll($fields = '*', $condition = '', array $params = []);

    /**
     * @param string $fields
     * @param string $condition
     * @param array $params
     * @return mixed
     */
    public function find($fields = '*', string $condition = '', array $params = []);

    /**
     * @param string $condition
     * @param array $params
     * @return int
     */
    public function count(string $condition = '', array $params = []);

    /**
     * @param string $condition
     * @param array $params
     * @return mixed
     */
    public function getPagesCount(string $condition = '', array $params = []);

    /**
     * @return int
     */
    public function getCurrentPageNumber();

    /**
     * @param string $fields
     * @param string $condition
     * @param array $params
     * @return mixed
     */
    public function findAllWithPaginate($fields = '*', string $condition = '', array $params = []);

    /**
     * @return array
     */
    public function getModelFields();

    /**
     * @return array
     */
    public function getSortableFields();

    /**
     * @return mixed
     */
    public function getErrors();

    /**
     * @return array
     */
    public function getValidationRules();

    /**
     * @return bool
     */
    public function validate();

    /**
     * @param bool $runValidation
     * @return mixed
     */
    public function save(bool $runValidation = true);
}