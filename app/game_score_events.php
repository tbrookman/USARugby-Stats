<?php
include_once ('./include_mini.php');

if(!isset($game_id) || !$game_id){$game_id=$_GET['id'];}

echo "<table>";

$query = "SELECT * FROM `game_events` WHERE game_id = $game_id AND type <10 ORDER BY minute, type";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){
echo "<tr><td>{$row['minute']}'</td>\r";
echo "<td>".eType($row['type'])."</td>\r";
echo "<td>".teamName($row['team_id'])."</td>\r";
echo "<td>".playerName($row['player_id'])."</td>\r";

if (editCheck())
{
echo "<td><form style='margin: 0; padding: 0' name='dForm{$row['id']}' id='dForm{$row['id']}'>";
echo "<input name='dScore{$row['id']}' class='dScore' id='dScore{$row['id']}' type='button' value='Delete Score' />";
echo "<input type='hidden' class='dId' name='event_id' id='event_id' value='{$row['id']}' />";
echo "<input type='hidden' name='refresh' id='refresh' value='game_score_events.php?id=$game_id' />";

echo "</form></td>\r";
}

echo "</tr>\r";
}

echo "</table>\r";

?>