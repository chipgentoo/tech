<?php

function get_list_news() {
    global $TechDB;
    $sql = "SELECT * FROM `tech`.`news` AS `news`";
    $result = $TechDB->query($sql);
    return mysqli_fetch_all($result);
}
