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
    <title>Регистрация</title>
    <link rel="icon" href="image/diary.svg" type="image/svg+xml">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <img class="theme-toggle" src="image/month.svg" alt="topic" id="themeToggle">
        <h2>Регистрация</h2>
        <div class="signup">
            <form method="POST" autocomplete="off">
                <label>ФИО</label>
                <input type="text" name="name" required>
                <br>
                <label>Логин </label>
                <input type="text" name="login" required>
                <br>
                <label>Пароль </label>
                <input type="password" name="password" required><br>
                <button type="submit">Зарегистрироваться</button>
            </form>
            
            <button onclick="window.location.href='index.php'">Назад</button>

            <h5>Есть аккаунт? <a href="auth.php">Войти!</a></h5>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                $login = $_POST['login'];
                $password = $_POST['login'];
                $name = $_POST['name'];
                signup($mysqli, $name, $login, $password);
            }
            ?>
        </div>
    </div>
    <script src="tema.js"></script>
</body>
</html>
