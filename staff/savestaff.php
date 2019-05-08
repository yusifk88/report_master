<?php
include_once './objts/config.php';
include_once './objts/staff.php';
$fname = $_GET['fname'];
$lname = $_GET['lname'];
$cont = $_GET['cont'];
$gender = $_GET['gender'];
$uname = $_GET['uname'];
$upass = $_GET['upass'];
$stf = new Staff();
$stf->fname=$fname;
$stf->lname=$lname;
$stf->gender=$gender;
$stf->contact=$cont;
$stf->uname=$uname;
$stf->upass= md5($upass);
$d=$stf->createstaff();
echo $d;