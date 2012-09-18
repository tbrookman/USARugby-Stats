<?php
include_once './include_mini.php';

if (!isset($game_id) || !$game_id) {$game_id=$_GET['gid'];}
if (!isset($team_id) || !$team_id) {$team_id=$_GET['tid'];}

//get our team id and list of current rostered players
$query = "SELECT * FROM `game_rosters` WHERE game_id = $game_id AND team_id = $team_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {
    $roster_id=$row['id'];
    $comp_id=$row['comp_id'];
    $player_ids = $row['player_ids'];
    $numbers = $row['numbers'];
    $frontrows = $row['frontrows'];
}

//DON'T NEED?
//get the team's UUID to match against players Team UUID
$query = "SELECT uuid FROM `teams` WHERE id = $team_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {
    $uuid=$row['uuid'];
}

//Get the players that are on this competition's event roster
$players = array();
$query = "SELECT player_ids FROM `event_rosters` WHERE comp_id = $comp_id AND team_id=$team_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {
    $temp=$row['player_ids'];
}
$players = array_filter(explode('-', $temp));

//Get the roster limit and comp type (15s or 7s) from the comp info
$query = "SELECT max_game, type FROM `comps` WHERE id = $comp_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {
    $max_game = $row['max_game'];
    $comp_type = $row['type'];
}

//if this is not the first game, show button to fill with previous game's roster
$query = "SELECT * FROM `games` WHERE comp_id = $comp_id AND
(home_id = $team_id OR away_id = $team_id) ORDER BY kickoff LIMIT 1";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {
    if ($row['id'] != $game_id) {
        echo "<form name='pregame' id='pregame' />\n\r";
        echo "<input type='hidden' id='game_id' value='$game_id' />";
        echo "<input type='hidden' id='comp_id' value='$comp_id' />";
        echo "<input type='hidden' id='team_id' value='$team_id' />";
        echo "<input type='hidden' id='roster_id' value='$roster_id' />";
        echo "<input type='button' id='presubmit' class='btn btn-primary' value='Fill with Previous Roster' />";
        echo "</form>\n";
    }
}

$options = array();

echo "<form name='grform' id='grform' />\n";

//Use our player ID's to get their names: lastname, firstname
foreach ($players as $player) {
    $options[$player]=rplayerName($player);
}

//Get options into alphebetical order
asort($options);


//Put numbers into an array
$numvals = explode('-', $numbers);

//make sure we can filter but allow zeros to pass by making them z temporarily
foreach ($numvals as &$num) {
    if ($num=='0') {
        $num='z';
    }
}

//filter our FALSE values
$numvals = array_filter($numvals);

foreach ($numvals as &$num) {
    if ($num=='z') {
        $num='0';
    }
    if ($num=='B') {
        $num='';
    }
}

//Put frontrows into an array
$frows = explode('-', $frontrows);

//make sure we can filter but allow zeros to pass by making them z temporarily
foreach ($frows as &$fr) {
    if ($fr=='0') {
        $fr='z';
    }
}

//filter our FALSE values
$frows = array_filter($frows);

foreach ($frows as &$fr) {
    if ($fr=='z') {
        $fr='0';
    }
}

//cplayers is an array to hold current player ids which is string seperated by -
$cplayers = array();
$cplayers = explode('-', substr($player_ids, 1, (strlen($player_ids)-2)));

//header for columns
echo "<table class='table'>\n";
$frhead = ($comp_type == 1) ? '<th>FR</th>' : '';
echo "<tr><th>Num.</th><th>Name</th>$frhead</tr>\n";

//Create select for each roster spot and provide an option for each player for team
for ($j=1;$j<=$max_game;$j++) {
    echo "<tr>";

    //show number select, 0-99
    echo "<td><select id='n$j' class='input-small chzn-select'>\n";
    for ($k=0;$k<100;$k++) {
        if ($k==$numvals[$j]) {$stest = 'selected';} else {$stest='';}
        echo "<option id='n$j' $stest>$k</option>\n";
    }
    echo "</select></td>\n";

    //show player select
    echo "<td><select id='p$j' data-placeholder='Select Player' class='input-large chzn-select'>\n";
    echo "<option value=''></option>\n";

    $i=1;
    foreach ($options as $option => $name) {
        if (isset($cplayers[$j-1]) && $option==$cplayers[$j-1]) {$s='selected';} else {$s='';}
        echo "<option value=\"$option\" $s>$name</option>\n";
        $i++;
    }

    echo "</select></td>\n";

    //show front row checkbox if this is a 15s comp
    if ($comp_type==1) {
        if ($frows[$j]==1) {$c="checked='checked'";} else {$c='';}
        echo "<td><input type='checkbox' id='fr$j' $c/></td>\n";
    }
    echo "</tr>\n";
}

echo "</table>\n";

//include hidden info necessary to run process page
echo "<input type='hidden' id='max' value='$max_game' />";
echo "<input type='hidden' id='game_id' value='$game_id' />";
echo "<input type='hidden' id='team_id' value='$team_id' />";
echo "<input type='hidden' id='roster_id' value='$roster_id' />";
echo "<input type='button' id='grsubmit' class='btn btn-primary' value='Update Roster' />";
echo "</form>\n";
