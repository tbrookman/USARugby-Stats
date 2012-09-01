<?php
include_once './include.php';
echo "<a href=''>Competitions</a> - ";
echo "<a href='help.php'>Help</a> - ";

//If the user has a team specific login, provide link to their roster page.
if ($_SESSION['teamid'] > 0) {
    echo "<a href='team.php?id={$_SESSION['teamid']}'>My Rosters</a>";
}

//only display Admin Options to admins
if (editCheck(1)) {
    echo "<a href='admin.php'>Admin Options</a>";
}

// echo "<a href='logout.php'>Logout</a>";
echo "<br/>";
