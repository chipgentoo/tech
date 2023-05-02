<?php

function get_filter_sql() {
    $sql = "SELECT `todo_id`,`userid`,`todo_date`,`todo_content`,`todo_status` FROM `tech`.`todo` AS `todo` WHERE  `todo`.`userid` = " . filter_input(INPUT_COOKIE, "userid");
    $sql = $sql . " ORDER BY `todo`.`todo_status` ASC, `todo`.`todo_date` DESC";
    return $sql;
}

function get_count_page() {
    global $TechDB;
    $sql = get_filter_sql();
    $result = $TechDB->query($sql);
    return ceil(mysqli_num_rows($result) / $_SESSION['filter_todo']['count']);
}

function get_list_todo() {
    if (get_count_page() < $_SESSION['filter_todo']['page']) {
        $_SESSION['filter_todo']['page'] = 1;
    }
    global $TechDB;
    $sql = get_filter_sql() . " LIMIT " . ($_SESSION['filter_todo']['page'] - 1) * $_SESSION['filter_todo']['count'] . "," . $_SESSION['filter_todo']['count'];
    $result = $TechDB->query($sql);
    //echo $sql;
    return mysqli_fetch_all($result);
}

function reset_filter_todo_in_session() {
    $_SESSION['filter_todo']['status'] = "";
    $_SESSION['filter_todo']['count'] = 25;
    $_SESSION['filter_todo']['page'] = 1;
}

function save_filter_todo_in_session() {
    if (isset($_SESSION['filter_todo'])) {
        foreach ($_POST as $key => $value) {
            $_SESSION['filter_todo'][$key] = $value;
        }
    } else {
        reset_filter_todo_in_session();
    }
}

//------------------------------------------------------------------------------

save_filter_todo_in_session();
