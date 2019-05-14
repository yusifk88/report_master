<?php
include_once("objts/config.php");
$cf = new config();
$cf->connect();
$title = mysqli_escape_string($cf->con, $_POST['title']);
$author = mysqli_escape_string($cf->con, $_POST['author']);
$desc = mysqli_escape_string($cf->con, $_POST['desc']);
$ISBN = mysqli_escape_string($cf->con, $_POST['ISBN']);
$shelf = mysqli_escape_string($cf->con, $_POST['shelf']);
$copies = mysqli_escape_string($cf->con, $_POST['copies']);

mysqli_query($cf->con, "insert into books(title,author,isbn,shelf,copies,descrip) VALUES('$title','$author','$ISBN','$shelf','$copies','$desc')");