<?php
include_once './include.php';
?>

<div class="navbar navbar-inverse">
  <div class="navbar-inner">
    <div class="container">
      <a class="brand" href="/"><img src="/assets/USA_Rugby_bw.png"/></a>
      <ul class="nav pull-right">
        <li><a href='/'>Competitions</a></li>
        <li><a href='/help.php'>Help</a></li>

<?php
//If the user has a team specific login, provide link to their roster page.
if ($_SESSION['teamid'] > 0) {
    echo "<li><a href='/team.php?id={$_SESSION['teamid']}'>My Rosters</a></li>";
}

//only display Admin Options to admins
if (editCheck(1)) {
    echo "<li><a href='/admin.php'>Admin Options</a></li>";
}
?>

      </ul>
    </div>
  </div>
</div>
<div id="maincontent">

