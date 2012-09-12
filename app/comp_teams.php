<?php
include_once './include_mini.php';

if (!isset($comp_id) || !$comp_id) {$comp_id=$_GET['id'];}

echo "<table class='table'><tr>";

$query = "SELECT * FROM `ct_pairs` WHERE comp_id = $comp_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {

    $query2 = "SELECT * FROM `teams` WHERE id = {$row['team_id']}";
    $result2 = mysql_query($query2);
    while ($row2=mysql_fetch_assoc($result2)) {

        echo "<td><a href='team.php?id={$row2['id']}'>{$row2['short']}<a/></td>";

        if (editCheck(1)) {
            echo "<td><form style='margin: 0; padding: 0' name='dTeam{$row2['id']}' id='dTeam{$row2['id']}'>";
            echo "<input name='dTeam{$row2['id']}' class='dTeam btn btn-danger' id='dTeam{$row2['id']}' type='button' value='Delete Team' />";
            echo "<input type='hidden' class='dId' name='team_id' id='team_id' value='{$row2['id']}' />";
            echo "<input type='hidden' class='dId' name='comp_id' id='comp_id' value='$comp_id' />";
            echo "<input type='hidden' name='trefresh' id='trefresh' value='comp_teams.php?id=$comp_id' />";

            echo "</form></td>\r";
        }

        echo "</tr>";

    }

}

echo "</table>";
