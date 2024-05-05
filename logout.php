<?php

    if (isset($_GET['theme'])) {
        setcookie('theme', $_GET['theme'], time() + (365 * 24 * 60 * 60), '/');
    }

    session_start();
    session_destroy();
    header("Location: index.php");
    exit;
?>