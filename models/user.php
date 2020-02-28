<?php

namespace advor\models;

Class User
{
    private $db;

    private $id_user;

    public $name;

    function __construct($db, $id_user = 0)
    {
        $this->db = $db;

        if ($id_user) {
            $this->id_user = $id_user;
        }
    }

    function getInfo($id_user)
    {
        $query = 'select name from users where id_user = :id_user';

        return $this
                    ->db
                    ->getRow($query, ['id_user' => $id_user]);
    }

    function checkExists($login, $pass)
    {
        $query ='select id_user, name from users where login = :login and pass = password(:pass)';

        return $this
                    ->db
                    ->getRow($query, ['login' => $login, 'pass' => $pass]);
    }

    function getList()
    {
        $query ='select id_user, name from users order by name';

        return $this
                    ->db
                    ->getList($query);
    }

    function register($login, $pass)
    {
        $query = 'insert into users (login, pass) values (:login, password(:pass))';

        return $this
                    ->db
                    ->insertData($query, ['login' => $login, 'pass' => $pass]);
    }
}
