<?php
include_once ('./include.php'); 

echo "<h1>Welcome to USA Rugby's National Championship Series!</h1>";

if (editCheck(1))
{
echo "<a href='add_comp.php'>Add New Competition</a><br/>\r";
}

//List our comps
echo "<h2>Competitions</h2>";
echo "<div id='comps'>";
include_once ('./comp_list.php');
echo "</div>";


 include_once ('./footer.php');
mysql_close();
?>