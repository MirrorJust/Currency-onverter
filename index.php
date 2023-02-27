<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>Форма регистрации / авторизации </title>
</head>
<body>
    <div class="container mt-4">
        <?php 
            if (!isset($_COOKIE['user'])):
        ?>

        <div class="row">
            <div class="col">
                <h1>Форма регистрации</h1>
                <form action="/php/validation-form/check.php" method="post">
                    <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин">
                    <br>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Введите имя">
                    <br>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль">
                    <br>
                    <button class="btn btn-success" type="submit">Зарегестрировать</button>
                </form>
            </div>
            <div class="col">
                <h1>Форма авторизации</h1>
                <form action="/php/validation-form/auth.php" method="post">
                    <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин">
                    <br>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль">
                    <br>
                    <button class="btn btn-success" type="submit">Авторизоваться</button>
                </form>
            </div>
        </div>
        
        <?php else: ?>
            <p><h2>Привет, <?=$_COOKIE['user']?>!</h2> Чтобы выйти нажмите <a href="/php/exit.php">здесь</a></p>
            <p><a href="/php/api_cb/update.php">Обновить курсы валют</a></p>
            <!-- <p><a href="/php/api_cb/exchange_course.php">Добавить курсы валют</a></p> -->
            <?php $mysql = new mysqli('localhost', 'vh366056_admin', 'admin_5057911762', 'vh366056_register_bd');
                $query = "SELECT `name`, `nominal`, `in_rubles` FROM `exchange_rates`";
                $result = $mysql->query($query);
                $mysql->close();
            ?>
        <div class="row">
            <div class="col">
                <form method="post">
                    <p>Выберите валюту:</p>
                    <select name="list-currency" id="list-currency-id">
                    <?php  while ($row = $result->fetch_assoc()): ?>
                            <option><?php echo $row['name'];?></option>
                    <?php endwhile ; ?>
                    </select>
                    <br>
                    <br>
                    <p>Введите количество:</p>
                    <input type="text" name="count_exchange" id="count_foreign" name="count">
                    <br>
                    <br>
                    <button name="to_rubles"> Конверитровать в рубли</button>
                </form>
            </div>
            
            <div class="col">
                <form method="post">
                    <p>Введите сумму рублей для конвертации:</p>
                    <input type="text" name="count_exchange" id="count_rub" name="count">
                    <br>
                    <br>
                    <p>Выберите валюту:</p>
                    <select name="list-currency-two" id="list-currency-id-two">
                    <?php $mysql = new mysqli('localhost', 'vh366056_admin', 'admin_5057911762', 'vh366056_register_bd');
                        $query = "SELECT `name`, `nominal`, `in_rubles` FROM `exchange_rates`";
                        $result = $mysql->query($query);
                        $mysql->close();
                    ?>
                    <?php  while ($row = $result->fetch_assoc()): ?>
                            <option><?php echo $row['name'];?></option>
                    <?php endwhile ; ?>
                    
                    </select>
                    <br>
                    <br>

                    <button name="to_foreign"> Конверитровать в рубли</button>
                </form>
            </div>

            <?php if(isset($_POST['to_rubles'])): ?>
                <?php $mysql = new mysqli('localhost', 'vh366056_admin', 'admin_5057911762', 'vh366056_register_bd');
                    $selectOption = $_POST['list-currency'];
                    $query = "SELECT `name`, `nominal`, `in_rubles` FROM `exchange_rates` WHERE `name` = '$selectOption'";
                    $result = $mysql->query($query);
                    $row = $result->fetch_assoc();
                    $mysql->close();
                ?>

                <br>
                <p class="result-paragraph"><?php
                    $count_exchange = $_POST['count_exchange'];
                    $exhancge_course = $row['in_rubles'] / $row['nominal'];
                    $final_value = $exhancge_course * $count_exchange;
                    echo 'Обменяв ' . $count_exchange . ' ' .  $row['name'] .  ' на рубли, вы получите ' . $final_value . ' рублей';  
                ?></p>
            <?php endif ;?>

            <?php if(isset($_POST['to_foreign'])): ?>
                <?php $mysql = new mysqli('localhost', 'vh366056_admin', 'admin_5057911762', 'vh366056_register_bd');
                    $selectOption = $_POST['list-currency-two'];
                    $query = "SELECT `name`, `nominal`, `in_rubles` FROM `exchange_rates` WHERE `name` = '$selectOption'";
                    $result = $mysql->query($query);
                    $row = $result->fetch_assoc();
                    $mysql->close();
                ?>

                <br>
                <p class="result-paragraph"><?php
                    $count_exchange = $_POST['count_exchange'];
                    $exhancge_course = $row['in_rubles'] / $row['nominal'];
                    $final_value = round(($count_exchange / $exhancge_course), 2);
                    echo 'Обменяв ' . $count_exchange . ' рублей на ' .  $row['name'] .  ' , вы получите ' . $final_value . ' ' . $row['name'];  
                ?></p>
            <?php endif ;?>
        </div>
        <?php endif ;?>

            
    </div>

</body>
</html>