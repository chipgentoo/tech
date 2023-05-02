<?php

if (isset($_POST['todo_content']) and filter_input(INPUT_POST, "todo_content") != '') {
    if (isset($_POST['update']) and filter_input(INPUT_POST, "update") != '' and filter_input(INPUT_POST, "update") != NULL) {
        $sql = "UPDATE `todo` SET `todo_content`=\"" . filter_input(INPUT_POST, "todo_content") . "\" WHERE todo_id=" . filter_input(INPUT_GET, "tid");
        $db = new TechDB();
        $query = $db->query($sql);
    }
    if (isset($_POST['end']) and filter_input(INPUT_POST, "end") != '' and filter_input(INPUT_POST, "end") != NULL) {
        $sql = "UPDATE `todo` SET `todo_status`=1 WHERE todo_id=" . filter_input(INPUT_GET, "tid");
        $db = new TechDB();
        $query = $db->query($sql);
        //header("Location: ./?page=todo");
    }
    header("Location: ./?page=todo");
}

function get_todo_by_id($tid) {
    global $TechDB;
    $sql = "SELECT
                `todo`.`todo_id`,
                `auth`.`username`,
                `todo`.`todo_date`,
                `todo`.`todo_content`,
                `todo`.`todo_status`
            FROM   `tech`.`todo` AS `todo`, `tech`.`auth` AS `auth`
            WHERE  `todo`.`todo_id`=" . $tid . " AND `todo`.`userid`=`auth`.`userid`";
    $result = $TechDB->query($sql);
    return mysqli_fetch_assoc($result);
}
