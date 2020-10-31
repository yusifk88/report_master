<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\Students;
use APP\config;

$cf = new config();
$cf->connect();
$student = new Students();
$student->index = mysqli_real_escape_string($cf->con, $_POST['index']);
$student->jhsno = mysqli_real_escape_string($cf->con, $_POST['jhsno']);
$student->shsno = mysqli_real_escape_string($cf->con, $_POST['shsno']);
$student->photo = mysqli_real_escape_string($cf->con, $_POST['photo']);
$student->fname = mysqli_real_escape_string($cf->con, $_POST['fname']);
$student->lname = mysqli_real_escape_string($cf->con, $_POST['lname']);
$student->oname = mysqli_real_escape_string($cf->con, $_POST['oname']);
$student->dob = $_POST['dob'];
$student->dor = $_POST['dor'];
$student->dept = $_POST['dept'];
$student->house = $_POST['house'];
$student->clas = $_POST['clas'];
$student->lschool = mysqli_real_escape_string($cf->con, $_POST['lsch']);
$student->fhometown = mysqli_real_escape_string($cf->con, $_POST['fhtown']);
$student->ffname = mysqli_real_escape_string($cf->con, $_POST['fthname']);
$student->ftel = mysqli_real_escape_string($cf->con, $_POST['pthtel']);
$student->mfname = mysqli_real_escape_string($cf->con, $_POST['mthname']);
$student->mtel = mysqli_real_escape_string($cf->con, $_POST['mthtel']);
$student->mhometown = mysqli_real_escape_string($cf->con, $_POST['mtown']);
$student->ayear = $_POST['ayear'];
$student->gender = $_POST['gender'];
$student->form = $_POST['form'];
$student->ghouse = $_POST['ghouse'] ? $_POST['ghouse'] : 0 ;
$student->resstatus = $_POST['restatus'];

echo $student->createstudent();
