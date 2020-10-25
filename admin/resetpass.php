<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');

use APP\config;

$cf = new config();
$cf->connect();
$id = $_GET['id'];
$user = mysqli_query($cf->con, "select * from staff where id = '$id'");
$user_info = mysqli_fetch_object($user);
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="md-form">
                    <i class="fa fa-user prefix"></i>
                    <input type="text" readonly="" value="<?= $user_info->fname . " " . $user_info->lname; ?>"
                           class="form-control"/>
                    <label class="control-label active">
                        Name
                    </label>
                </div>

            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="md-form">
                    <i class="fa fa-lock prefix"></i>

                    <input type="password" id="new_pass" class="form-control"/>
                    <label class="control-label">
                        New Password
                    </label>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="md-form">
                    <i class="fa fa-lock prefix"></i>
                    <input type="password" id="cnew_pass" class="form-control"/>
                    <label class="control-label">
                        Confirm Password
                    </label>
                </div>

            </div>

        </div>

    </div>

</div>