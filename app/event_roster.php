<?php
include_once './header.php';

echo "<h1>Event Roster</h1>";

$roster_id = $_GET['id'];

//Get info about our event and roster
$query = "SELECT * FROM `event_rosters` WHERE id = $roster_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {

    $comp_id=$row['comp_id'];
    $team_id=$row['team_id'];

    echo "<h2>".compName($roster_id)."</h2>";

    echo "<h3>".teamName($row['team_id'])."</h3>";
}

//either allow edit by team/usarugby or just show for press / other teams
echo "<div id='eroster'>";
//to allow the teams to edit, make it editCheck(1,$team_id)
if (editCheck(1)) {
    //output names in lastname, firstname convention in dropdowns
    include_once './edit_event_roster.php';
} else {
    //output names in lastname, firstname convention
    include_once './player_sort.php';
}
echo "</div>";

mysql_close();
