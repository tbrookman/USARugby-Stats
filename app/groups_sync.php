<?php
include_once './include_mini.php';
use Source\APSource;

if (editCheck(1)) {
    $query = "SELECT * FROM `teams` WHERE 1 ORDER BY name";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {
        $existing_groups[] = $row['uuid'];
    }
    $attributes = $_SESSION['_sf2_attributes'];
    $client = APSource::factory();
    $command = $client->getCommand('GetUserGroups', array('uuid' => $attributes['user_uuid']));
    $groups = $client->getIterator($command);
    foreach ($groups as $group) {
        if (!in_array($group['uuid'], $existing_groups)) {
            $team_info = array(
                'hidden' => 0,
                'user_create' => $_SESSION['user'],
                'uuid' => $group['uuid'],
                'name' => $group['title'],
                'short' => $group['title']
            );
            $db->addTeam($team_info);
        }
    }
    echo 'Groups updated.<br /><br />';
    echo "<a href='admin.php'>Back to admin area</a>";
}
