<?php

include_once './objts/config.php';
include_once './objts/staff.php';
$cfg = new config();
$cfg->connect();
$stf = new Staff();

$stf = new Staff();
$stf->id = $_GET['id'];
$stf->lname = $_GET['lname'];
$stf->fname = $_GET['fname'];
$stf->gender = $_GET['gender'];
$stf->contact = $_GET['contact'];
$stf->stfid = $_GET['stfid'];
$stf->dob = $_GET['dob'];
$stf->regno = $_GET['regno'];
$stf->aqual = mysqli_real_escape_string($cfg->con,$_GET['aqual']);
$stf->pqual = mysqli_real_escape_string($cfg->con,$_GET['pqual']);
$stf->appdate= $_GET['appdate'];
$stf->assdate = $_GET['assdate'];
$stf->bank = $_GET['bank'];
$stf->acno = $_GET['accno'];
$stf->ssnid = $_GET['ssnid'];
$stf->rank = $_GET['rank'];
$msg = $stf->updatestaff();
echo $msg;