<?php
include_once './include_mini.php';

$name = mysql_real_escape_string($request->get('name'));
$type = mysql_real_escape_string($request->get('type'));
$max_event = mysql_real_escape_string($request->get('max_event'));
$max_match = mysql_real_escape_string($request->get('max_match'));
$start_date = mysql_real_escape_string($request->get('start_date'));
$end_date = mysql_real_escape_string($request->get('end_date'));
$top_groups = implode(',', $request->get('top_groups'));
$result = $db->addCompetition(array(
    'id' => '',
    'user_create' => $_SESSION['user'],
    'name' => $name,
    'start_date' => $start_date,
    'end_date' => $end_date,
    'type' => $type,
    'max_event' => $max_event,
    'max_game' => $max_match,
    'hidden' => '0',
    'top_groups' => $top_groups
    ));

header("Location: http://" . $_SERVER['HTTP_HOST']);
