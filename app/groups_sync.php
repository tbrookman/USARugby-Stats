<?php
include_once './include_mini.php';
use AllPlayers\AllPlayersClient;

if (editCheck(1)) {
    $query = "SELECT * FROM `teams` WHERE 1 ORDER BY name";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {
        $existing_groups[] = $row['uuid'];
    }
    $attributes = $_SESSION['_sf2_attributes'];
    $client = AllPlayersClient::factory(array(
        'auth' => 'oauth',
        'oauth' => array(
            'consumer_key' => $attributes['consumer_key'],
            'consumer_secret' => $attributes['consumer_secret'],
            'token' => $attributes['auth_token'],
            'token_secret' => $attributes['auth_secret']
        ),
        'host' => parse_url($attributes['domain'], PHP_URL_HOST),
        'curl.CURLOPT_SSL_VERIFYPEER' => TRUE,
        'curl.CURLOPT_CAINFO' => 'assets/mozilla.pem',
        'curl.CURLOPT_FOLLOWLOCATION' => FALSE
    ));
    $command = $client->getCommand('GetUserGroups', array('uuid' => $attributes['user_uuid']));
    $groups = $client->getIterator($command);
    foreach ($groups as $group) {
        if (!in_array($group['uuid'], $existing_groups)) {
            $query = "INSERT INTO `teams` VALUES ('','0','{$_SESSION['user']}','{$group['uuid']}','{$group['title']}','{$group['title']}')";
            $result = mysql_query($query);
        }
    }
    echo 'Groups updated.<br /><br />';
    echo "<a href='admin.php'>Back to admin area</a>";
}
