<?php

session_start();

foreach ($_COOKIE as $key => $value) {
    setcookie($key, $value, time() - 2592000, '/');
}

unset($_SESSION['username']);
unset($_SESSION['password']);

session_destroy();
header("Location: ../auth/");
