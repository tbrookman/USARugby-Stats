<?php
include_once './include_mini.php';

//Get team_id to prevent direct URL access from another team
$team_id = $_POST['team_id'];

//verify we can edit
if (editCheck(2, $team_id)) {

    //get rest of necessary data to update roster
    $roster_id = $_POST['roster_id'];
    $player_ids = $_POST['players'];
    $positions = $_POST['positions'];
    $numbers = $_POST['numbers'];
    $frontrows = $_POST['frontrows'];
    $now = date('Y-m-d H:i:s');

    //update roster
    $query = "UPDATE `game_rosters` SET user_create='{$_SESSION['user']}',last_edit='$now',player_ids='$player_ids',positions='$positions',
numbers='$numbers', frontrows='$frontrows' WHERE id='$roster_id'";
    $result = mysql_query($query);
}
