<?php
use Source\QueueHelper;

include_once './include.php';
use Source\APSource;

$teams = array();
$client = APSource::SessionSourceFactory();
$teams = $db->getAllTeams();

if (isset($_POST['submit'])) {
    unset($_POST['submit']);
    $qh = new QueueHelper();
    echo '<div class="alert alert-success">Groups have been updated.</div>';

    /*foreach ($_POST as $name => $value) {
        if ($name == 'active' && $value == 'on') {
            $qh->GroupMembersSync();
        }
        elseif ($uuid = split('_', $name)) {
            $qh->GroupMembersSync($uuid[1]);
        }
    }*/
}
?>
<form name="teams_sync" id="teams_sync" method="POST" action="">
    <label for="active">Active Groups</label>
    <input type="checkbox" name="active" id="active" />
    <br />
    <?php
    foreach ($teams as $uuid => $team) {
        echo '<label class=\"checkbox\">';
        echo "<div class='hideg showg' id='groups'> {$team['name']} (<small>$uuid</small>) </div>";
        echo '<input class="btn btn-warning" name="submit" type="submit" value="Active Groups" />';
        echo '<input class="btn btn-danger" name="submit" type="submit" value="Inactive Groups" />';
        /*echo "<input type=\"checkbox\" name=\"team_$uuid\" \\>";*/
        echo '</label>';
        
    }
    ?>

</form>
