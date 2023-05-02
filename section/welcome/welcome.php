<?php

if (!isset($_COOKIE['username']) or ! isset($_COOKIE['password'])) {
    header('Location: ./auth/');
}
