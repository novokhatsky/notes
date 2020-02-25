<?php

$msg = new \advor\module\SessionVar(UID . 'msg');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['register'])) {
        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);
        $password2 = htmlspecialchars($_POST['password2']);

        if ((strlen($login) != 0) &&
            (strlen($password) != 0) &&
            ($password == $password2)) {
            // регистрируем
            $user = new \advor\models\User($db);
            $id_new_user = $user->register($login, $password);

            if ($id_new_user == -1) {
                
                // проверим код ошибки 1062 - пользователь существует
                if ($db->errInfo[1] == 1062) {
                    $msg->setValue('пользователь с таким именем существует');
                } else {
                    $msg->setValue('ошибка регистрации');
                }
            } else {
                $msg->setValue('пользователь зарегистрирован, можно войти');
                header('Location: ' . BASE_URL);
                exit();
            }
        } else {
            $msg->setValue('ошибка входных данных');
        }
    } else {
        header('Location: ' . BASE_URL);
        exit();
    }
}

require_once 'views/registration.php';

