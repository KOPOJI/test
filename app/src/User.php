<?php


namespace Koj;


use Koj\Base\Model;

class User extends Model
{
    const ADMIN_ROLE = 1;

    protected $fillable = ['id', 'name', 'username', 'email', 'role'];

    protected $id;
    protected $name;
    protected $email;
    protected $role;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function isAdmin()
    {
        return $this->role == static::ADMIN_ROLE;
    }

    /**
     * @param string $username
     * @param string $fields
     * @return mixed
     */
    public function findByUsername(string $username, $fields = '*')
    {
        return current((array) $this->find($fields, ' WHERE `username` = ?', [$username]));
    }

    /**
     * @return array
     */
    public function getAllForSelect()
    {
        $return = [];
        foreach($this->findAll('id, name') as $user) {
            $return[$user['id']] = $user['name'];
        }

        return $return;
    }
}