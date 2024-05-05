<?php
if (isset($_GET['theme'])) {
    setcookie('theme', $_GET['theme'], time() + (365 * 24 * 60 * 60), '/');
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Главная страница</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="image/diary.svg" type="image/x-icon">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <img class="theme-toggle" src="image/month.svg" alt="topic" id="themeToggle">
        <h2>Главная страница твоих заметок</h2>
        <div class="buttons">
            <a href="auth.php"><button>Авторизация</button></a>
            <a href="signup.php"><button>Регистрация</button></a>
        </div>
    </div>
    <script src="tema.js"></script>
</body>

</html>
