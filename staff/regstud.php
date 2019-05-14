<?php
include_once './objts/config.php';
include_once './objts/students.php';
//try{
$student = new Students();
//$exten = substr($_POST['photo'], -4);
// unlink("pass/".$_POST['index'].$exten);
/*if(copy($_POST['photo'], "pass/".$_POST['index'].$exten)){
    
  $newpic ="pass/".$_POST['index'].$exten; 
  unlink($_POST['photo']);  
}else{
    
    echo 'Could not save passport, make sure you select a passport picture';
    exit();
}
*/

$student->index = mysql_real_escape_string($_POST['index']);
$student->photo = mysql_real_escape_string($_POST['photo']);
$student->fname = mysql_real_escape_string($_POST['fname']);
$student->lname = mysql_real_escape_string($_POST['lname']);
$student->oname = mysql_real_escape_string($_POST['oname']);
$student->dob = $_POST['dob'];
$student->dor = $_POST['dor'];
$student->dept = $_POST['dept'];
$student->house = $_POST['hse'];
$student->clas = $_POST['cls'];
$student->lschool = mysql_real_escape_string($_POST['lsch']);
$student->fhometown = mysql_real_escape_string($_POST['fhtown']);
$student->ffname = mysql_real_escape_string($_POST['fthname']);
$student->ftel = mysql_real_escape_string($_POST['pthtel']);
$student->mfname = mysql_real_escape_string($_POST['mthname']);
$student->mtel = mysql_real_escape_string($_POST['mthtel']);
$student->mhometown = mysql_real_escape_string($_POST['mtown']);
$student->ayear = $_POST['ayear'];
$student->gender = $_POST['gender'];
$student->form = $_POST['form'];
$msg = $student->createstudent();
echo $msg;


/*
}  catch(){
echo 'Could not save data, please check and try again';
    
};*/