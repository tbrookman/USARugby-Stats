<?php
include_once './include_mini.php';

$ref= $_POST['ref'];
$num4 = $_POST['num4'];
$homec= $_POST['homec'];
$awayc = $_POST['awayc'];
$game_id = $_POST['game_id'];

$query = "UPDATE `games` SET ref_sign='$ref', 4_sign='$num4', home_sign='$homec', away_sign='$awayc' WHERE id = '$game_id'";
$result = mysql_query($query);
