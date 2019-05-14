<?php
include_once 'admin/objts/config.php';
include_once 'admin/objts/utitlity.php';
include_once 'admin/objts/school.php';
$sch = new school();
$ut = new utitlity();
$cf = new config();
$cf->connect();
$uname = mysqli_real_escape_string($cf->con, $_GET['uname']);
$upass = mysqli_real_escape_string($cf->con, $_GET['upass']);
$up = md5($upass);
$login = mysqli_query($cf->con, "select uname from staff where uname = '$uname'");
$dline = mysqli_fetch_object(mysqli_query($cf->con, "select * from deadline"));
$today = date("Y-m-d");
header("content-Type:application/JSON");
if (mysqli_num_rows($login) < 1) {
    echo '{"uname":"none",
            "msg":"Invalid user account please contact your admin if it persist",
            "User_type":"none",
            "status":"none"
          }';
} else {
    $uobjt = mysqli_fetch_object($login);
    $passtest = mysqli_query($cf->con, "select * from staff where uname = '$uobjt->uname' and upass = '$up'");
    if (mysqli_num_rows($passtest) < 1) {
        echo '{"uname"     : "' . $uobjt->uname . '",
            "msg"      : "Your password is incorrect, please check and try again",
            "User_type": "none",
            "status"     : "none"
          }';

    } else {

        session_start();
        $uinfo = mysqli_fetch_object($passtest);
        $ut->uid = $uinfo->id;
        $ut->action = 'Successfully logged in';
        $ut->create_log();
        if ($uinfo->user_type == "admin") {
            $_SESSION['ad_uname'] = $uinfo->uname;
            $_SESSION['ad_fname'] = $uinfo->fname;
            $_SESSION['ad_lname'] = $uinfo->lname;
            $_SESSION['ad_gender'] = $uinfo->gender;
            $_SESSION['ad_id'] = $uinfo->id;
            $_SESSION['ad_utype'] = $uinfo->user_type;
            $_SESSION['school_id'] = $sch->code;
        } else {
            $_SESSION['uname'] = $uinfo->uname;
            $_SESSION['fname'] = $uinfo->fname;
            $_SESSION['lname'] = $uinfo->lname;
            $_SESSION['gender'] = $uinfo->gender;
            $_SESSION['utype'] = $uinfo->user_type;
            $_SESSION['id'] = $uinfo->id;
            $_SESSION['school_id'] = $sch->code;
        }
        echo '{"uname"     : "' . $uinfo->uname . '",
            "msg"           : "ok",
            "user_type"     : "' . $uinfo->user_type . '",
            "status"        : "' . $uinfo->status . '",
            "id"            : "' . $uinfo->id . '"

          }';


    }


}
    
    

