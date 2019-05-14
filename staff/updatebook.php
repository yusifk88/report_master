<?php
include_once("objts/config.php");
$cf = new config();
$cf->connect();
$bid = $_POST['upbid'];
$author = mysqli_escape_string($cf->con, $_POST['upbookAuthor']);
$isbn = mysqli_escape_string($cf->con, $_POST['upbookISBN']);
$copies = mysqli_escape_string($cf->con, $_POST['upbookQty']);
$shelf = mysqli_escape_string($cf->con, $_POST['upbookShelf']);
$title = mysqli_escape_string($cf->con, $_POST['upbookTitle']);
$desc = mysqli_escape_string($cf->con, $_POST['upbookDesc']);

mysqli_query($cf->con, "update books set title = '$title',author = '$author',isbn = '$isbn',shelf = '$shelf',copies = '$copies',descrip='$desc' where id ='$bid'");