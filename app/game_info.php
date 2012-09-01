<?php
include_once './include_mini.php';

if (!isset($game_id) || !$game_id) {$game_id=$_GET['id'];}

//get info for the game with id in url
$query = "SELECT * FROM `games` WHERE id = $game_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {

    echo compName($row['comp_id'])."<br/>";
    echo "Game Number: ".$row['comp_game_id']."<br/>";
    echo teamName($row['away_id'])." @ ".teamName($row['home_id'])."<br/>";
    echo date('F j, Y', strtotime($row['kickoff']))."<br/>";
    echo "Kickoff: ".date('g:i', strtotime($row['kickoff']))."<br/>";
    echo "Field: ".$row['field_num']."<br/>";

}

if (editCheck()) {
    echo "<input type='button' class='edit' id='eShow' name='eShow' value='Edit Game Info' />";
    echo "<input type='hidden' id='game_id' value='$game_id' />";
}
