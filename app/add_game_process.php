<?php
include_once './include_mini.php';
use Source\APSource;

$field = $_POST['field'];
$game_num = $_POST['gnum'];
$kod = $_POST['kdate'];
$koh = $_POST['koh'];
$kom = $_POST['kom'];
$home = $_POST['home'];
$away = $_POST['away'];
$comp_id = $_POST['comp_id'];

$client = APSource::factory();
$home_team = $db->getTeam($home);
$away_team = $db->getTeam($away);
$userTimezone = new DateTimeZone((isset($config['timezone']) ? $config['timezone'] : 'America/Chicago'));
$date_time = new DateTime($kod . 'T' . $koh . ':' . $kom, $userTimezone);
$date_time_ap = $date_time;
$date_time_ap->setTimezone(new DateTimeZone('UTC'));
$date_time_ap = $date_time_ap->format('Y-m-d\TH:i:s');
$event = array(
    'groups' => array(
        0 => $home_team['uuid']
    ),
    'title' => $away_team['name'] . ' @ ' . $home_team['name'],
    'description' => $away_team['name'] . ' @ ' . $home_team['name'],
    'date_time' => array(
        'start' => $date_time_ap,
        'end' => $date_time_ap
    ),
    'competitors' => array(
        0 => array(
            'uuid' => $home_team['uuid'],
            'label' => 'home'
        ),
        1 => array(
            'uuid' => $away_team['uuid'],
            'label' => 'away'
        )
    ),
    'category' => 'game'
);
$event = $client->createEvent($event);

$kfull = $date_time->format('Y-m-d H:i:\0\0');

$game_info = array(
    'user_create' => $_SESSION['user'],
    'comp_id' => $comp_id,
    'comp_game_id' => $game_num,
    'home_id' => $home,
    'away_id' => $away,
    'kickoff' => $kfull,
    'field_num' => $field,
    'home_score' => '0',
    'away_score' => '0',
    'ref_id' => '0',
    'ref_sign' => '0',
    '4_sign' => '0',
    'home_sign' => '0',
    'away_sign' => '0',
    'uuid' => $event->uuid
);
$game = $db->addGame($game_info);

$now = date('Y-m-d H:i:s');
$numbers = '-1-2-3-4-5-6-7-8-9-10-11-12-13-14-15-16-17-18-19-20-21-22-23-24-25-26-27-28-29-30-';
$frontrows = '-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-';

$game_id = mysql_insert_id();

$query = "INSERT INTO `game_rosters` VALUES ('','{$_SESSION['user']}','$now','$comp_id','$game_id','$home','','$numbers','$frontrows')";
$result = mysql_query($query);

$query = "INSERT INTO `game_rosters` VALUES ('','{$_SESSION['user']}','$now','$comp_id','$game_id','$away','','$numbers','$frontrows')";
$result = mysql_query($query);

$client->updateEvent($event->uuid, array('external_id' => 'STATS_APP_' . $game_id));
