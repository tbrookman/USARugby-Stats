<?php
include_once './header.php';



$roster_id = $request->get('id');

//Get info about our event and roster
$roster = $db->getRosterById($roster_id);
$comp_id = $roster['comp_id'];
$team_id = $roster['team_id'];


?>
<div class='page-header'>
    <h1>Event Roster</h1>
    <h2><?php echo compName($roster_id); ?> </h2>
    <h3><?php echo teamName($team_id); ?> </h3>
</div>
<?php

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
