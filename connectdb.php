<?php

if (isset($_GET['theme'])) {
    setcookie('theme', $_GET['theme'], time() + (365 * 24 * 60 * 60), '/');
}


define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'db_4sem');

// Создание объекта подключения MySQLi
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Проверка соединения
if ($mysqli->connect_error) {
    die ("Ошибка подключения: " . $mysqli->connect_error);
}

function auth($mysqli, $login, $password)
{
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE login=? AND password=?");
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows == 0) {
        echo '<div class="help">';
        echo '<p>Такой пользователь не существует.</p>';
        echo '</div>';
    } else {
        $row = $result->fetch_assoc();
        if ($row['login'] == $login && $row['password'] == $password) {
            session_start();
            $_SESSION["user"] = $row;
            header("Location: user.php");
        } else {
            echo '<div class="help">';
            echo '<p>Неверный логин или пароль</p>';
            echo '</div>';
        }

        $stmt->close();
    }
}

function signup($mysqli, $name, $login, $password)
{
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE login=?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $stmt = $mysqli->prepare("INSERT INTO users (name, login, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $login, md5($password));
        $stmt->execute();

        header("Location: auth.php");
    } else {
        echo '<p>Такой пользователь уже существует</p>';
    }
}

function show_task($mysqli, $user_id)
{
    $stmt = $mysqli->prepare("SELECT tasks.id, tasks.name, tasks.description, tasks.date_creation, status.name AS status_name, priority.name AS priority_name
          FROM tasks JOIN status ON tasks.status_id = status.id JOIN priority ON tasks.priority_id = priority.id
          WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
}

function search_task($mysqli, $user_id, $query, $date_order, $status, $priority)
{
    $bindParams = array();

    $sql = "SELECT tasks.id, tasks.name, tasks.description, tasks.date_creation, status.name AS status_name, priority.name AS priority_name
    FROM tasks 
    JOIN status ON tasks.status_id = status.id 
    JOIN priority ON tasks.priority_id = priority.id
    WHERE tasks.user_id = ?";

    $bindParams[] = $user_id;
    $bindTypes = "i";

    if (!empty($query)) {
        $query = strtolower($query);
        $sql .= " AND (LOWER(tasks.name) LIKE ? OR LOWER(tasks.description) LIKE ?)";
        $bindParams[] = "%$query%";
        $bindParams[] = "%$query%";
        $bindTypes .= "ss";
    }
    
    if (!empty($status)) {
        $sql .= " AND status.id = ?";
        $status = intval($status);
        $bindParams[] = $status;
        $bindTypes .= "i";
    }

    if (!empty($priority)) {
        $sql .= " AND priority.id = ?";
        $priority = intval($priority);
        $bindParams[] = $priority;
        $bindTypes .= "i";
    }

    $sql .= " ORDER BY tasks.date_creation $date_order";

    $stmt = $mysqli->prepare($sql);

    if (!empty($bindParams)) {
        $stmt->bind_param($bindTypes, ...$bindParams);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
    
}



function getUserById($mysqli, $userId) {
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE id=?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


function add_tasks($mysqli, $user_id, $name, $description, $status_id, $priority_id)
{
    date_default_timezone_set('Europe/Moscow');
    $currentDateTime = date('Y-m-d H:i:s');
    $stmt = $mysqli->prepare("INSERT INTO tasks (user_id, name, description, status_id, priority_id, date_creation) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssis", $user_id, $name, $description, $status_id, $priority_id, $currentDateTime);

    if ($stmt->execute()) {
        header("Location: user.php");
        exit;
    } else {
        echo "Ошибка: " . $mysqli->error;
    }
}

function delete_task($mysqli, $task_id)
{
    $stmt = $mysqli->prepare("DELETE FROM tasks WHERE id=?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    header("Location: user.php");
}

function edit_task($mysqli, $name, $description, $status_id, $priority_id, $task_id)
{
    $stmt = $mysqli->prepare("UPDATE tasks SET name=?, description=?, status_id=?, priority_id=? WHERE id=?");
    $stmt->bind_param("ssiii", $name, $description, $status_id, $priority_id, $task_id);
    $stmt->execute();
    header("Location: user.php");
}

function status ($mysqli, $selectedStatus)
{
    $status_query = mysqli_query($mysqli, "SELECT id, name FROM status");
    while ($row = mysqli_fetch_assoc($status_query)) {
        $selected = ($row['id'] == $selectedStatus) ? 'selected' : '';
        echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
    }
}

function priority ($mysqli, $selectedPriority)
{
    $priority_query = mysqli_query($mysqli, "SELECT id, name FROM priority");
    while ($row = mysqli_fetch_assoc($priority_query)) {
        $selected = ($row['id'] == $selectedPriority) ? 'selected' : '';
        echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
    }
}
?>