<?php

if (isset($_POST['todo_content']) and filter_input(INPUT_POST, "todo_content") != '') {
    // $sql = "INSERT INTO `todo` (`todo_id`,`userid`,`todo_date`,`todo_content`,`todo_status`)
    //         VALUES ('', " . filter_input(INPUT_COOKIE, "userid") . " ,CURDATE(), '" . htmlspecialchars(filter_input(INPUT_POST, "todo_content")) . "', 0)";
    $sql = "INSERT INTO `todo` (`userid`,`todo_date`,`todo_content`,`todo_status`)
            VALUES (" . filter_input(INPUT_COOKIE, "userid") . " ,CURDATE(), '" . htmlspecialchars(filter_input(INPUT_POST, "todo_content")) . "', 0)";
    $db = new TechDB();
    $query = $db->query($sql);
    header("Location: ./?page=todo");
}
