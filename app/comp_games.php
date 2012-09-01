<?php
include_once './include_mini.php';

if (!isset($comp_id) || !$comp_id) {$comp_id=$_GET['id'];}

echo "<table class='normal'>\n";
echo "<tr><td>Game</td><td>Kickoff</td><td>Home</td><td>&nbsp;</td>\n";
echo "<td>Away</td><td>Field</td></tr>\n";

$query = "SELECT * FROM `games` WHERE comp_id = $comp_id ORDER BY kickoff";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {

    $kout = date('n/j g:ia', strtotime($row['kickoff']));

    echo "<tr>\n<td>{$row['comp_game_id']}</td>\n";
    echo "<td>$kout</td>\n";
    echo "<td>".teamName($row['home_id'])."</td>\n";
    echo "<td align='center'><a href='game.php?id={$row['id']}'>{$row['home_score']} - {$row['away_score']}</a></td>\n";
    echo "<td>".teamName($row['away_id'])."</td>\n";
    echo "<td>{$row['field_num']}</td>\n";

    if (editCheck(1)) {
        echo "<td><form style='margin: 0; padding: 0' name='dGame{$row['id']}' id='dGame{$row['id']}'>\n";
        echo "<input name='dGame{$row['id']}' class='dGame' id='dGame{$row['id']}' type='button' value='Delete Game' />\n";
        echo "<input type='hidden' class='dId' name='game_id' id='game_id' value='{$row['id']}' />\n";
        echo "<input type='hidden' name='grefresh' id='grefresh' value='comp_games.php?id=$comp_id' />\n";

        echo "</form></td>\n";
    }
    echo "</tr>\n";
}
echo "</tr>\n</table>\n";
