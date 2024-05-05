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


$user_id = $session_user["id"];

if(isset($_GET['query']) && !empty($_GET['query']) || isset($_GET['date_order']) && !empty($_GET['date_order'])
    || isset($_GET['status']) && !empty($_GET['status']) || isset($_GET['priority']) && !empty($_GET['priority'])) {
    $query = $_GET['query'];
    $date_order = $_GET['date_order'];
    $status = $_GET['status'];
    $priority = $_GET['priority'];
    $result = search_task($mysqli, $user_id, $query, $date_order, $status, $priority);
} else {
    $result = show_task($mysqli, $user_id);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Личный кабинет</title>
    <link rel="icon" href="image/diary.svg" type="image/svg+xml">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <img class="theme-toggle" src="image/month.svg" alt="topic" id="themeToggle">
        <?php
        $user = getUserById($mysqli, $session_user["id"]);
        echo '<p class="welcome-message">Добро пожаловать в личный кабинет, <strong>' . $user['login'] . '</strong> !</p>';
        ?>
        <button class="logout-btn" onclick="window.location.href='logout.php'">Выйти</button>
        <button class="add-task-btn" onclick="window.location.href='add_tasks.php'">Добавить задачу</button>

        <div class="search-container">
            <form action="user.php" method="GET">
                <div class="search-row">
                    <input type="text" name="query" class="search-box" placeholder="Введите текст..." value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                    <button type="submit" class="search-button">Поиск</button>
                    <button type="button" class="reset-button" onclick="window.location.href='user.php'">Сбросить фильтры</button>
                </div>
                <div class="filter-row">
                    <select name="status">
                        <option value="">Статус</option>
                        <?php $selectedStatus = isset($_GET['status']) ? $_GET['status'] : ''; 
                            status($mysqli, $selectedStatus); 
                        ?>
                    </select>
                    <select name="priority">
                        <option value="">Приоритет</option>
                        <?php $selectedPriority = isset($_GET['priority']) ? $_GET['priority'] : ''; 
                            priority($mysqli, $selectedPriority); 
                        ?>
                    </select>
                    <select name="date_order">
                        <option value="asc" <?php echo isset($_GET['date_order']) && $_GET['date_order'] === 'asc' ? 'selected' : ''; ?>>По возрастанию</option>
                        <option value="desc" <?php echo isset($_GET['date_order']) && $_GET['date_order'] === 'desc' ? 'selected' : ''; ?>>По убыванию</option>
                    </select>
                </div>
            </form>
        </div>
        <table class="task-table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Статус</th>
                    <th>Приоритет</th>
                    <th>Дата создания</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td>" . $row["status_name"] . "</td>";
                    echo "<td>" . $row["priority_name"] . "</td>";
                    $beautifulDateTime = date('d.m.Y H:i', strtotime($row["date_creation"]));
                    echo "<td>" . $beautifulDateTime . "</td>";
                    echo "<td class='icon_table'>";
                    echo "<a href='edit_task.php?id=" . $row["id"] . "' class='action-link'><img src='image/editL.svg' alt='Редактировать' class='themeToggleEdit'></a>";
                    echo "<a href='delete_task.php?id=" . $row["id"] . "' class='action-link'><img src='image/deleteL.svg' alt='Удалить' class='themeToggleDelete'></a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="tema.js"></script>
</body>


</html>
