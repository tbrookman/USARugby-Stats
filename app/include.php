<?php
require_once __DIR__.'/../vendor/autoload.php';
include_once './prepare_request.php';
include_once './session.php';
include_once './user_check.php';
include_once './db.php';
?>

<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Styles -->
  <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.1.0/css/bootstrap-combined.min.css" rel="stylesheet" type="text/css">
  <link href="/assets/css/app.css" rel="stylesheet" type="text/css">

<?php
include_once './display_funcs.php';
include_once './other_funcs.php';
?>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.1.0/js/bootstrap.min.js" type="text/javascript"></script>
  <script src='jquery_funcs.js'></script>

</head>
<body>

<?php
include_once './header.php';

echo "<title>USA Rugby National Championship Series</title>";

