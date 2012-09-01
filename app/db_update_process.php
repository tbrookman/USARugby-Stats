<?php
include_once './header.php';

//verify we can edit.  1 is usarugby only.  Redirect if not?
if (editCheck(1)) {

    if ($_FILES["file"]["error"] > 0) {
        echo "Error: " . $_FILES["file"]["error"] . "<br />";
    } else {
        echo "Uploaded: " . $_FILES["file"]["name"] . "<br />";
        //echo "Type: " . $_FILES["file"]["type"] . "<br />";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br /><br/>";
        //echo "Stored in: " . $_FILES["file"]["tmp_name"];

        $row = 1;
        if (($handle = fopen($_FILES["file"]["tmp_name"], "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                //$num = count($data);
                //echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                $now = date('Y-m-d H:i:s');

                if ($data[0] && $data[1] && $data[2] && $data[3] && is_numeric($data[0]) && is_numeric($data[1])) {

                    if (tExists($data[1])) {
                        //in case the name has any single quotes
                        $fn = addslashes($data[2]);
                        $ln = addslashes($data[3]);

                        if (pExists($data[0])) {
                            echo "Player Exists, updating.<br/>";
                            $query = "UPDATE `players` SET user_create='{$_SESSION['user']}',last_update='$now',team_fsi_id='{$data[1]}',firstname='$fn',lastname='$ln' WHERE fsi_id='{$data[0]}'";
                            $result = mysql_query($query);
                            //echo "$query<br/>";
                        } else {
                            echo "Player does not exist, inserting.<br/>";
                            $query = "INSERT INTO `players` VALUES ('','{$_SESSION['user']}','$now','{$data[0]}','{$data[1]}','$fn','$ln')";
                            $result = mysql_query($query);
                            //echo $query."<br/>";
                        }

                    } else {
                        echo "No team found with that number. Player not added.<br/>";
                    }

                    echo "{$data[0]} - {$data[1]} - {$data[2]} {$data[3]}<br/><br/>\n";

                }

            }
            fclose($handle);
        }

    }
}
