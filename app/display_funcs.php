<?php

/**
 *
 *
 * @param unknown $id
 * @return unknown
 */

function teamName($id, $link = TRUE)
{
    $query = "SELECT id, short FROM `teams` WHERE id = $id";
    $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) {
        if (!empty($link)) {
          $output = "<a href='team.php?id={$row['id']}'>{$row['short']}</a>";
        }
        else {
          $output = $row['short'];
        }
    }

    return (isset($output) && $output) ? $output : '';
}

function getFullImageUrl($partial_image_url) {
    include './config.php';
    $image_url = $config['cdn'] . $partial_image_url;
    return $image_url;
}

/**
 *
 *
 * @param unknown $id
 * @return unknown
 */
function teamNameF($id)
{
    $query = "SELECT id, name FROM `teams` WHERE id = $id";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {

        $output = "<a href='team.php?id={$row['id']}'>{$row['name']}</a>";
    }

    return $output;
}

/**
 *
 *
 * @param unknown $id
 * @return unknown
 */
function teamNameNL($id)
{
    $query = "SELECT id, name FROM `teams` WHERE id = $id";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {

        $output = "{$row['name']}";
    }

    return $output;
}

/**
 *
 *
 * @param unknown $id
 * @return unknown
 */
function compName($id, $link = TRUE)
{
    $query = "SELECT id, name FROM `comps` WHERE id = $id";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {
      if ($link) {
        $output = "<a href='comp.php?id={$row['id']}'>{$row['name']}</a>";
      }
      else {
        $output = $row['name'];
      }
    }

    return (isset($output) && $output) ? $output : '';
}

/**
 *
 *
 * @param unknown $id
 * @return unknown
 */
function playerName($id)
{
    $query = "SELECT id,firstname,lastname FROM `players` WHERE id = $id";
    $result = mysql_query($query);
    $output = '';
    while ($row=mysql_fetch_assoc($result)) {

        $output = "{$row['firstname']} {$row['lastname']}";
    }

    return $output;
}

/**
 *
 *
 * @param unknown $id
 * @return unknown
 */
function rplayerName($id)
{
    $query = "SELECT id,firstname,lastname FROM `players` WHERE id = $id";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {

        $output = "{$row['lastname']}, {$row['firstname']}";
    }

    return $output;
}

/**
 *
 *
 * @param unknown $id
 * @return unknown
 */
function eType($id)
{
    $query = "SELECT name FROM `event_types` WHERE event_id = $id";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {

        $output = "{$row['name']}";
    }

    return isset($output) ? $output : '';
}

/**
 *
 *
 * @param unknown $switch
 * @return unknown
 */
function sign($switch)
{
    if ($switch)
        return "Signed";
    else
        return "Not Signed";
}

/**
 *
 *
 * @param unknown $access
 * @return unknown
 */
function accessName($access)
{
    if ($access == 1) {
        $output = 'Administrator';
    } elseif ($access==2) {
        $output = 'Referee';
    } elseif ($access==3) {
        $output = 'Team Specific';
    } else {
        $output = 'View Only';
    }

    return $output;
}

/**
 *
 *
 * @param unknown $pagelvl (optional)
 * @param unknown $team_id (optional)
 * @return unknown
 */
function editCheck($pagelvl = 2, $team_id = -2)
{
    if ((isset($_SESSION['access']) && $_SESSION['access']<=$pagelvl) || (isset($_SESSION['teamid']) && $_SESSION['teamid']==$team_id)) {
        return true;
    } else {
        return false;
    }
}


function get_header_string($op) {
  switch ($op) {
    case 'game_events':
      $headers = array(
        'minute',
        'type',
        'team',
        'player'
      );
  }
  $header_string = '<tr>';
  foreach ($headers as $header) {
    $header_string .= '<th>' . ucfirst($header) . '</th>';
  }
  $header_string .= '</tr>';
  return $header_string;
}
