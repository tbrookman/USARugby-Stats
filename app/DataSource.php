<?php

class DataSource {

  /**
   * Initialize database connection.
   */
  public static function connect() {
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
  public static function getGame($id) {
    $search_id_key = DataSource::uuidIsValid($id) ? 'uuid' : 'id';
    $query = "SELECT * FROM `games` WHERE $search_id_key='$id'";
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
  public static function getSerialIDByUUID($table_name, $uuid) {
    $query = "SELECT id FROM `$table_name` WHERE uuid='$uuid'";
    $result = mysql_query($query);
    $serial_id = mysql_fetch_assoc($result);
    return $serial_id['id'];
  }

  /**
   * Retrieve a uuid by serial id.
   * @param string $table_name
   * @param string $serial_id
   * @return string $uuid.
   */
  public static function getUUIDBySerialID($table_name, $serial_id) {
    $query = "SELECT id FROM `$table_name` WHERE id='$serial_id'";
    $result = mysql_query($query);
    $uuid = mysql_fetch_assoc($result);
    return $uuid['uuid'];
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