<?php

include './include_micro.php';
//get the home players and numbers
$home_roster = $db->getRoster($game_id, $home_id);
$home_plyrs = $home_roster['player_ids'];
$home_positions = $home_roster['positions'];
$home_nums = $home_roster['numbers'];
$home_frs = $home_roster['frontrows'];


//get the away players and numbers
$away_roster = $db->getRoster($game_id, $away_id);
$away_plyrs = $away_roster['player_ids'];
$away_positions = $away_roster['positions'];
$away_nums = $away_roster['numbers'];
$away_frs = $away_roster['frontrows'];


//split up the player ids from the long - string
$homeps = array_filter(explode('-', $home_plyrs));
$awayps = array_filter(explode('-', $away_plyrs));
$home_positions = array_filter(explode('-', $home_positions));
$away_positions = array_filter(explode('-', $away_positions));
$homens = array_filter(explode('-', $home_nums));
$awayns = array_filter(explode('-', $away_nums));
$homefrs = array_filter(explode('-', $home_frs));
$awayfrs = array_filter(explode('-', $away_frs));
$positions = getPositionList('display');

//find which has more to limit our roster output
if (count($homeps) > count($awayps)) {
    $max = count($homeps);
} else {
    $max = count($awayps);
}

echo "<table class='table'>";
$link = empty($iframe);
echo "<tr><th>#</th><th>" . teamName($away_id, $link) . "</th><th>Position</th><th class='frout'>FR</th><th>@</th><th>#</th><th>" . teamName($home_id, $link) . "</th><th>Position</th><th>FR</th><th></tr>";

//0 element has been filtered above so start at 1
//displaying number, name, FR capable
for ($i=1; $i<=$max; $i++) {
    echo "<tr><td>{$awayns[$i]}</td>\r";
    $away_player_name_string = empty($awayps[$i]) ? "<td>&nbsp;</td>\r" : "<td>".playerName($awayps[$i], !$link, $game_id)."</td>\r";
    echo $away_player_name_string;
    echo "<td>";
    if (!empty($away_positions[$i])) {
        echo($positions[$away_positions[$i]]);
    }
    echo "</td>";
    if (isset($awayfrs[$i]) && $awayfrs[$i]==1) {$frout='FR';} else {$frout='';}
    echo "<td class='frout'>$frout</td>\r";
    echo "<td>&nbsp;</td>\r";
    echo "<td>{$homens[$i]}</td>\r";
    echo "<td>". (isset($homeps[$i]) ? playerName($homeps[$i], !$link, $game_id) : '') ."</td>\r";
    echo "<td>";
    if (!empty($home_positions[$i])) {
        echo($positions[$home_positions[$i]]);
    }
    echo "</td>";
    if (isset($homefrs[$i]) && $homefrs[$i]==1) {$frout='FR';} else {$frout='';}
    echo "<td class='frout'>$frout</td>";
    echo "</tr>";
}

if (editCheck() && empty($iframe)) {
    echo "<td colspan='4'><a href='game_roster.php?gid=$game_id&tid=$away_id'>Edit Roster</a></td>\n";
    echo "<td>&nbsp;</td>";
    echo "<td colspan='4'><a href='game_roster.php?gid=$game_id&tid=$home_id'>Edit Roster</a></td>\n";
}

echo "</table>";
