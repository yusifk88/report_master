<?php
include_once("../admin/objts/config.php");
$cf = new config();
$id = $_GET['id'];
$cf->connect();

mysqli_query($cf->con, "delete from books_lend where id = '$id'");