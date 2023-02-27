<?php

    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);


    $password = md5($password."wU1uIvC83swj");

    $mysql = new mysqli('localhost', 'vh366056_admin', 'admin_5057911762', 'vh366056_register_bd');
    $result = $mysql->query("SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'" );
    $user = $result->fetch_assoc();
    if($user === NULL) {
        echo "Такой пользователь не найден";
        exit();
    }

    setcookie('user', $user['name'], time() + 3600, "/");

    $mysql->close();

    header('Location: /');
?>