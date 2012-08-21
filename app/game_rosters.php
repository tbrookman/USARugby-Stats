<?php

//get the home players and numbers
$query = "SELECT * FROM `game_rosters` WHERE game_id = $game_id AND team_id = $home_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){
$home_plyrs = $row['player_ids'];
$home_nums = $row['numbers'];
$home_frs = $row['frontrows'];
}

//get the away players and numbers
$query = "SELECT * FROM `game_rosters` WHERE game_id = $game_id AND team_id = $away_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){
$away_plyrs = $row['player_ids'];
$away_nums = $row['numbers'];
$away_frs = $row['frontrows'];
}

//split up the player ids from the long - string
$homeps = array_filter(explode('-', $home_plyrs));
$awayps = array_filter(explode('-', $away_plyrs));
$homens = array_filter(explode('-', $home_nums));
$awayns = array_filter(explode('-', $away_nums));
$homefrs = array_filter(explode('-', $home_frs));
$awayfrs = array_filter(explode('-', $away_frs));

//find which has more to limit our roster output
if (count($homeps) > count($awayps)){
$max = count($homeps);
}
else
{
$max = count($awayps);
}


echo "<table>";
echo "<tr><td colspan='3'>".teamName($away_id)."</td><td>@</td><td colspan='3'>".teamName($home_id)."</td></tr>\r";

//0 element has been filtered above so start at 1
//displaying number, name, FR capable
for ($i=1;$i<=$max;$i++){
echo "<tr><td>{$awayns[$i]}</td>\r";
echo "<td>".playerName($awayps[$i])."</td>\r";
if(isset($awayfrs[$i]) && $awayfrs[$i]==1){$frout='FR';}else{$frout='';}
echo "<td>$frout</td>\r";
echo "<td>&nbsp;</td>\r";
echo "<td>{$homens[$i]}</td>\r";
echo "<td>". (isset($homeps[$i]) ? playerName($homeps[$i]) : '') ."</td>\r";
if(isset($homefrs[$i]) && $homefrs[$i]==1){$frout='FR';}else{$frout='';}
echo "<td>$frout</td>\r";
echo "</tr>\r";
}

if(editCheck()){
echo "<td colspan='2'><a href='game_roster.php?gid=$game_id&tid=$away_id'>Edit Roster</a></td>\n";
echo "<td>&nbsp;</td>";
echo "<td colspan='2'><a href='game_roster.php?gid=$game_id&tid=$home_id'>Edit Roster</a></td>\n";
}

echo "</table>";


?>