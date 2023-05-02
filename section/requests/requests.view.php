<?php

function get_note_id($rid) {
    global $TechDB;
    $sql = "SELECT
                `requests`.`request_id`,
                `requests`.`request_date`,
                `requests`.`request_note`,
                `requests`.`request_status`,
                `requests`.`request_shot`,
                `requests`.`request_comment`,
                `depart`.`depart_sn`
            FROM   `tech`.`requests` AS `requests`, `tech`.`depart` AS `depart`
            WHERE  `requests`.`request_id`=" . $rid . " AND `depart`.`depart_id` = `requests`.`depart_id`";
    $result = $TechDB->query($sql);
    return mysqli_fetch_assoc($result);
}

function set_status_id($rid, $status, $shot, $comment = "") {
    global $TechDB;
    $sql = "";
    if ($status == 3 AND ( $comment == "" OR $comment == NULL)) {
        $comment = "Без причины";
    } else {
        $comment = "";
    }
    if (get_status_id($rid)['request_status'] == 0) {
        $sql = "UPDATE `requests` SET `request_status`=" . $status . ",`request_shot`='" . $shot . "',`request_comment`='" . $comment . "' WHERE `request_id`=" . $rid;
    } else {
        $sql = "UPDATE `requests` SET `request_status`=" . $status . ",`request_comment`='" . $comment . "' WHERE `request_id`=" . $rid;
    }
    echo '$sql = '.$sql.'<br>';
    $TechDB->query($sql);
}

function get_status_id($rid) {
    global $TechDB;
    $sql="";
    $sql="SELECT `request_status` FROM `requests` WHERE `request_id`=" . $rid;
    $result=$TechDB->query($sql);
    return mysqli_fetch_assoc($result);
}

function del_request_id($id) {
    global $TechDB;
    $sql = "DELETE FROM `requests` WHERE `request_id`=" . $id;
    $TechDB->query($sql);
}

if (isset($_POST['status']) and filter_input(INPUT_POST, 'status') != NULL) {
    if (isset($_GET['rid']) and filter_input(INPUT_GET, "rid") != NULL) {
        set_status_id(filter_input(INPUT_GET, "rid"), filter_input(INPUT_POST, "status"), filter_input(INPUT_COOKIE, "shot"), filter_input(INPUT_POST, "comment"));
        header("Location: ./?page=requests");
    }
}

if (isset($_POST['cancel']) and filter_input(INPUT_POST, 'cancel') == 1) {
    if (isset($_GET['rid']) and filter_input(INPUT_GET, "rid") != NULL) {
        del_request_id(filter_input(INPUT_GET, "rid"));
        header("Location: ./?page=requests");
    }
}