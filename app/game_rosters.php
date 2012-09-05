<?php

include './include_micro.php';
//get the home players and numbers
//$query = "SELECT * FROM `game_rosters` WHERE game_id = $game_id AND team_id = $home_id";
$home_roster = $db->getRoster($game_id, $home_id);
$home_plyrs = $home_roster['player_ids'];
$home_nums = $home_roster['numbers'];
$home_frs = $home_roster['frontrows'];


//get the away players and numbers
$away_roster = $db->getRoster($game_id, $away_id);
//$query = "SELECT * FROM `game_rosters` WHERE game_id = $game_id AND team_id = $away_id";
$away_plyrs = $away_roster['player_ids'];
$away_nums = $away_roster['numbers'];
$away_frs = $away_roster['frontrows'];


//split up the player ids from the long - string
$homeps = array_filter(explode('-', $home_plyrs));
$awayps = array_filter(explode('-', $away_plyrs));
$homens = array_filter(explode('-', $home_nums));
$awayns = array_filter(explode('-', $away_nums));
$homefrs = array_filter(explode('-', $home_frs));
$awayfrs = array_filter(explode('-', $away_frs));

//find which has more to limit our roster output
if (count($homeps) > count($awayps)) {
    $max = count($homeps);
} else {
    $max = count($awayps);
}

echo "<table>";
$link = empty($iframe);
echo "<tr><td colspan='3'>".teamName($away_id, $link)."</td><td>@</td><td colspan='3'>".teamName($home_id, $link)."</td></tr>\r";

//0 element has been filtered above so start at 1
//displaying number, name, FR capable
for ($i=1;$i<=$max;$i++) {
    echo "<tr><td>{$awayns[$i]}</td>\r";
    echo "<td>".playerName($awayps[$i])."</td>\r";
    if (isset($awayfrs[$i]) && $awayfrs[$i]==1) {$frout='FR';} else {$frout='';}
    echo "<td>$frout</td>\r";
    echo "<td>&nbsp;</td>\r";
    echo "<td>{$homens[$i]}</td>\r";
    echo "<td>". (isset($homeps[$i]) ? playerName($homeps[$i]) : '') ."</td>\r";
    if (isset($homefrs[$i]) && $homefrs[$i]==1) {$frout='FR';} else {$frout='';}
    echo "<td>$frout</td>\r";
    echo "</tr>\r";
}

if (editCheck()) {
    echo "<td colspan='2'><a href='game_roster.php?gid=$game_id&tid=$away_id'>Edit Roster</a></td>\n";
    echo "<td>&nbsp;</td>";
    echo "<td colspan='2'><a href='game_roster.php?gid=$game_id&tid=$home_id'>Edit Roster</a></td>\n";
}

echo "</table>";
