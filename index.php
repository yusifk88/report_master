<?php
include_once './admin/objts/school.php';
include_once './admin/objts/config.php';
$cf = new config();
$cf->connect();
$sch = new school();
session_start();
session_destroy();
$dead = mysqli_fetch_object(mysqli_query($cf->con,"select * from deadline"));
?>
<!DOCTYPE html>


<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <title>Report Master | Log In</title>
    <link rel="icon" href="admin/img/rmicon.png"/>
    <link href="admin/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="admin/css/mdb.min.css" rel="stylesheet" type="text/css"/>
    <link href="admin/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="admin/css/atlantis.min.css" rel="stylesheet" type="text/css"/>
    <link href="admin/css/mystyle.css" rel="stylesheet" type="text/css"/>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="">
<div class="container-fluid p-0">
    <div class="row" style="position: absolute; height: 100%; width: 100%;">
        <div class="col-md-4" style="background-image: url('admin/img/login_bg.jpg');">

        </div>
        <div class="col-md-8 col-12 pt-5">

            <div class="card animated fadeInUp mt-5 container-fluid">


                <div class="row">
                        <div class="col-12 col-md-6 my-auto ">
                            <div class="card-header">
                                <div class="col-md-12 col-12 text-center p-3 m-0">
                                   <h4> <i class="fa fa-lock"></i> Please login to continue</h4>

                                </div>
                            </div>
                            <form action="" class="m-1">
                                <div class="md-form">
                                    <input type="text" id="uname" class="form-control">
                                    <label for="uname">User Name</label>
                                </div>

                                <div class="md-form">
                                    <input type="password" id="upass" class="form-control">
                                    <label for="upass">Password</label>
                                </div>
                                <br>
                                <div class="g-recaptcha" data-sitekey="6LfgNncUAAAAAKZLB_fZLSkBySpHmU8iXc83u9Is"></div>

                                <button type="button" id="btnlogin" style="border-radius: 0;" class=" btn bg-primary btn-block btn-lg">LogIn <i
                                            class="fa fa-sign-in"></i></button>
                            </form>

                        </div>
                        <div class="col-md-6 col-12 bg-primary-gradient">
                        <div class="list-group list-group-flush text-white">
                            <div class="list-group-item bg-transparent">
                                    <i class="fa fa-info-circle fa-2x text-white "></i>
                                    Please note that anything you do is recorded against your user account for security auditing purposes

                            </div>

                            <div class="list-group-item bg-transparent">
                                <div class="row">
                                <div class="col-md-3 col-3">
                                    <i class="fa fa-clock-o fa-2x text-white"></i>
                                </div>
                                <div class="col-md-9 col-9 text-white">
                                    <?php
                                        if($dead->status == 'ON'){
                                            ?>

                                            Deadline set for <?=$dead->ddate?> you will not be able to log in after this day

                                            <?php
                                        }else{
                                            ?>
                                            No deadline set for staff

                                            <?php
                                        }
                                    ?>

                                </div>
                            </div>
                        </div>


                            <div class="list-group-item bg-transparent">

                                    <i class="fa fa-calendar-check-o fa-2x text-white"></i>

                                <?php
                                    if($sch->sub_date == null){
                                        ?>

                                        Your school is not on a subscription
                                        <?php

                                    }else{
                                    if($sch->sub_expired()) {
                                    ?>
                                    <h3 class="text-danger">Expired!</h3>

                                        <?php
                                    }else{
                                        ?>
                                            <h5 class="text-white">Next Subscription date: <strong><?=date('d-M-Y',strtotime($sch->sub_date))?></strong></h5>
                                        <h5 class="text-danger"><?=$sch->get_subdays()?> Days More</h5>


                                        <?php
                                    }}

                                ?>



                        </div>

                        </div>
                        </div>
                    </div>


                <?php
                if($sch->sub_expired()){
                    ?>
                    <div class="card-footer bg-danger m-0 text-white">
                        Your portal subscription is Over. per our agreed terms and conditions, some system features will not work. Please contact us to renew your subscription <br>
                        info@skoolrec.com or 0549403129
                    </div>
                    <?php
                }

                ?>
            </div>
			
			
		
			
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 cil-xs-12 col-lg-off-4 col-md-offset-4">
                    <br/>
                    <span id="msg" style="color: red; display: none; text-align: center;">
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="admin/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="admin/js/bootstrap.min.js" type="text/javascript"></script>
<script src="admin/js/mdb.min.js" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        $("#btnlogin").click(function () {
			
			var cac = grecaptcha.getResponse();

			if(cac.length > 0){			
            $("#msg").html("Please wait....").show();

            if (!$("#uname").val() && !$("#upass").val()) {
                $("#msg").html("<span class='glyphicon glyphicon-warning-sign'></span> You have not entered your user account information");
                $("#msg").fadeIn();

            } else if (!$("#uname").val()) {

                $("#msg").html("<span class='glyphicon glyphicon-warning-sign'></span> You have not entered your user name");
                $("#msg").fadeIn();
            } else if (!$("#upass").val()) {
                $("#msg").html("<span class='glyphicon glyphicon-warning-sign'></span> You have not entered your password");
                $("#msg").fadeIn();
            } else {
                $.getJSON("login.php?uname=" + $("#uname").val() + "&upass=" + $("#upass").val(), function (data) {
                    if (data.uname == "none" || data.msg != "ok") {
                        $("#msg").html("<span class='glyphicon glyphicon-warning-sign'></span> " + data.msg);
                        $("#msg").fadeIn();
                    } else if (data.status == "Disabled") {
                        $("#msg").html("<span class='glyphicon glyphicon-warning-sign'></span> Your user account is currently disabled please contact your system admin");
                        $("#msg").fadeIn();
                    } else if (data.user_type == "admin") {
                        window.location = "admin/";
                    } else if (data.user_type == "staff") {
                        $.getJSON("testdead.php", function (data) {
                            if (data.status == 0) {
                                window.location = "staff/";
                            } else {
                                $("#msg").html("<span class='glyphicon glyphicon-warning-sign'></span> Sorry, the deadline set by your admin has been met");
                                $("#msg").fadeIn();
                            }
                        });
                    }

                }).error(function () {
                    $("#msg").fadeOut();
                    show_error();
                });
            }
			}else{
				
				 $("#msg").html("You have NOT checked the captcha, please prove you are not a robot");
                                $("#msg").fadeIn();
				
				
			}
        });
        $("#uname,#upass").keypress(function (e) {
            if (e.which === 13) {
                $("#btnlogin").click();
            }

        });
    });
</script>
</body>
</html>
