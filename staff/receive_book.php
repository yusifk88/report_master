<?php
include_once("../admin/objts/config.php");
$cf = new config();
$lid = $_POST['lid'];
$return_date = $_POST['return_date'];
$cf->connect();
mysqli_query($cf->con, "update books_lend set returned = true, date_returned = '$return_date' WHERE id ='$lid'");