<?php
if (isset($_GET['theme'])) {
    setcookie('theme', $_GET['theme'], time() + (365 * 24 * 60 * 60), '/');
}

include 'connectdb.php'; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="icon" href="image/diary.svg" type="image/svg+xml">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <img class="theme-toggle" src="image/month.svg" alt="topic" id="themeToggle">
        <h2>Авторизация</h2>
        <div class="auth">
            <form method="POST" autocomplete="off">
                <label>Логин</label><br>
                <input type="text" name="login" required><br>
                <label>Пароль</label><br>
                <input type="password" name="password" required><br>
                    <button type="submit">Войти</button><br>
            </form>
            <button onclick="window.location.href='index.php'">Назад</button><br>
            <h5>Еще нет аккаунта? <a href="signup.php">Зарегистрируйся!</a></h5><br>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $login = $_POST['login'];
                $password = md5($_POST['password']);

                auth($mysqli, $login, $password);
            }
            ?>
        </div>
    </div>
    <script src="tema.js"></script>
</body>
</html>