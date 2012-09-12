<?php
include_once './include.php';

//verify we can edit.  1 is usarugby only.  Redirect if not?
if (editCheck(1)) {

    echo "<h1>Admin Options</h2>";

    // @TODO: Investigate and possibly remove completely.
    //        db_update player and team.
    echo "<a href='db_update.php'>Update Player Database</a><br/>";
    echo "<a href='db_update_team.php'>Add Club to Club Database</a><br/>";
    echo "<a href='users.php'>User Management</a><br/>";
    echo "<a href='groups_sync.php'>Pull in Groups from AllPlayers</a><br />";
    echo "<a href='group_members_sync.php'>Pull in Players from a group</a>";

}

include_once './footer.php';
