<?php
include_once './include.php';

echo "<h1>User Management</h1>\n";


echo "<div id='users'>";
echo "<h2>Current Users</h2>";
include_once './users_list.php';
echo "</div>";

echo "<div id='useradd'>";
echo "<h1>Add a User</h1>\n";
include_once './add_user.php';
echo "</div>";

include_once './footer.php';
