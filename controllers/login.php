<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['auth'])) {
        $login = htmlspecialchars($_POST['login']);
        $pass = htmlspecialchars($_POST['password']);

        $result_auth = $current_user->checkExists($login, $pass);
        if (count($result_auth)) {
            $id_current_user->setValue($result_auth['id_user']);
            header('Location: ' . BASE_URL);
            exit();
        }
    } else {
        header('Location: ' . BASE_URL);
        exit();
    }
}

require_once 'views/login.php';

