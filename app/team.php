<?php
include_once ('./include.php');

$team_id = $_GET['id'];

$query = "SELECT name FROM `teams` WHERE id = $team_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){
echo "<h1>{$row['name']}</h1>";
}

echo "<h2>Event Rosters</h2>";
//Get the rosters for this team
include_once ('./team_event_rosters.php');
echo "<br/>";

echo "<h2>Game Rosters</h2>";
//Get the rosters for this team
include_once ('./team_game_rosters.php');
echo "<br/>";

include_once ('./footer.php');
mysql_close();
?>