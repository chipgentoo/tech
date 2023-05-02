<?php

if (isset($_POST['note']) and filter_input(INPUT_POST, "note") != '') {
    $title = htmlspecialchars(mb_strimwidth(filter_input(INPUT_POST, "note"), 0, 128));
    //$sql = "INSERT INTO `requests` (`request_id`,`request_date`,`depart_id`,`request_title`,`request_note`,`request_status`)
    //        VALUES ('', CURDATE(), " . $_COOKIE['depart_id'] . ", '" . $title . "', '" . htmlspecialchars($_POST['note']) . "', '')";
    $sql = "INSERT INTO `requests` (`request_id`,`request_date`,`depart_id`,`request_title`,`request_note`,`request_status`)
            VALUES ('', CURRENT_TIMESTAMP , " . $_COOKIE['depart_id'] . ", '" . $title . "', '" . htmlspecialchars($_POST['note']) . "', '')";
    $db = new TechDB();
    $query = $db->query($sql);
    header("Location: ./?page=requests&request=list");
}
