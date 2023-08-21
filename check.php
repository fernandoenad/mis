<?php
include('maincore.php');

$username = trim(strtolower($_POST['stud_lrn']));
$username = mysql_escape_string($username);

$query = dbquery("SELECT stud_lrn FROM student WHERE stud_lrn = '$username' LIMIT 2");
$num = dbrows($query);

echo $num;
?>
