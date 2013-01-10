<?php
use Source\QueueHelper;

include_once './include.php';
use Source\APSource;

$teams = array();
$client = APSource::SessionSourceFactory();
if (isset($_POST['submit'])) {
    unset($_POST['post']);
    unset($_POST['check_all']);

    echo '<div class="alert alert-success">Selected groups hidden.</div>';

    $query = "UPDATE teams SET status='show'";
    $result = mysql_query($query);
    foreach ($_POST as $name => $value) {
        $team_id = mysql_real_escape_string($value);
        $query = "UPDATE teams SET status='hide' WHERE id=$team_id";
        $result = mysql_query($query);
        // $db->hideTeam($value);
    }
}

$teams = $db->getAllTeams();
?>
<form name="teams_showhide" id="teams_showhide" method="POST" action="">
    <label for="check_all">Show All:</label>
    <input type="checkbox" name="check_all" id="active" />
    <br />
    <?php
    foreach ($teams as $uuid => $team) {
        echo '<label class=\"checkbox\">';
        if ($team['status'] == "hide") {
            echo "<input checked='checked' type='checkbox' name='team_{$team['uuid']}' value='{$team['id']}'>";
        }
        else {
            echo "<input type='checkbox' name='team_{$team['uuid']}' value='{$team['id']}'>";
        }
        echo "  {$team['name']} (<small>$uuid</small>)";
        echo '</label>';
    }
    ?>
    <input class="button" name="submit" type="submit" value="Hide groups" />
</form>
