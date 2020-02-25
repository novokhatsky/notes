<?php

namespace advor/module;

Class Auth
{
    private $user;

    function __construct($sessionVar)
    {
        $id = $sessionVar->getValue();
        if ($id) {
            $this->$user = $id;
        }
    }

    function checkAuth()
    {
    }
}
