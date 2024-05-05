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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $task_id = $_GET['id'];
    delete_task($mysqli, $task_id);
}

?>