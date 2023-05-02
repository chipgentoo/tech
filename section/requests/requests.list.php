<?php

function get_list_departs() {
    global $TechDB;
    $sql = "SELECT `depart_id`, `depart_sn` FROM `tech`.`depart` AS `depart`";
    $result = $TechDB->query($sql);
    return mysqli_fetch_all($result);
}

function sql_filter_request_by_reqid($reqid = NULL) {
    $sql = "";
    if ($reqid == "all") {
        $reqid = NULL;
    }
    if ($reqid != NULL) {
        $sql = " AND `requests`.`request_id` = " . $reqid;
    }
    return $sql;
}

function sql_filter_request_by_segm($loc = NULL) {
    $sql = "";
    if ($loc == "all" OR $loc == NULL) {
        $loc = NULL;
    } else {
        $sql = " AND `location`.`location_en` = '" . $loc . "'";
    }
    return $sql;
}

function sql_filter_request_by_date($date1 = NULL, $date2 = NULL) {
    $sql_d1 = "";
    $sql_d2 = "";
    if ($date1 != NULL) {
        $sql_d1 = " AND `requests`.`request_date` >= '" . date("Y-m-d", strtotime($date1)) . "'";
    }
    if ($date2 != NULL) {
        $sql_d2 = " AND `requests`.`request_date` <= '" . date("Y-m-d", strtotime($date2)) . "'";
    }
    return $sql_d1 . $sql_d2;
}

function sql_filter_request_by_depart($depart = NULL) {
    $sql = "";
    if ($depart == "all") {
        $depart = NULL;
    }
    if (filter_input(INPUT_COOKIE, 'admin') == 1) {
        if ($depart != NULL) {
            $sql = " AND `requests`.`depart_id` = " . $depart;
        }
    } else {
        $sql = " AND `requests`.`depart_id` = " . filter_input(INPUT_COOKIE, 'depart_id');
    }
    return $sql;
}

function sql_filter_request_by_status($status = NULL) {
    $sql = "";
    if ($status == "all" OR $status == NULL) {
        //$sql = " AND `requests`.`request_status` != 2 ";
        $sql = " AND `requests`.`request_status` <= 2 ";
    } else {
        $sql = " AND `requests`.`request_status` = " . $status;
    }
    return $sql;
}

function sql_filter_request_by_note($note = NULL) {
    $sql = "";
    if ($note == "" OR $note == NULL) {
        return $sql;
    } else {
        $sql = " AND `requests`.`request_note` LIKE \"%" . $note . "%\" ";
    }
    return $sql;
}

function reset_filter_in_session() {
    $_SESSION['filter']['reqid'] = "";
    $_SESSION['filter']['loc'] = "";
    $_SESSION['filter']['date1'] = "";
    $_SESSION['filter']['date2'] = "";
    $_SESSION['filter']['depart'] = "";
    $_SESSION['filter']['status'] = "";
    $_SESSION['filter']['reqnote'] = "";
    $_SESSION['filter']['count'] = 25;
    $_SESSION['filter']['page'] = 1;
}

function save_filter_in_session() {
    if (isset($_POST['loc'])) {
        $_SESSION['filter']['page'] = 1;
    }
    if (isset($_SESSION['filter'])) {
        foreach ($_POST as $key => $value) {
            $_SESSION['filter'][$key] = $value;
        }
    } else {
        reset_filter_in_session();
    }
}

function get_filter_sql() {
    $sql = "SELECT `requests`.`request_id`,
                   `requests`.`request_date`,
                   `depart`.`depart_sn`,
                   `requests`.`request_title`,
                   `requests`.`request_note`,
                   `requests`.`request_status`,
                   `requests`.`request_shot`,
                   `requests`.`request_comment`
            FROM   `tech`.`depart` AS `depart`,
                   `tech`.`location` AS `location`,
                   `tech`.`requests` AS `requests`
            WHERE  `depart`.`location_id` = `location`.`location_id`
            AND    `requests`.`depart_id` = `depart`.`depart_id`";
    if ($_SESSION['filter']['reqid'] != NULL OR $_SESSION['filter']['reqid'] != "") {
        $sql = $sql . sql_filter_request_by_reqid($_SESSION['filter']['reqid']);
        return $sql;
    }
    //if ($_SESSION['filter']['reqnote'] != NULL OR $_SESSION['filter']['reqnote'] != "") {
    $sql = $sql . sql_filter_request_by_note($_SESSION['filter']['reqnote']);
    //    return $sql;
    //}
    $sql = $sql . sql_filter_request_by_segm($_SESSION['filter']['loc']);
    $sql = $sql . sql_filter_request_by_date($_SESSION['filter']['date1'], $_SESSION['filter']['date2']);
    $sql = $sql . sql_filter_request_by_depart($_SESSION['filter']['depart']);
    $sql = $sql . sql_filter_request_by_status($_SESSION['filter']['status']);
    $sql = $sql . " ORDER BY `requests`.`request_status` ASC, `requests`.`request_date` DESC";
    return $sql;
}

function get_count_page() {
    global $TechDB;
    $sql = get_filter_sql();
    $result = $TechDB->query($sql);
    return ceil(mysqli_num_rows($result) / $_SESSION['filter']['count']);
}

function get_list_requests() {
    if (get_count_page() < $_SESSION['filter']['page']) {
        $_SESSION['filter']['page'] = 1;
    }
    global $TechDB;
    $sql = get_filter_sql() . " LIMIT " . ($_SESSION['filter']['page'] - 1) * $_SESSION['filter']['count'] . "," . $_SESSION['filter']['count'];
    $result = $TechDB->query($sql);
    //echo $sql;
    return mysqli_fetch_all($result);
}

//------------------------------------------------------------------------------

save_filter_in_session();
