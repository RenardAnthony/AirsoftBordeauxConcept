<?php

    $choix_cookie = $_GET['cookiechoix'];

    setcookie('accept_cookie', $choix_cookie, time() + 30*24*3600, '/', null, false, false);

    if (isset($_SERVER['HTTP_REFERER']) AND !empty($_SERVER['HTTP_REFERER'])){
        header('Location: '.$_SERVER['HTTP_REFERER']);
    } else {
        header('Location: ../index.php');
    }
?>