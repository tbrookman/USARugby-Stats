<?php
include_once './include.php';

$team_id = $request->get('id');

$team = $db->getTeam($team_id);
$team_logo = getFullImageUrl($team['logo_url']);
?>
<div class="row">
    <div class="span1">
        <?php echo "<img src='$team_logo' alt='{$team['name']}' class='img-polaroid group-logo' onerror='imgError(this);'/>"; ?>
    </div>
    <div class="span11">
        <?php echo "<h1>{$team['name']}</h1>"; ?>
    </div>
</div>
<?php

echo "<h2>Event Rosters</h2>";
//Get the rosters for this team
include_once './team_event_rosters.php';
echo "<br/>";

echo "<h2>Games</h2>";
//Get the rosters for this team
include_once './team_games.php';
echo "<br/>";

echo "<h2>Game Rosters</h2>";
//Get the rosters for this team
echo "<div class='rosters-wrapper'>";
include_once './team_game_rosters.php';
echo "<br/>";
echo "</div>";

include_once './footer.php';
mysql_close();
