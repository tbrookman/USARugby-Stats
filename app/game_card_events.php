<?php
include_once './include_mini.php';

if (!isset($game_id) || !$game_id) {$game_id=$_GET['game_id'];}

echo "<table>";

$query = "SELECT * FROM `game_events` WHERE game_id = $game_id AND type > 20 ORDER BY minute, type, team_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {
    echo "<tr><td>{$row['minute']}'</td>";
    echo "<td>".eType($row['type'])."</td>";
    echo "<td>".teamName($row['team_id'])."</td>";
    echo "<td>".playerName($row['player_id'])."</td>";

    if (editCheck()) {
        echo "<td><form style='margin: 0; padding: 0' name='dForm{$row['id']}' id='dForm{$row['id']}'>";
        echo "<input name='dCard{$row['id']}' class='dCard' id='dCard{$row['id']}' type='button' value='Delete Card' />";
        echo "<input type='hidden' class='dId' name='event_id' id='event_id' value='{$row['id']}' />";
        echo "<input type='hidden' name='refresh' id='refresh' value='game_card_events.php?game_id=$game_id' />";

        echo "</form></td>\r";
    }

}

echo "</table>";
