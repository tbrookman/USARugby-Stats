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
}
?>
<form name="teams_sync" id="teams_sync" method="POST" action="">
    <input type='hidden' name='grouprefresh' id='grouprefresh' value='hide_group.php' />
    <label for="active">Select the group that you would like to hide</label><br>
    <input id="buttonshow" class="btn btn-danger" name="submit" type="submit" value="Show All Groups" /><br>
    <input class="sgroup" type="checkbox" name="active" id="active" /> Select All
    <br />
    <?php
    foreach ($teams as $uuid => $team) {
        echo '<label class=\"checkbox\">';
        echo "<ul class='sgroups'><li><div class='hideg showg' id='groups'>";
        echo "<input id='sgroup' type=\"checkbox\" name=\"team_$uuid\" \\>";
        echo "{$team['name']} (<small>$uuid</small>)";
        echo '</label>';
        echo '</div></li></ul>';
        
    }
    ?>
    <br >
    <!-- need to create hide display and show all display need to create value 'groups_file.php' -->
</form>
