<?php
include_once './include_mini.php';

$id = $_POST['id'];
$game_id = $_POST['game_id'];

$query = "DELETE FROM `game_events` WHERE id='$id'";
$result = mysql_query($query);
