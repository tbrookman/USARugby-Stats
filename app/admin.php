<?php
include_once './include.php';

//verify we can edit.  1 is usarugby only.  Redirect if not?
if (editCheck(1)) {

    echo "<h1>Admin Options</h2>";

    echo "<a href='db_update.php'>Update Player Database</a><br/>";
    echo "<a href='db_update_team.php'>Add Club to Club Database</a><br/>";
    echo "<a href='users.php'>User Management</a><br/>";
    echo "<a href='groups_sync.php'>Pull in Groups from AllPlayers</a>";

}

include_once './footer.php';
