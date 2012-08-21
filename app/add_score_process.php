<?php
include_once ('./include_mini.php');

$player_id = $_POST['player'];
$game_id = $_POST['game_id'];
$type = $_POST['type'];
$minute = $_POST['minute'];

//to test if not an actual player was selected but just the team
$teamcount = substr_count($player_id,'team');

//if player_id contained 'team' we get the 5th character which is the team id.  Else use the player_id to get the team.
if($teamcount){
$team_id = substr($player_id,4);
$player_id=0;
}
else
{
$team_id = getTeam($player_id, $game_id);
}

if($_SESSION['user']){
$query = "INSERT INTO `game_events` VALUES ('','{$_SESSION['user']}','$game_id','$team_id','$player_id','$type','$minute')";
$result = mysql_query($query);

updateScore($game_id);
}
?>