<?php

if (!isset($_COOKIE['username']) or ! isset($_COOKIE['password'])) {
    header('Location: ./auth/');
}

function get_title_post() {
    if (filter_input(INPUT_POST,'title')!='') {
        return filter_input(INPUT_POST, 'title');
    } else {
        return '';
    }
}

function get_notes_post() {
    if (filter_input(INPUT_POST,'notes')!='') {
        return filter_input(INPUT_POST, 'notes');
    } else {
        return '';
    }
}

function get_link_post() {
    if (filter_input(INPUT_POST,'link')!='') {
        return filter_input(INPUT_POST, 'link');
    } else {
        return '';
    }
}

$title = get_title_post();
$notes = get_notes_post();
$link = get_link_post();

if (($title != '') and ($notes != '')) {
    $sql="INSERT INTO `news` (`news_id`,`news_date`,`depart_id`,`news_title`,`news_note`,`news_link`)
            VALUES ('', CURDATE(), " . $_COOKIE['depart_id'] . ", '" . $title . "', '" . $notes . "', '".$link."')";
    $db = new TechDB();
    $query = $db->query($sql);
    header("Location: ./?page=news");
}
