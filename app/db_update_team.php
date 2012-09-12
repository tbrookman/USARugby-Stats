<?php
include_once './header.php';

//verify we can edit.  1 is usarugby only.  Redirect if not?
if (editCheck(1)) {

    echo "<h1>Add Club to Database</h1>\n";
    echo "<p>Insert the club's full name and AllPlayers UUID.</p>\n";

?>

<form name="teamaddform" id="teamaddform" method="POST" action="">
<label for="name">Full Club Name:</label>
<input type="text" name="name" id="name" />
<label class="error" for="name" id="name_error">This field is required.</label>
<br />
<label for="short">Short Name (Berkeley, LSU, United, etc.):</label>
<input type="text" name="short" id="short" />
<br />
<label for="num">AllPlayers UUID:</label>
<input type="text" name="num" id="num" />
<label class="error" for="num" id="num_error">This field is required.</label>
<br />
<input class="button" type="submit" id="teamadd" name="teamadd" value="Add Club" />
</form>

<?php

    echo "<h2>Clubs Currently in Database</h2>";
    echo "<div id='clublist'>";
    include_once './db_update_team_list.php';
    echo "</div>";

}
include_once './footer.php';
mysql_close();
