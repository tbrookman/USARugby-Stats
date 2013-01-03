<?php
use Source\QueueHelper;

include_once './include.php';
use Source\APSource;

$teams = array();
$client = APSource::SessionSourceFactory();
$teams = $db->getAllTeams();

if (isset($_POST['show'])) {
    unset($_POST['hide']);
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
    <input class="sgroup" type="checkbox" name="active" id="active" /> Select All
    <br />
    <?php
    foreach ($teams as $uuid => $team) {
        echo '<label class=\"checkbox\">';
        echo "<div class='hideg showg' id='groups'>";
        echo "<input id='sgroup' type=\"checkbox\" name=\"team_$uuid\" \\>";
        echo "{$team['name']} (<small>$uuid</small>)";
        echo '</label>';
        echo '</div>';
        
    }
    ?>
    <br >
    <input class="btn btn-warning" name="submit" type="show" value="Active Groups" />
    <input class="btn btn-danger" name="sbumit" type="hide" value="Inactive Groups" />
    <input type='hidden' name='grouprefresh' id='grouprefresh' value='hide_group.php' />
    <!-- need to create hide display and show all display need to create value 'groups_file.php' -->
</form>
