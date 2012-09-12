<?php
use AllPlayers\AllPlayersClient;
class APSource {
  /**
   * Initialize connection.
   */
  function __construct() {
    $attributes = $_SESSION['_sf2_attributes'];
    $this->client = AllPlayersClient::factory(array(
      'auth' => 'oauth',
      'oauth' => array(
        'consumer_key' => $attributes['consumer_key'],
        'consumer_secret' => $attributes['consumer_secret'],
        'token' => $attributes['auth_token'],
        'token_secret' => $attributes['auth_secret']
      ),
      'host' => parse_url($attributes['domain'], PHP_URL_HOST),
      'curl.CURLOPT_SSL_VERIFYPEER' => FALSE, // @todo TRUE
      'curl.CURLOPT_CAINFO' => 'assets/mozilla.pem',
      'curl.CURLOPT_FOLLOWLOCATION' => FALSE
    ));
  }

  public function getGroupMembers($group_uuid) {
    $command = $this->client->getCommand('GetGroupMembers', array('uuid' => $group_uuid));
    $command->setLimit(0);
    $command->setAdminsOnly(TRUE);
    $members = $command->execute();
    return $members;
  }

  public function getUserByEmail($email) {
    $this->request = $this->client->get(array('users{?params*}', array(
            'params' => array('email' => $email),
        )));
    $users = $this->request->send();
    $users = json_decode($users->getBody(TRUE));
    return $users;
  }

  public function getUserByUUID($uuid) {
    $command = $this->client->getCommand('GetUser', array('uuid' => $uuid));
    $user = $command->execute();
    return $user;
  }
}