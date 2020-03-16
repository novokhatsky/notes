<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['auth'])) {
        $login = htmlspecialchars($_POST['login']);
        $pass = htmlspecialchars($_POST['password']);
        $result_auth = $current_user->checkExists($login, $pass);

        if (is_array($result_auth) && count($result_auth)) {
            $id_user = new \advor\module\SessionVar(UID . 'id_user', $result_auth['id_user']);
            $key = new \advor\module\SessionVar(UID . 'key', $pass);

            header('Location: ' . BASE_URL);
            exit();
        }
    } else {
        header('Location: ' . BASE_URL);
        exit();
    }
}

require_once 'views/login.php';

