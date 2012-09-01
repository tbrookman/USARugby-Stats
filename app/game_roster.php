 <?php
include_once './header.php';

echo "<h1>Game Roster</h1>";

$game_id = $_GET['gid'];
$team_id = $_GET['tid'];

//provide some game info
include_once './game_roster_info.php';

//either allow edit by team/usarugby or just show for press / other teams
echo "<div id='groster'>";
if (editCheck(2, $team_id)) {
    //output names in lastname, firstname convention in dropdowns
    include_once './edit_game_roster.php';
} else {
    //output names in lastname, firstname convention
    include_once './game_player_sort.php';
}
echo "</div>";

mysql_close();
?>
