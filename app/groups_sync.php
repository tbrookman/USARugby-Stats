<?php
use Source\QueueHelper;

header('Location: ' . $_SERVER['HTTP_REFERER']);
include_once './include.php';
use Source\APSource;

if (editCheck(1))
{
    // Enqueue Group Sync operation.
    $qh = new QueueHelper();
    $qh->GroupSync($_SESSION['_sf2_attributes']);

    $_SESSION['alert_message'] = "Group Sync enqueued.";
}
