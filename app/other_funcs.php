<?php
//used to get a players team in a game for adding a scoring event
//we look for the player id in the players list
//must use !== in case its at the 0 spot
function getTeam($player_id, $game_id){

$query = "SELECT * FROM `game_rosters` WHERE game_id = '$game_id'";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){

if (strpos($row['player_ids'], "-$player_id-")!==false)
return ($row['team_id']);

}
}


//get event value to update score
function getValue($type){

$query = "SELECT value FROM `event_types` WHERE event_id = '$type'";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){

return ($row['value']);

}
}


//when we add a score we need to update the game score
function updateScore($game_id){

//first get the id's of the home and away teams
$query = "SELECT * FROM `games` WHERE id = '$game_id'";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){
$home_id = $row['home_id'];
$away_id = $row['away_id'];
}

//get total home team points using getValue function
$query = "SELECT * FROM `game_events` WHERE game_id = '$game_id' AND type<10 AND team_id='$home_id'";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){
$homep = $homep+getValue($row['type']);
}

//get total away team points using getValue function
$query = "SELECT * FROM `game_events` WHERE game_id = '$game_id' AND type<10 AND team_id='$away_id'";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){
$awayp = $awayp+getValue($row['type']);
}

//update score
$query = "UPDATE `games` SET home_score='$homep', away_score='$awayp' WHERE id = '$game_id'";
$result = mysql_query($query);
}


function  pExists($id){
$query = "SELECT id FROM `players` WHERE fsi_id = $id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){
if($row['id']){return true;}
else
{return false;}
}
}


function  tExists($id){
$query = "SELECT id FROM `teams` WHERE fsi_id = $id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){
if($row['id']){return true;}
else
{return false;}
}
}
?>