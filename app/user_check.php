<?php
//if we haven't given the user a session name, send them to login.

if (!(isset($_SESSION['user']) && $_SESSION['user'])) {
    if (!empty($request)) {
      $allowed_iframe_scripts = array(
        '/game.php',
      );
      if (!in_array($request->getScriptName(), $allowed_iframe_scripts) ||
          !$request->get('iframe')) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login.php');
      }
    }
    else {
      header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login.php');
    }
}
