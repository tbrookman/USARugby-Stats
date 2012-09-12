<?php
include_once './include_mini.php';
include_once './APSource.php';

$teams = array();
$client = APSource::factory();

//echo out a list of all clubs
$query = "SELECT * FROM `teams` WHERE 1 ORDER BY name";
$result = mysql_query($query);
?>
<form name="teams_sync" id="teams_sync" method="POST" action="">
    <label for="sync_all">Sync all:</label>
    <input type="checkbox" name="sync_all" id="sync_all" />
    <br />
    <?php
    while ($row = mysql_fetch_assoc($result)) {
        $teams[] = $row;
        echo "{$row['uuid']} - {$row['name']} ";
        ?>
        <input type="checkbox" name="team_<?php echo $row['uuid']; ?>" />
        <br />
        <?php
    }
    ?>
    <input class="button" type="submit" value="Sync Team(s)" />
</form>

<?php
foreach ($_POST as $name => $value) {
    if ($name == 'sync_all' && $value == 'on') {
        foreach ($teams as $key => $team) {
            sync_group_members($team['uuid'], $client, $db);
        }
        exit;
    }
    if ($uuid = split('_', $name)) {
        sync_group_members($uuid[1], $client, $db);
    }
}
function sync_group_members($group_uuid, $client, $db) {
    $existing_players = array();
    $query = "SELECT * FROM `players` WHERE team_uuid='$group_uuid'";
    $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) {
        $existing_players[] = $row['uuid'];
    }
    
    $command = $client->getCommand('GetGroupMembers', array('uuid' => $group_uuid));
    $command->setLimit(0);
    $client->execute($command);
    $members = json_decode($command->getResponse()->getBody());
    foreach ($members as $member) {
        $member = (array) $member;
        if (!in_array($member['uuid'], $existing_players)) {
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
    echo 'Groups members updated for ' . $group_uuid . '.<br />';
}

echo "<a href='admin.php'>Back to admin area</a>";

