<?php
if (isset($_GET['theme'])) {
    setcookie('theme', $_GET['theme'], time() + (365 * 24 * 60 * 60), '/');
}

session_start();
$session_user = (isset($_SESSION["user"])) ? $_SESSION["user"] : false;

?>