<?php
include_once ('./include.php');

$comp_id = $_GET['id'];

$query = "SELECT * FROM `comps` WHERE id = $comp_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){
echo "<h1>{$row['name']}</h1>";
}

echo "<h2>Competition Info</h2>";
//Get the info for this comp
include_once ('./comp_info.php');
echo "<br/>";

echo "<h2>Teams</h2>";
echo "<div id='teams'>";
//Get the teams in this comp
include_once ('./comp_teams.php');
echo "</div>";

if (editCheck(1)){
echo "<div id='addteamdiv'>";
include_once ('./add_team.php');
echo "</div>";
}

echo "<h2>Games</h2>";
echo "<div id='games'>";
//Get the games in this comp
include_once ('./comp_games.php');
echo "</div>";

if (editCheck(1)){
echo "<div id='addgamediv'>";
include_once ('./add_game.php');
echo "</div>";
}

include_once ('./footer.php');
mysql_close();
?>