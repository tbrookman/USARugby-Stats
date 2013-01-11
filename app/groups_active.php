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
  <label for="check_all">Select groups to display as hidden</label>
    <input class="btn btn-warning" name="submit" type="submit" value="Hide Groups" />
    <div class="border"><input type="checkbox" name="check_all" id="active" value="Select All"/>Select All</div>
    <?php
    foreach ($teams as $uuid => $team) {
        echo '<label class=\"checkbox\">';
        if ($team['status'] == "hide") {
            echo "<input class='grps-active' checked='checked' type='checkbox' name='team_{$team['uuid']}' value='{$team['id']}'>";
        }
        else {
            echo "<input class='grps-active' type='checkbox' name='team_{$team['uuid']}' value='{$team['id']}'>";
        }
        echo "  {$team['name']} (<small>$uuid</small>)";
        echo '</label>';
    }
    ?>
    <input class="btn btn-warning" name="submit" type="submit" value="Hide Groups" />
</form>
