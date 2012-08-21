<?php
include_once ('./include_mini.php');

if(!isset($game_id) || !$game_id){$game_id=$_GET['gid'];}
if(!isset($team_id) || !$team_id){$team_id=$_GET['tid'];}

$outputs = array();

//Get our player ids from DB
$query = "SELECT * FROM `game_rosters` WHERE game_id = $game_id AND team_id = $team_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){

$numbers = array_filter(explode('-',$row['numbers']));
$players = array_filter(explode('-',$row['player_ids']));

}

//Turn our ids into names
foreach ($players as $player){
$outputs[$player]=playerName($player);
}

$i=1;
foreach ($outputs as $output => $name){
echo "{$numbers[$i]} - $name<br/>\n";
$i++;
}


?>