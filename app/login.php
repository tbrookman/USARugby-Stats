<?php
include_once './prepare_request.php';
header('Location: ' . $request->getScheme() . '://' . $request->getHost());
//Start session
include_once './session.php';

$user=isset($_SESSION['user']) ? $_SESSION['user'] : NULL;

if (!$user) {
    // If we don't have a logged in user, just clean out the session.
    session_destroy();
}
