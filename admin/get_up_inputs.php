<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
$cnn = new config();
$cnn->connect();
$id = $_GET['id'];
$query = mysqli_query($cnn->con, "select * from staff where id = '$id'");
while ($row = mysqli_fetch_assoc($query)) {
    $ranklist = ["Senior Sup't", "Prin. Sup't", "Assist. Dir ii", "Assist. Dir I", "Dep. Dir.", "Dir. II", "Dir. I"];

    ?>

    <form>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm12 col-xs-12">
                <div class="md-form">

                    <label class="active form-control-label" for="upfname">First Name</label>
                    <input class="form-control" id="upfname" type="text" value="<?php echo "$row[fname]"; ?>"/>

                </div>

            </div>
            <div class="col-lg-6 col-md-6 col-sm12 col-xs-12">

                <div class="md-form">
                    <label for="uplname" class="active form-control-label">Last Name</label>
                    <input class="form-control" id="uplname" type="text" value="<?php echo "$row[lname]"; ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label class="control-label">Gender</label>
                <select class="form-control" id="upgender">
                    <?php
                    if ($row['gender'] === "Male") {
                        ?>
                        <option>Male</option>

                        <option>Female</option>


                        <?php
                    } else {

                        ?>

                        <option>Female</option>
                        <option>Male</option>


                        <?php
                    }


                    ?>

                </select>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="md-form">

                    <label for="upcontact" class="active form-control-label">Contact</label>
                    <input type="text" class="form-control" value="<?php echo $row['contact']; ?>" id="upcontact"/>

                </div>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label class="control-label">Rank</label>

                <select id="uprank" class="form-control">

                    <?php

                    for ($i = 0; $i < count($ranklist); $i++) {

                        ?>
                        <option <?= ($i == $row['staff_rank']) ? "Selected" : "" ?>
                                value="<?= $i ?>"><?= $ranklist[$i] ?></option>

                        <?php
                    }
                    ?>


                </select>


            </div>


        </div>

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                <div class="md-form">
                    <label class="active form-control-label" for="upstfid">Staff ID No.</label>
                    <input id="upstfid" type="text" class="form-control" value="<?= $row['stfid']; ?>"/>

                </div>


            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="md-form">
                    <label class="active form-control-label" for="updob">D.O.B</label>
                    <input id="updob" type="date" class="form-control" value="<?= $row['dob']; ?>"/>
                </div>

            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                <div class="md-form">
                    <label class="active form-control-label" for="upregno">Registered No.</label>
                    <input id="upregno" type="text" class="form-control" value="<?= $row['regno']; ?>"/>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="md-form">

                    <label class="active form-control-label" for="upssnid">SSNIT NO.</label>
                    <input id="upssnid" type="text" class="form-control" value="<?= $row['snnid']; ?>"/>

                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                <div class="md-form">
                    <label class="active form-control-label" for="upaqual">Academic Qualification</label>
                    <input id="upaqual" type="text" class="form-control" value="<?= $row['aqual']; ?>"/>
                </div>


            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                <div class="md-form">
                    <label class="active form-control-label" for="uppqual">Professional Qualification</label>
                    <input id="uppqual" type="text" class="form-control" value="<?= $row['pqual']; ?>"/>

                </div>


            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="md-form">
                    <label class="active form-control-label" for="upappdate">Date Of First Appointment</label>
                    <input id="upappdate" type="date" class="form-control" placeholder="Enter Date"
                           value="<?= $row['appdate']; ?>"/>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="md-form">
                    <label class="active form-control-label" for="upassdate">Assumption Of Duty(Date)</label>
                    <input id="upassdate" type="date" class="form-control" placeholder="Enter Date"
                           value="<?= $row['assdate']; ?>"/>
                </div>


            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="md-form">
                    <label class="active form-control-label" for="upbank">Associated Bank</label>
                    <input id="upbank" type="text" class="form-control" value="<?= $row['bank']; ?>"/>

                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="md-form">
                    <label class="active form-control-label" for="upaccno">Account Number</label>
                    <input id="upaccno" type="text" class="form-control" value="<?= $row['accno']; ?>"/>
                </div>

            </div>
        </div>

    </form>

    <?php
}
