<?php
include_once './include.php';
use AllPlayers\AllPlayersClient;
if (editCheck(1)) {
  include_once './APSource.php';
  include './config.php';
  $APSource = new APSource();
  $members = $APSource->getGroupMembers($config['admin_group_uuid']);
  //$db->deleteNonAdminUsers();
  $added = 0;
  foreach ($members as $member) {
    $user = $db->getUser($member['uuid']);
    if (!$user) {
      $user = array(
        'login' => $member['fname'] . $member['lname'],
        'pass' => '123Testing',
        'team' => 0,
        'access' => 1,
        'uuid' => $member['uuid'],
      );

      if ($db->addUser($user)) {
        $added ++;
      }
    }
  }
  echo "Created " . $added . " Users from Sync";
  echo "<a href='users.php' title = 'Back'> Go Back </a>";
}