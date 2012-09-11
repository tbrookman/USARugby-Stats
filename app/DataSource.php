<?php

class DataSource {
  /**
   * Initialize database connection.
   */
  function __construct() {
    include './config.php';
    $username = $config['username'];
    $password = $config['password'];
    $database = $config['database'];
    $server   = $config['server'] ? $config['server'] : 'localhost';

    mysql_connect($server, $username, $password);
    @mysql_select_db($database) or die( "Unable to select database");
  }

  /**
   * Retrieve game by serial id or uuid.
   *
   * @param mixed $id
   *  UUID or ID of the game.
   */
  public function getGame($id) {
    $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('games', $id) : $id;
    $query = "SELECT * FROM `games` WHERE id=$search_id";
    $result = mysql_query($query);
    $game = mysql_fetch_assoc($result);
    return $game;
  }

  /**
   * Retrieve a serial id by uuid.
   * @param string $table_name
   * @param string $uuid
   * @return string $id.
   */
  public function getSerialIDByUUID($table_name, $uuid) {
    $query = "SELECT id FROM `$table_name` WHERE uuid='$uuid'";
    $result = mysql_query($query);
    $serial_id = mysql_fetch_assoc($result);
    return empty($serial_id['id']) ? FALSE : $serial_id['id'];
  }

  /**
   * Retrieve a uuid by serial id.
   * @param string $table_name
   * @param string $serial_id
   * @return string $uuid.
   */
  public function getUUIDBySerialID($table_name, $serial_id) {
    $query = "SELECT id FROM `$table_name` WHERE id='$serial_id'";
    $result = mysql_query($query);
    $uuid = mysql_fetch_assoc($result);
    return empty($uuid['uuid']) ? FALSE : $uuid['uuid'];
  }

  public function getRoster($game_id, $team_id) {
    $query = "SELECT * FROM `game_rosters` WHERE game_id = $game_id AND team_id = $team_id";
    $result = mysql_query($query);
    $roster = mysql_fetch_assoc($result);
    return $roster;
  }

  public function getCompetition($comp_id) {
    $query = "SELECT * FROM `comps` WHERE id = $comp_id";
    $result = mysql_query($query);
    $competition = mysql_fetch_assoc($result);
    return $competition;
  }

  public function getGameScoreEvents($id) {
    $game_score_events = array();
    $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('games', $id) : $id;
    $query = "SELECT * FROM `game_events` WHERE game_id = $search_id AND type < 10 ORDER BY minute, type";
    $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) {
      $game_score_events[] = $row;
    }
    return $game_score_events;
  }

  public function getGameSubEvents($id) {
    $game_sub_events = array();
    $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('games', $id) : $id;
    $query = "SELECT * FROM `game_events` WHERE game_id = $search_id AND type > 10 AND type < 20 ORDER BY minute, team_id, type";
    $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) {
      $game_sub_events[] = $row;
    }
    return $game_sub_events;
  }

  public function getGameCardEvents($id) {
    $game_card_events = array();
    $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('games', $id) : $id;
    $query = "SELECT * FROM `game_events` WHERE game_id = $search_id AND type > 20 ORDER BY minute, type, team_id";
    $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) {
      $game_card_events[] = $row;
    }
    return $game_card_events;
  }

  public function deleteNonAdminUsers() {
    $query = "DELETE * FROM `users` where id != 1";
    $result = mysql_query($query);
  }

  public function getUser($id) {
    $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('users', $id) : $id;
    if ($search_id) {
      $query = "SELECT * FROM `users` WHERE id=$search_id";
      $result = mysql_query($query);
      $user = mysql_fetch_assoc($result);
      return $user;
    }
    return FALSE;
  }

  public function addUser($user_info) {
    $user_info['login'] = mysql_real_escape_string($user_info['login']);
    $user_info['pass'] = md5(mysql_real_escape_string($user_info['pass']));
    $query = "INSERT INTO `users` VALUES ('', '" . implode("', '", $user_info) . "', NULL, NULL)";
    $result = mysql_query($query);
    return $result;
  }
  /**
   * Verify the validity of a uuid.
   * @param string $uuid
   *  UUID to verify.
   */
  public static function uuidIsValid($uuid) {
    return (boolean) preg_match('/^[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}$/', $uuid);
  }
}