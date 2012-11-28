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
    echo '<div class="alert alert-success">Players sync enqueued.</div>';

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
    <label for="sync_all">Sync all:</label>
    <input type="checkbox" name="sync_all" id="sync_all" />
    <br />
    <?php
    foreach ($teams as $uuid => $team) {
        echo "$uuid - {$team['name']} ";
        ?>
        <input type="checkbox" name="team_<?php echo $uuid; ?>" />
        <br />
        <?php
    }
    ?>
    <input class="button" name="submit" type="submit" value="Sync Team(s)" />
</form>
