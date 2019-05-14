<!DOCTYPE html>
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
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <title>Report Master |Log In</title>
    <link rel="icon" href="admin/img/rmicon.png"/>
    <link href="admin/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="admin/css/mdb.min.css" rel="stylesheet" type="text/css"/>
    <link href="admin/css/mystyle.css" rel="stylesheet" type="text/css"/>
    <link href="admin/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="admin/css/wecss.css" rel="stylesheet" type="text/css"/>
    <link href="admin/css/mystyle.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-12 mx-auto pt-5">
            <div class="card animated fadeInUp mt-5 container-fluid">
                    <div class="row">
                        <div class="col-md-12 col-12 bg-warning text-center p-3 m-0">
                            <i class="fa fa-lock"></i> USER AUTHENTICATION

                        </div>
                    </div>

                <div class="row">
                        <div class="col-12 col-md-4 my-auto ">

                            <form action="" class="m-1">
                                <div class="md-form">
                                    <i class="fa fa-user prefix grey-text"></i>
                                    <input type="text" id="uname" class="form-control">
                                    <label for="uname">User Name</label>
                                </div>

                                <div class="md-form">
                                    <i class="fa fa-asterisk prefix grey-text"></i>
                                    <input type="password" id="upass" class="form-control">
                                    <label for="upass">Password</label>
                                </div>
                                <br>
                                <button type="button" id="btnlogin" style="border-radius: 0;" class=" btn bg-info btn-block btn-lg">LogIn <i
                                            class="fa fa-sign-in"></i></button>
                            </form>

                        </div>
                        <div class="col-md-8 col-12 bg-info">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item bg-transparent">
                                <div class="row">
                                <div class="col-md-3 col-3">
                                    <i class="fa fa-info-circle fa-4x text-white"></i>
                                </div>
                                <div class="col-md-9 col-9 text-white">
                                    Please note that anything you do is recorded against your user account for security auditing purposes
                                </div>
                            </div>
                        </div>
                            <div class="list-group-item bg-transparent">
                                <div class="row">
                                <div class="col-md-3 col-3">
                                    <i class="fa fa-clock-o fa-4x text-white"></i>
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
                                <div class="row">
                                <div class="col-md-3 col-3">
                                    <i class="fa fa-calendar-check-o fa-4x text-white"></i>
                                </div>
                                <div class="col-md-9 col-9 text-white">
                                <?php
                                    if($sch->sub_date == null){
                                        ?>

                                        Your school is not on a subscription
                                        <?php

                                    }

                                ?>


                                </div>
                            </div>
                        </div>

                        </div>
                        </div>
                    </div>



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
