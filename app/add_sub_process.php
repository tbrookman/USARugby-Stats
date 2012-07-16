<?php
include_once ('./include_mini.php');

$player_on_id = $_POST['player_on'];
$player_off_id = $_POST['player_off'];
$game_id = $_POST['game_id'];
$type = $_POST['subtype'];
$typeplus = $_POST['subtype']+1;
$minute = $_POST['submin'];
$team_id = getTeam($player_on_id, $game_id);

$query = "INSERT INTO `game_events` VALUES ('','{$_SESSION['user']}','$game_id','$team_id','$player_off_id','$type','$minute')";
$result = mysql_query($query);

$query1 = "INSERT INTO `game_events` VALUES ('','{$_SESSION['user']}','$game_id','$team_id','$player_on_id','$typeplus','$minute')";
$result1 = mysql_query($query1);

?>