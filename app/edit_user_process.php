<?php
include_once './include_mini.php';

$email = mysql_real_escape_string($request->get('login'));

$user_id = $request->get('user_id');
$access = $request->get('access');
if (!isset($access) || !$access) {$access=4;}
$team = $request->get('team');

$user_info = array(
  'email' => $email,
  'access' => $access,
  'team' => $team,
);
$result = $db->updateUser($user_id, $user_info);
echo $result;
