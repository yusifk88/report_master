<?php
include_once("objts/utitlity.php");
include_once("objts/config.php");
include_once("objts/school.php");
ini_set("max_execution_time",600);
$sch = new school();
if($sch->SMSsub == false){
    exit(0);
}
$cf = new config();
$cf->connect();
$ut = new utitlity();
$term = $_POST["term"];
$cls = $_POST["cls"];
$ayear = $_POST["ayear"];
$studs = mysqli_query($cf->con, "select * from stuinfo where class = '$cls' and stuinfo.id in(SELECT stid from records WHERE term = '$term' and acyear = '$ayear' and cls = '$cls' ) ");
$test = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from smsreport where cls ='$cls' and term = '$term' and ayear = '$ayear' "))->cn;
$sent = 0;
$faild = 0;
$i = 0;
if ($test < 1) {
    while ($row = mysqli_fetch_object($studs)) {
        $i++;
        $ut->numbers = $row->ftel;
        $message = "Dear Sir, here are the results of your ward(" . $row->fname . " " . $row->lname . ") for " . $ut->addsufix($term) . " Term " . $ayear . " Academic year %0a";
        $res = mysqli_query($cf->con, "select subjt,subtotl,exam,cvsubtotl,cvexam,totlscore,subjects.subjdesc,post,((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) as tscore from records,subjects where acyear = '$ayear' and term = '$term' and cls = '$cls' and stid = '$row->id' and records.subjt = subjects.id ORDER by subjdesc ASC ");
        while ($rep = mysqli_fetch_object($res)) {
            $message .= $rep->subjdesc . " " . number_format($rep->tscore, 1) . "(" . $ut->getgrd(number_format($rep->tscore, 1)) . ")%0a";
        }
        $ut->message = $message;
        $sms = $ut->sendMessage();
        if ($sms == 'Messages has been sent successfully') {
            $sent++;
        } else {
            $faild++;
        }
        echo("<p>" . $sms . " - for " . $row->fname . " " . $row->lname . "</p>");
    }
    if ($sent > 0) {
        $status = $sent . " sent and " . $faild . " failed out of " . $i . " Contacts";
        mysqli_query($cf->con, "insert into smsreport(cls, term, ayear, status) VALUES('$cls','$term','$ayear','$status') ");
    }
} else {
    echo("Reports for this class were already sent please, choose a different class ");
}