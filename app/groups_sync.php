<?php
include_once './include.php';
use Source\APSource;

if (editCheck(1)) {
    $existing_teams = $db->getAllTeams();
    $attributes = $_SESSION['_sf2_attributes'];
    $client = APSource::factory();
    $command = $client->getCommand('GetUserGroups', array('uuid' => $attributes['user_uuid']));
    $teams = $client->getIterator($command);
    foreach ($teams as $team) {
        if (!$existing_teams || !key_exists($team['uuid'], $existing_teams)) {
            $team_info = array(
                'hidden' => 0,
                'user_create' => $_SESSION['user'],
                'uuid' => $team['uuid'],
                'name' => $team['title'],
                'short' => $team['title']
            );
            $db->addTeam($team_info);
        }
    }
    $_SESSION['groups_synched'] = TRUE;
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
