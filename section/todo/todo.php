<?php

if (!isset($_COOKIE['username']) or ! isset($_COOKIE['password'])) {
    header('Location: ./auth/');
}

function get_action_script() {
    $action = NULL;
    if (isset($_GET['action']) and filter_input(INPUT_GET, 'action') != NULL) {
        $action = '.' . filter_input(INPUT_GET, 'action');
    } else {
        $action = '.list';
    }
    include_once 'todo' . $action . '.php';
}

function get_count_todo() {
    global $TechDB;
    $sql = "SELECT count(*) AS `count` FROM `todo`";
    $result = $TechDB->query($sql);
    return mysqli_fetch_all($result);
}

get_action_script();
