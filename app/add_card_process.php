<?php
include_once ('./include_mini.php');

$player_id = $_POST['cardplayer'];
$game_id = $_POST['card_game_id'];
$type = $_POST['cardtype'];
$minute = $_POST['cardmin'];
$team_id = getTeam($player_id, $game_id);

$query = "INSERT INTO `game_events` VALUES ('','{$_SESSION['user']}','$game_id','$team_id','$player_id','$type','$minute')";
$result = mysql_query($query);

?>