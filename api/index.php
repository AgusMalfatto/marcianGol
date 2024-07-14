<?php
session_start();

if (!isset($_SESSION['idSesion'])) {
    header('Location: design/user/login.php');
    exit();
} else {
    header('Location: design/foro/home.php');
    exit();
}
?>
