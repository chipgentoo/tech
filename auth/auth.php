<?php

session_start();
$db = new mysqli("localhost", "tech", "tech", "tech");
$query = "SELECT * FROM `auth` WHERE `username`='" . filter_input(INPUT_POST, 'username') . "' AND `password`='" . filter_input(INPUT_POST, 'password') . "'";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) === 1) {
    $session = mysqli_fetch_assoc($result);
    foreach ($session as $key => $value) {
        setcookie($key, $value, time() + 2592000, '/');
    }
} else {
    $_SESSION['error'] = "Ошибка авторизации! Проверьте правильность ввода.";
}
header("Location: ..");
exit;
