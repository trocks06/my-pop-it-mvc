<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pop it MVC</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {background-color: bisque}
        header { padding-top: 36px; background-color: burlywood; height: 100px}
        nav { padding: 0 10px; font-size: 24px;  display: flex; justify-content: space-between }
        a { text-decoration: none; color: black}
        main { font-size: 32px; }
        .buttons { margin-top: 34px; display: flex; gap: 50px; justify-content: center}
        .buttons-left {display: flex; flex-direction: column; gap: 28px}
        .buttons-right {display: flex; align-items: center; gap: 20px; justify-content: center; margin-top: 34px}
        .buttons-left > a {text-align: center; width: 472px; border: black solid 2px; padding: 5px; background-color: darksalmon;}
        .buttons-right > a, .count-button {border: black solid 2px; padding: 5px; background-color: darksalmon}
        .data {margin-top: 34px; display: flex; flex-direction: column; margin-bottom: 34px}
        .column {display: flex; justify-content: center; height: fit-content}
        .column > div {  display: flex; justify-content: center; align-items: center; text-align: center; border: black solid 2px; min-height: 100px; background-color: darksalmon}
        img {border: black solid 2px}
        .id { width: 100px}
        .fio { width: 700px}
        .date-of-birth { width: 300px}
        .phone-numbers { width: 300px}
        .department { width: 300px}
        .search{border: black solid 2px; background-color: darksalmon; padding: 10px; display: flex; gap: 10px; align-items: center; height: 100px}
        .search > form {display: flex; gap: 10px; align-items: center}
        .search-field {border: black solid 2px; width: 500px; font-size: 24px}
        .search-button {padding: 10px; font-size: 24px; background-color: bisque}
        main > h2, h3 {text-align: center; margin-top: 34px}
        main > form {margin: 0 auto; margin-top: 34px; display: flex; flex-direction: column; align-items: center; gap: 20px; justify-content: space-between; width: fit-content;}
        main > form > label {display: flex; justify-content: space-between; gap: 20px; width: 100%; background-color: burlywood; border: black solid 2px; padding: 10px; align-items: center}
        main > form > label > input, button, select { padding: 10px; background-color: darksalmon; font-size: 24px; border: black solid 1px}
    </style>
</head>
<body>
<header>
    <nav>
        <a href="<?= app()->route->getUrl('/hello') ?>">Главная</a>
        <?php
        if (!app()->auth::check()):
            ?>
            <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
            <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>
        <?php
        else:
            ?>
            <a href="<?= app()->route->getUrl('/subscribers') ?>">Абоненты</a>
            <a href="<?= app()->route->getUrl('/phones') ?>">Телефоны</a>
            <a href="<?= app()->route->getUrl('/rooms') ?>">Помещения</a>
            <a href="<?= app()->route->getUrl('/departments') ?>">Подразделения</a>
            <a href="<?= app()->route->getUrl('/users') ?>">Системные администраторы</a>
            <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth::user()->login ?>)</a>
        <?php
        endif;
        ?>
    </nav>
</header>
<main>
    <?= $content ?? '' ?>
</main>

</body>
</html>