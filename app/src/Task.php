<?php


namespace Koj;


use Koj\Base\Model;

class Task extends Model
{
    protected $perPage = 3;

    protected $fillable = [
        'id', 'name', 'email', 'user_id', 'text', 'status', 'edited_by_admin',
    ];

    /**
     * @var array
     */
    protected $sortable = [
        'name' => 'По имени',
        'email' => 'По e-mail',
        'status' => 'По статусу',
    ];

    const STATUS_DONE = 1;
    const STATUS_NEW = 0;

    protected $id;
    protected $name;
    protected $email;
    protected $user_id;
    protected $text;
    protected $edited_by_admin;
    protected $status;


    /**
     * @return array
     */
    public function getValidationRules()
    {
        return [
            ['name', 'required', ['message' => 'Введите название задачи']],
            ['email', 'required', ['message' => 'Введите e-mail']],
            ['user_id', 'required', ['message' => 'Выберите пользователя']],
            ['email', 'email', ['message' => 'Неверный формат email']],
        ];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function isDone()
    {
        return $this->getStatus() == static::STATUS_DONE;
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return $this->getStatus() == static::STATUS_NEW;
    }

    /**
     * @return bool
     */
    public function isEditedByAdmin()
    {
        return (bool) $this->edited_by_admin;
    }

    /**
     * @param array $data
     */
    public function setStatus(array $data = [])
    {
        $this->status = isset($data['status']) ? static::STATUS_DONE : static::STATUS_NEW;
    }

    /**
     *
     */
    public function setEditedByAdmin()
    {
        $this->edited_by_admin = true;
    }

    /**
     * @param string $fields
     * @param string $condition
     * @param array $params
     * @return array|mixed
     */
    public function findAll($fields = '*', $condition = '', array $params = [])
    {
        $usersTableName = (new User())->getTableName();
        return parent::findAll(
            '`' . $this->getTableName() . '`.*, `' . $usersTableName . '`.`name`',
            ' LEFT JOIN `' . $usersTableName . '` 
            ON `'. $this->getTableName() . '`.`user_id` = `' . $usersTableName . '`.`id` ' . $condition,
            $params
        );
    }
}