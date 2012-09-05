<?php
//if we haven't given the user a session name, send them to login.

if (!(isset($_SESSION['user']) && $_SESSION['user'])) {
  $allow = FALSE;
  $allowed_iframe_scripts = array(
    '/game.php',
  );
  // Allow only if allowed script, and iFrame request present.
  if (!empty($request) &&
      (in_array($request->getScriptName(), $allowed_iframe_scripts) && $request->get('iframe'))) {
    $allow = TRUE;
  }

  $allow == TRUE ?: header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login.php');
}
