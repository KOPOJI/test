<?php


namespace Koj\Base;


use Koj\Forms\Validators\ValidatorInterface;
use Exception;
use ReflectionClass;
use ReflectionException;

abstract class Model implements ModelInterface
{
    /**
     * @var DbInterface $db
     */
    protected $db;

    protected $fillable = [];

    protected $sortable = [];

    protected $errors = [];

    protected $pageParam = 'page';
    protected $perPage = 3;

    public function __construct(array $data = [])
    {
        $this->db = App::getDb();

        $this->loadFromData($data);
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        try
        {
            return strtolower((new ReflectionClass($this))->getShortName()) . 's';
        }
        catch(ReflectionException $e)
        {
        }
    }

    /**
     * @return array
     */
    public function getSort()
    {
        if(isset($_GET['sort']) && array_key_exists($_GET['sort'], $this->getSortableFields())) {
            return [
                'by' => preg_replace('~^[^-_a-z0-9]+$~ui', '', $_GET['sort']),
                'order' => $this->getSortOrder()
            ];
        }

        return [];
    }

    /**
     * @return mixed|null
     */
    public function getSortOrder()
    {
        $sortOrder = isset($_GET['sort_order']) ? strtolower($_GET['sort_order']) : null;
        return $sortOrder && in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';
    }

    /**
     * @param int $id
     * @param string $fields
     * @return mixed
     */
    public function findById(int $id, $fields = '*')
    {
        return current((array) $this->find($fields, ' WHERE `id` = ?', [$id]));
    }

    /**
     * @param string $fields
     * @param string $condition
     * @param array $params
     * @return array|mixed
     */
    public function findAll($fields = '*', $condition = '', array $params = [])
    {
        if($order = $this->getSort())
            $condition .= 'ORDER BY `' . $this->getTableName() . '`.`' . $order['by'] . '` ' . $order['order'];

        $return = [];
        foreach($this->find($fields, $condition, $params) as $item) {
            $return[] = new static($item);
        }

        return $return;
    }

    /**
     * @param string|array $fields
     * @param string $condition
     * @param array $params
     * @return mixed
     */
    public function find($fields = '*', string $condition = '', array $params = [])
    {
        if(is_array($fields))
            $fields = join(', ', $fields);

        return $this->db->getAll('SELECT ' . $fields . ' FROM `' . $this->getTableName() . '` ' . $condition, $params);
    }

    /**
     * @param string $condition
     * @param array $params
     * @return int
     */
    public function count(string $condition = '', array $params = [])
    {
        return $this->db->count('SELECT COUNT(1) FROM `' . $this->getTableName() . '` ' . $condition, $params);
    }

    /**
     * @param string $fields
     * @param string $condition
     * @param array $params
     * @return array|mixed
     */
    public function findAllWithPaginate($fields = '*', string $condition = '', array $params = [])
    {
        if($order = $this->getSort())
            $condition .= 'ORDER BY `' . $this->getTableName() . '`.`' . $order['by'] . '` ' . $order['order'];

        $page = $this->getCurrentPageNumber();

        $condition .= ' LIMIT ' . (($page - 1) * $this->perPage) . ', ' . (int) $this->perPage;

        $return = [];
        foreach($this->find($fields, $condition, $params) as $item) {
            $return[] = new static($item);
        }

        return $return;
    }

    /**
     * @param string $condition
     * @param array $params
     * @return int
     */
    public function getPagesCount(string $condition = '', array $params = [])
    {
        return (int) ceil($this->count() / $this->perPage);;
    }

    /**
     * @return int
     */
    public function getCurrentPageNumber()
    {
        $page = isset($_GET[$this->pageParam]) ? (int) $_GET[$this->pageParam] : 1;
        if($page < 1)
            $page = 1;
        return $page;
    }


    /**
     * @param array $data
     */
    public function loadFromData(array $data = [])
    {
        foreach($data as $key => $v) {
            if(in_array($key, $this->fillable) && property_exists($this, $key)) {
                $this->{$key} = $v;
            }
        }
    }

    /**
     * @return array
     */
    public function getValidationRules()
    {
        return [];
    }

    /**
     * @return mixed|void
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $existsValidators = App::getValidators();
        foreach($this->getValidationRules() as $rule) {
            if(!isset($rule[0], $rule[1], $existsValidators[$rule[1]]))
                continue;

            $additionalParams = isset($rule[2]) && is_array($rule[2]) ? $rule[2] : array();

            $fields = preg_split('~\\s*+,\\s*+~u', $rule[0], -1, PREG_SPLIT_NO_EMPTY);

            $modelFields = $this->getModelFields();

            foreach($fields as $field) {
                $value = isset($modelFields[$field]) ? $modelFields[$field] : null;
                $this->checkValue($field, new $existsValidators[$rule[1]]($field, $value, $additionalParams));
            }
        }

        return empty($this->errors);
    }

    /**
     * @param $name
     * @param ValidatorInterface $validator
     * @return bool
     */
    public function checkValue($name, ValidatorInterface $validator)
    {
        if($validator->validate())
            return true;

        $this->setError($name, $validator->getError(), $validator->showAllErrors());

        return false;
    }

    /**
     * @param $name
     * @param $error
     * @param bool $showAllErrors
     */
    public function setError($name, $error, $showAllErrors = false)
    {
        if(isset($this->errors[$name])) {
            if(!$showAllErrors)
                return ;
            if(is_array($this->errors[$name]))
                $this->errors[$name][] = $error;
            else
                $this->errors[$name] = array($this->errors[$name], $error);
        }
        else
            $this->errors[$name] = $error;
    }

    /**
     * @return array|void
     */
    public function getSortableFields()
    {
        return $this->sortable;
    }

    /**
     * @return array
     */
    public function getModelFields()
    {
        $fields = [];
        foreach($this->fillable as $key) {
            if(property_exists($this, $key))
                $fields[$key] = $this->{$key};
        }

        return $fields;
    }

    /**
     * @param bool $runValidation
     * @return bool|mixed|\PDOStatement
     */
    public function save($runValidation = true)
    {
        if($runValidation && !$this->validate())
            return false;

        $fields = $this->getModelFields();

        if(empty($this->id)) { // new record
            $query = 'INSERT INTO `' . $this->getTableName() . '` (' . join(', ', array_keys($fields)) . ')
                    VALUES (' . trim(str_repeat('?, ', count($fields)), ', ') . ')';
        }
        else { // existing record
            $query = 'UPDATE `' . $this->getTableName() . '` SET ';
            foreach($fields as $k => $v)
                $query .= '`' . $k . '` = ?, ';
            $query = rtrim($query, ', ') . ' WHERE `id` = ' . (int) $this->id . ' LIMIT 1';
        }

        return $this->db->prepareExecute($query, array_values($fields));
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return property_exists($this, $offset);
    }

    /**
     * @param mixed $offset
     * @return bool|mixed
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->{$offset} : false;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if($this->offsetExists($offset))
            $this->{$offset} = $value;
    }

    /**
     * @param mixed $offset
     * @throws Exception
     */
    public function offsetUnset($offset)
    {
        throw new Exception('Cannot unset');
    }
}