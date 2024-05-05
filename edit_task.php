<?php
if (isset($_GET['theme'])) {
    setcookie('theme', $_GET['theme'], time() + (365 * 24 * 60 * 60), '/');
}

include 'connectdb.php';
require ("session.php");

if (!isset ($_SESSION["user"])) {
    echo "Укажите идентификатор пользователя.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status_id = $_POST['status_id'];
    $priority_id = $_POST['priority_id'];

    edit_task($mysqli, $name, $description, $status_id, $priority_id, $task_id);

}

$task_id = $_GET['id'];
$query = "SELECT * FROM tasks WHERE id=$task_id";
$result = mysqli_query($mysqli, $query);
$task = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование задачи</title>
    <link rel="icon" href="image/diary.svg" type="image/svg+xml">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
    <img class="theme-toggle" src="image/month.svg" alt="topic" id="themeToggle">
        <h2>Редактирование задачи</h2>
        <form method="POST" autocomplete="off">
            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
            <label for="task_name">Название задачи:</label><br>
            <input type="text" id="task_name" name="name" value="<?= $task['name'] ?>" required><br>
            <label for="description">Описание задачи:</label><br>
            <textarea id="description" name="description" required><?= $task['description'] ?></textarea><br>
            <label for="status">Статус:</label><br>
            <select id="status" name="status_id" required>
                <?php
                $status_result = mysqli_query($mysqli, "SELECT * FROM status");
                while ($status_row = mysqli_fetch_assoc($status_result)) {
                    $selected = ($status_row['id'] == $task['status_id']) ? "selected" : "";
                    echo '<option value="' . $status_row['id'] . '" ' . $selected . '>' . $status_row['name'] . '</option>';
                }
                ?>
            </select><br>

            <label for="priority">Приоритет:</label><br>
            <select id="priority" name="priority_id" required>
                <?php
                $priority_result = mysqli_query($mysqli, "SELECT * FROM priority");
                while ($priority_row = mysqli_fetch_assoc($priority_result)) {
                    $selected = ($priority_row['id'] == $task['priority_id']) ? "selected" : "";
                    echo '<option value="' . $priority_row['id'] . '" ' . $selected . '>' . $priority_row['name'] . '</option>';
                }
                ?>
            </select>
            <br>
            <button type="submit">Сохранить изменения</button>
        </form>

        <button class="back-btn" onclick="window.location.href='user.php'">Назад</button>
    </div>
    <script src="tema.js"></script>
</body>

</html>