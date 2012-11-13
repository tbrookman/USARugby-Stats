<?php
header('Location: ' . $_SERVER['HTTP_REFERER']);
include_once './include.php';
use Source\APSource;

if (editCheck(1)) {
    $existing_teams = $db->getAllTeams();
    $attributes = $_SESSION['_sf2_attributes'];
    $client = APSource::SourceFactory();
    $teams = array();
    $offset = 0;
    do {
        $response = $client->userGetMyGroups($attributes['user_uuid'], '*,group_type', $offset, 1000);
        $offset+= 1;
        $teams = array_merge($teams, (array)$response);
    } while (sizeof($response) == 1000);
    foreach ($teams as $team) {
        $team = (is_array($team)) ? $team : (array) $team;
        if (!key_exists($team['uuid'], $existing_teams)) {
            if (!empty($team['logo'])) {
                $logo_url = substr($team['logo'], strpos($team['logo'], '/sites/default/'));
            }
            else {
                $logo_url = '/sites/default/files/imagecache/img_120x120_s/sites/all/modules/apci_features/apci_defaults/group-icon.png';
            }
            $team_info = array(
                'hidden' => 0,
                'user_create' => $_SESSION['user'],
                'uuid' => $team['uuid'],
                'name' => $team['title'],
                'short' => $team['title'],
                'logo_url' => $logo_url,
                'description' => $team['description'],
                'type' => $team['group_type'],
            );
            $db->addTeam($team_info);
            $added++;
            $existing_teams[$team['uuid']] = $team_info;
        }
    }

    $_SESSION['alert_message'] = $added . " groups added.";
}
