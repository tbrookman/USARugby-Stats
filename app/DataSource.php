<?php

class DataSource {

  /**
   * Retrieve game by serial id or uuid.
   *
   * @param mixed $id
   *  UUID or ID of the game.
   */
  public static function getGame($id) {
    $search_id_key = DataSource::uuidIsValid($id) ? 'uuid' : 'id';
    $query = "SELECT * FROM `games` WHERE $search_id_key = $id";
    $result = mysql_query($query);
    $game = mysql_fetch_assoc($result);
    return $game;
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