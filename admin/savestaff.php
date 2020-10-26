<?php
require_once ('../vendor/autoload.php');

use APP\config;
use APP\Staff;
$cfg = new config();
$cfg->connect();
$fname = APP\Utitlity::escape($_GET['fname']);
$lname = APP\Utitlity::escape($_GET['lname']);
$cont = APP\Utitlity::escape($_GET['cont']);
$gender = APP\Utitlity::escape($_GET['gender']);

$uname = APP\Utitlity::escape($_GET['uname']);
$upass = APP\Utitlity::escape($_GET['upass']);
$rank = APP\Utitlity::escape($_GET['rank']);
$stfid = APP\Utitlity::escape($_GET['stfid']);
$dob = $_GET['sdob'];
$regno = $_GET['regno'];
$aqual = APP\Utitlity::escape($_GET['aqual']);
$pqual = App\Utitlity::escape($_GET['pqual']);
$appdate = $_GET['appdate'];
$assdate = $_GET['assdate'];
$bank = APP\Utitlity::escape($_GET['bankname']);
$accno = APP\Utitlity::escape($_GET['accno']);
$ssnid = APP\Utitlity::escape($_GET['ssnid']);

$stf = new Staff();
$stf->fname = $fname;
$stf->lname = $lname;
$stf->gender = $gender;
$stf->contact = $cont;
$stf->uname = $uname;
$stf->upass = md5($upass);
$stf->rank = $rank;
$stf->stfid = $stfid;
$stf->dob = $dob;
$stf->regno = $regno;
$stf->aqual = $aqual;
$stf->pqual = $pqual;
$stf->appdate = $appdate;
$stf->assdate = $assdate;
$stf->bankname = $bank;
$stf->accno = $accno;
$stf->ssnid = $ssnid;
$stf->bank = $bank;
//echo $stf->create();
//die();

if ($stf->validate()){
    if (!$stf->exists()){
        $stf->create();
        \APP\Utitlity::response('Staff created');

    }else{

        \APP\Utitlity::response("This email was already taken",302);

    }

}else{

    \APP\Utitlity::response('Invalid data given, please fill out all required fields',302);


}

