<?php

namespace advor\module;

Class Msg
{
    static private $name = 'msg';

    static function setMsg($msg)
    {
        $_SESSION[self::$name] = $msg;
    }


    static function popMsg()
    {
        if (isset($_SESSION[self::$name])) {
            $value = $_SESSION[self::$name];
            unset($_SESSION[self::$name]);
        } else {
            $value = '';
        }

        return $value;
    }

}

