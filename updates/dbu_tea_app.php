<?php
require('../maincore.php');

$creatTable=dbquery("ALTER TABLE teacherappointments
ADD teacherappointments_fdaydate date NOT NULL;");

header("Location: ".$_SERVER['HTTP_REFERER']);
?>
