<?php
include('maincore.php');

$username = trim(strtolower($_POST['teach_id']));
$username = mysql_escape_string($username);

$query = dbquery("SELECT teach_id FROM teacher WHERE teach_id = '$username' LIMIT 2");
$num = dbrows($query);

echo $num;
?>
