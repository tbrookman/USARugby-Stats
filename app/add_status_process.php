<?php
include_once './include_mini.php';

$game_id = $_POST['game_id'];
$status = mysql_real_escape_string($_POST['status']);

$query = sprintf("UPDATE `games` SET status = '%s' WHERE id = %d", $status, $game_id);
$result = mysql_query($query);
