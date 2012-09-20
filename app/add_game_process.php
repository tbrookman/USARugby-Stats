<?php
include_once './include_mini.php';
use Source\APSource;
use Source\DataSource;

$field = $_POST['field'];
$game_num = $_POST['gnum'];
$kod = $_POST['kdate'];
$koh = $_POST['koh'];
$kom = $_POST['kom'];
$home = $_POST['home'];
$away = $_POST['away'];
$comp_id = $_POST['comp_id'];

$client = APSource::factory();
$db = new DataSource;
$home_team = $db->getTeam($home);
$away_team = $db->getTeam($away);
$date_time_allplayers = $kod . 'T' . DATE("H:i:s", STRTOTIME($_POST['minutes']));
$event = array(
    'groups' => array(
        0 => $home_team['uuid']
    ),
    'title' => $away_team['name'] . ' @ ' . $home_team['name'],
    'description' => $away_team['name'] . ' @ ' . $home_team['name'],
    'date_time' => array(
        'start' => $date_time_allplayers,
        'end' => $date_time_allplayers
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
$command = $client->getCommand('CreateEvent', $event);
$command->execute();
$event = json_decode($command->getResponse()->getBody());

$date_time = new DateTime($kod . 'T' . $koh . ':' . $kom);
$kfull = $date_time->format('Y-m-d H:i:\0\0');

$query = "INSERT INTO `games` VALUES ('','{$_SESSION['user']}','$comp_id','$game_num','$home','$away','$kfull','$field','0','0','0','0','0','0','0', '$event->uuid')";
$result = mysql_query($query);

$now = date('Y-m-d H:i:s');
$numbers = '-1-2-3-4-5-6-7-8-9-10-11-12-13-14-15-16-17-18-19-20-21-22-23-24-25-26-27-28-29-30-';
$frontrows = '-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-';

$game_id = mysql_insert_id();

$query = "INSERT INTO `game_rosters` VALUES ('','{$_SESSION['user']}','$now','$comp_id','$game_id','$home','','$numbers','$frontrows')";
$result = mysql_query($query);

$query = "INSERT INTO `game_rosters` VALUES ('','{$_SESSION['user']}','$now','$comp_id','$game_id','$away','','$numbers','$frontrows')";
$result = mysql_query($query);

$command = $client->getCommand('UpdateEvent', array('external_id' => 'STATS_APP_' . $game_id));
$command->setUuid($event->uuid);
$command->execute();
