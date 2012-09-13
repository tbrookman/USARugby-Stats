<?php
include_once './include.php';
use Source\APSource;
if (editCheck(1)) {
  include './config.php';
  $APSource = APSource::factory();
  $members = $APSource->getGroupMembers($config['admin_group_uuid']);
  $added = 0;
  foreach ($members as $member) {
    $user = $db->getUser($member['uuid']);
    if (!$user) {
      $user_info = array(
        'login' => '',
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