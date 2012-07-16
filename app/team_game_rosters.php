<?php
$query = "SELECT * FROM `game_rosters` WHERE team_id = $team_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){

  $query2 = "SELECT * FROM `games` WHERE id = {$row['game_id']} ORDER BY kickoff";
  $result2 = mysql_query($query2);
  while ($row2=mysql_fetch_assoc($result2)){
  
  $ko = date('M d - g:ia',strtotime($row2['kickoff']));
  echo "<a href='game_roster.php?gid={$row2['id']}&tid=$team_id'>";
  echo teamNameNL($row2['away_id'])." @ ".teamNameNL($row2['home_id'])." - $ko</a><br/>";

  }
  
}
?>
