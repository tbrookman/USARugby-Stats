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
      $user = $APSource->getUserByUUID($member['uuid']);
      $user_info = array(
        'email' => $user['email'],
        'team' => 0,
        'access' => 1,
        'uuid' => $member['uuid'],
      );

      if ($db->addUser($user_info)) {
        $added ++;
      }
    }
  }
  echo "Created " . $added . " Users from Sync";
  echo "<a href='users.php' title = 'Back'> Go Back </a>";
}