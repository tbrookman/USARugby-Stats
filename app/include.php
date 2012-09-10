<?php
include_once './prepare_request.php';
include_once './DataSource.php';
include_once './session.php';
include_once './user_check.php';
include_once './db.php';
?>

<html lang="en">
<head>

<?php
echo "<title>USA Rugby National Championship Series</title>";
?>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Styles -->
  <link href="/assets/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="/assets/vendor/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

<?php
include_once './display_funcs.php';
include_once './other_funcs.php';
?>

  <script src='/assets/vendor/jquery.min.js'></script>
  <script src='/assets/vendor/bootstrap/js/bootstrap.js'></script>
  <script src='jquery_funcs.js'></script>

</head>
<body>

<?php
include_once './header.php';
