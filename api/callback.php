<?php

session_start();

if (isset($_GET['code']) && !empty($_GET['code'])) {

    $_SESSION['access_token'] = $_GET['code'];
    header('Location: ../home.php');

} else {
    header('Location: index.php');
}

exit();