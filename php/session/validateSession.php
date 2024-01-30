<?php

session_start();

if (!isset($_SESSION['idSession'])) {
    header('location: ../../index.html');
}

?>