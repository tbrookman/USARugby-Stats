<?php

function teamName($id){
$query = "SELECT id, short FROM `teams` WHERE id = $id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){

$output = "<a href='team.php?id={$row['id']}'>{$row['short']}</a>";
}
return (isset($output) && $output) ? $output : '';
}

function teamNameF($id){
$query = "SELECT id, name FROM `teams` WHERE id = $id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){

$output = "<a href='team.php?id={$row['id']}'>{$row['name']}</a>";
}
return ($output);
}

function teamNameNL($id){
$query = "SELECT id, name FROM `teams` WHERE id = $id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){

$output = "{$row['name']}";
}
return ($output);
}

function compName($id){
$query = "SELECT id, name FROM `comps` WHERE id = $id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){

$output = "<a href='comp.php?id={$row['id']}'>{$row['name']}</a>";
}
return (isset($output) && $output) ? $output : '';
}


function playerName($id){
$query = "SELECT id,firstname,lastname FROM `players` WHERE id = $id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){

$output = "{$row['firstname']} {$row['lastname']}";
}
return ($output);
}

function rplayerName($id){
$query = "SELECT id,firstname,lastname FROM `players` WHERE id = $id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){

$output = "{$row['lastname']}, {$row['firstname']}";
}
return ($output);
}


function eType($id){
$query = "SELECT name FROM `event_types` WHERE event_id = $id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){

$output = "{$row['name']}";
}
return ($output);
}


function sign($switch){
if($switch)
return "Signed";
else
return "Not Signed";
}


function accessName($access){
if($access == 1){
$output = 'Administrator';
}
elseif($access==2){
$output = 'Referee';
}
elseif($access==3){
$output = 'Team Specific';
}
else{
$output = 'View Only';
}
return ($output);
}


function editCheck($pagelvl = 2, $team_id = -2){
if ((isset($_SESSION['access']) && $_SESSION['access']<=$pagelvl) || (isset($_SESSION['teamid']) && $_SESSION['teamid']==$team_id)){
return true;
}
else
{
return false;
}
}
?>