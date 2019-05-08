<?php
include_once './objts/config.php';
include_once './objts/staff.php';

$stf = new Staff();
$cfg = new config();
$cfg->connect();
$stfid = $_POST['stfid'];
$cls = $_POST['cls'];
$testaff = mysqli_query($cfg->con,"select fname,lname,gender,frmmaters.clid from staff,frmmaters where frmmaters.clid = '$cls' and staff.id = frmmaters.stfid ");
if(mysqli_num_rows($testaff)>0){
    $mstaff = mysqli_fetch_object($testaff);
    $pronoun = ($mstaff->gender == "Male" ? "Mr." : "Miss");
    $titl = ($mstaff->gender == "Male" ? "Form master" : "Form mistress");
    echo $pronoun." ".$mstaff->fname." ". $mstaff->lname." is currently the ". $titl ." of this Class, please select a different class";
}else{
    mysqli_query($cfg->con,"insert into frmmaters(stfid,clid) VALUES ('$stfid','$cls')");
    echo"Class added successfully";
}