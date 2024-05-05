<?php
if (isset($_GET['theme'])) {
    setcookie('theme', $_GET['theme'], time() + (365 * 24 * 60 * 60), '/');
}

include 'connectdb.php';
require ("session.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление задачи</title>
    <link rel="icon" href="image/diary.svg" type="image/svg+xml">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <img class="theme-toggle" src="image/month.svg" alt="topic" id="themeToggle">
        <h2>Добавление задачи</h2>
        <form method="POST" autocomplete="off">
            <label for="task_name">Название задачи:</label><br>
            <input type="text" id="task_name" name="task_name" required><br>

            <label for="description_name">Описание задачи:</label><br>
            <input type="text" id="description_name" name="description_name" required><br>

            <label for="status">Статус:</label><br>
            <select id="status" name="status">
                <?php
                $status_result = mysqli_query($mysqli, "SELECT * FROM status");
                while ($status_row = mysqli_fetch_assoc($status_result)) {
                    echo '<option value="' . $status_row['id'] . '">' . $status_row['name'] . '</option>';
                }
                ?>
            </select><br>

            <label for="priority">Приоритет:</label><br>
            <select id="priority" name="priority">
                <?php
                $priority_result = mysqli_query($mysqli, "SELECT * FROM priority");
                while ($priority_row = mysqli_fetch_assoc($priority_result)) {
                    echo '<option value="' . $priority_row['id'] . '">' . $priority_row['name'] . '</option>';
                }
                ?>
            </select><br>

            <button type="submit">Добавить задачу</button><br>
        </form>

        <button class="back-btn" onclick="window.location.href='user.php'">Назад</button>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $session_user["id"];
            $name = mysqli_real_escape_string($mysqli, $_POST["task_name"]);
            $description = mysqli_real_escape_string($mysqli, $_POST["description_name"]);
            $status_id = mysqli_real_escape_string($mysqli, $_POST["status"]);
            $priority_id = mysqli_real_escape_string($mysqli, $_POST["priority"]);

            add_tasks($mysqli, $user_id, $name, $description, $status_id, $priority_id);
        }
        ?>

    </div>
    <script src="tema.js"></script>
</body>
</html>