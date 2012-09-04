<?php
include_once './include_mini.php';

if (!isset($game_id) || !$game_id) {$game_id=$_GET['id'];}

//get score for the game with id in url
//$query = "SELECT * FROM `games` WHERE id = $game_id";
//$result = mysql_query($query);
$game = get_game($game_id);
$home_id = $game['home_id'];
$away_id = $game['away_id'];
echo teamName($away_id)." - {$game['away_score']}<br/>";
echo teamName($home_id)." - {$game['home_score']}<br/>";
