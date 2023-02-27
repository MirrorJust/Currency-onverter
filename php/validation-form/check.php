<?php

    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);

    if (mb_strlen($login) < 5 || mb_strlen($login) > 90) {
        echo "Недопустимая длина логина";
        exit();
    } elseif (mb_strlen($name) < 3 || mb_strlen($name) > 50) {
        echo "Недопустимая длина имени";
        exit();
    } elseif (mb_strlen($password) < 4 || mb_strlen($password) > 50) {
        echo "Длина пароля должна бытбь больше 4 символов";
        exit();
    }


    $password = md5($password."wU1uIvC83swj");

    $mysql = new mysqli('localhost', 'vh366056_admin', 'admin_5057911762', 'vh366056_register_bd');
    if ($mysqli->connect_error) {
        die('Ошибка подключения (' . $mysqli->connect_errno . ') '
         . $mysqli->connect_error);
    }
    $mysql->query("INSERT INTO `users`(`login`, `password`, `name`) VALUES('$login', '$password', '$name')");

    $mysql->close();

    header('Location: /');
?>