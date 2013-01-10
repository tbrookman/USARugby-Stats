<?php
use Source\QueueHelper;

include_once './include.php';
use Source\APSource;

$teams = array();
$client = APSource::SessionSourceFactory();
$teams = $db->getAllTeams();
$checkboxvalue = $_POST['checkbox'];
if (isset($_POST['submit'])) {
    unset($_POST['post']);
    
    echo '<div class="alert alert-success">Show Groups.</div>';
    
    foreach ($_POST as $name => $value) {
        if ($name == 'sync_all' && $value == 'on') {
            $qh->GroupMembersSync();
        }
        elseif ($uuid = split('_', $name)) {
            $qh->GroupMembersSync($uuid[1]);
        }
    }
}
?>
<form name="teams_sync" id="teams_sync" method="POST" action="">
    <label for="check_all">Show All:</label>
    <input type="checkbox" name="check_all" id="active" />
    <br />
    <?php
    foreach ($teams as $uuid => $team) {
        echo '<label class=\"checkbox\">';
    if (hide) {
        echo "<input id='checkbox' checked='check' type=\"checkbox\" name='checkbox[]' value='show' \\>";       
    }
    else {
        echo "<input id='checkbox' type=\"checkbox\" name='checkbox[]' value='show' \\>";

    }
        echo "  {$team['name']} (<small>$uuid</small>)";
        echo '</label>';
    }
    ?>
    <input class="button" name="submit" type="submit" value="Show" />
    <input class="button" name="submit" type="submit" value="Hide" />
</form>
