<?php
include_once './include_mini.php';

if (editCheck(1)) {

    $name = mysql_real_escape_string($_POST['name']);
    $num = mysql_real_escape_string($_POST['num']);

    //check if team exists with number
    $query = "SELECT * FROM `teams` WHERE uuid='$num'";
    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        echo "A club with that ID number is already in database.\n";
    }

    //check if team exists with name
    $query = "SELECT * FROM `teams` WHERE name='$name'";
    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        echo "A club with that name is already in database.\n";
    }

}
