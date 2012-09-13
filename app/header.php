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
    ?>
    <li class = "dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin Options <b class = "caret"></b></a>
        <ul class = "dropdown-menu">
            <li><a href='db_update.php'>Update Player Database</a></li>
            <li><a href='db_update_team.php'>Add Club to Club Database</a></li>
            <li><a href='users.php'>User Management</a></li>
            <li><a href='groups_sync.php'>Pull in Groups from AllPlayers</a></li>
            <li><a href='group_members_sync.php'>Pull in Players from a group</a></li>
        </ul>
    </li>
    <?php
}
?>

      </ul>
    </div>
  </div>
</div>
<div id="maincontent">

