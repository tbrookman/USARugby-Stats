<?php
include_once './include_mini.php';
use Source\APSource;

$teams = array();
$client = APSource::factory();

$teams = $db->getAllTeams();
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
    <input class="button" type="submit" value="Sync Team(s)" />
</form>

<?php
foreach ($_POST as $name => $value) {
    if ($name == 'sync_all' && $value == 'on') {
        foreach ($teams as $uuid => $team) {
            sync_group_members($uuid, $client, $db);
        }
        exit;
    }
    if ($uuid = split('_', $name)) {
        sync_group_members($uuid[1], $client, $db);
    }
}
echo 'Groups members updated.<br />';
echo "<a href='admin.php'>Back to admin area</a>";

function sync_group_members($group_uuid, $client, $db) {
    $existing_players = $db->getTeamPlayers($group_uuid);

    $command = $client->getCommand('GetGroupMembers', array('uuid' => $group_uuid));
    $command->setLimit(0);
    $client->execute($command);
    $members = json_decode($command->getResponse()->getBody());
    foreach ($members as $member) {
        $member = (array) $member;
        if (!$existing_players || !key_exists($member['uuid'], $existing_players)) {
            $now = date('Y-m-d H:i:s');
            $player_info = array(
                'user_create' => $_SESSION['user'],
                'last_update' => $now,
                'uuid' => $member['uuid'],
                'team_uuid' => $group_uuid,
                'firstname' => $member['fname'],
                'lastname' => $member['lname']
            );
            $db->addPlayer($player_info);
        }
    }
}

