<?php
include_once './include_mini.php';

if (!isset($comp_id) || !$comp_id) {$comp_id=$_GET['id'];}

echo "<table class='normal table'>\n";
echo "<tr><th></th><th>Game</th><th>Kickoff</th><th>Home</th><th>Score</th><th>Away</th><th>Field</th></tr>\n";

$query = "SELECT * FROM `games` WHERE comp_id = $comp_id ORDER BY kickoff";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {

    $kout = date('n/j g:ia', strtotime($row['kickoff']));
    $resource = $db->getResource($row['field_num']);
    echo "<tr>";
    if (editCheck(1)) {
?>
<td>
  <div class="btn-group pull-left">
    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
      <i class="icon-cog"></i>
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
      <!-- dropdown menu links -->
      <li><a href='game.php?id=<?php echo $row['id'];?>'><i class="icon-pencil"></i> Edit</a></li>
      <li><a href='#' class='dGame' id='dGame<?php echo $row['id'];?>' data-del-game-id='<?php echo $row['id'];?>'> <i class='icon-remove'></i> Delete</a></li>
      <li class="divider"></li>
      <li class="nav-header">iframes</li>
      <li><a href="#">Roster</a></li>
      <li><a href="#">Game info</a></li>
    </ul>
<?php
        echo "<form style='margin: 0; padding: 0' name='dGame{$row['id']}' id='dGame{$row['id']}'>\n";
        echo "<input type='hidden' class='dId' name='game_id' id='game_id' value='{$row['id']}' />\n";
        echo "<input type='hidden' name='grefresh' id='grefresh' value='comp_games.php?id=$comp_id' />\n";
        echo "</form>\n";
?>
  </div>
</td>
<?php
    }
    else {
        echo "<td></td>";
    }

    echo "<td>{$row['comp_game_id']}</td>\n";
    echo "<td>$kout</td>\n";
    echo "<td>".teamName($row['home_id'])."</td>\n";
    echo "<td align='center'><a href='game.php?id={$row['id']}'>{$row['home_score']} - {$row['away_score']}</a></td>\n";
        echo "<td>".teamName($row['away_id'])."</td>\n";
    echo "<td>{$resource['title']}</td>\n";

    echo "</tr>\n";
}
echo "</tr>\n</table>\n";
