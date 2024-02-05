<?php

include_once ("validateSession.php");

if (!$_SESSION['admin']) {
    header("location:../../design/index.html");
}

?>