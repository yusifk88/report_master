<?php
include_once 'objts/config.php';
$con = mysqli_connect("localhost", "wesoft", "032102726042");
mysqli_select_db($con, "reportdb");
mysqli_query($con, "ALTER TABLE records change exam exam DOUBLE NOT NULL");
?>

<h2>Congratulations Done!</h2>
