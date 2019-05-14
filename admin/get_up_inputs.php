<?php
include_once './objts/config.php';
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
                    <i class="fa fa-user prefix active "></i>

                    <input class="form-control" id="upfname" type="text" value="<?php echo "$row[fname]"; ?>"/>
                    <label class="active" for="upfname">First Name</label>

                </div>

            </div>
            <div class="col-lg-6 col-md-6 col-sm12 col-xs-12">

                <div class="md-form">
                    <i class="prefix fa fa-user active"></i>
                    <input class="form-control" id="uplname" type="text" value="<?php echo "$row[lname]"; ?>"/>
                    <label for="uplname" class="active">Last Name</label>
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
                    <i class="prefix fa fa-phone active"></i>

                    <input type="text" class="form-control" value="<?php echo $row['contact']; ?>" id="upcontact"/>
                    <label for="upcontact" class="active">Contact</label>

                </div>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label class="control-label">Rank</label>

                <select id="uprank" class="form-control">

                    <?php

                    for ($i = 0; $i < count($ranklist); $i++) {

                        ?>
                        <option <?= ($i == $row['rank']) ? "Selected" : "" ?>
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
                    <i class="prefix fa fa-id-badge active"></i>
                    <input id="upstfid" type="text" class="form-control" value="<?= $row['stfid']; ?>"/>
                    <label class="active" for="upstfid">Staff ID No.</label>

                </div>


            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="md-form">
                    <i class="fa fa-calendar-check-o prefix active"></i>
                    <input id="updob" type="date" class="form-control" value="<?= $row['dob']; ?>"/>
                    <label class="active" for="updob">D.O.B</label>
                </div>

            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                <div class="md-form">
                    <i class="prefix fa fa-hashtag active"></i>
                    <input id="upregno" type="text" class="form-control" value="<?= $row['regno']; ?>"/>
                    <label class="active" for="upregno">Registered No.</label>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="md-form">
                    <i class="prefix fa fa-id-card-o active"></i>

                    <input id="upssnid" type="text" class="form-control" value="<?= $row['snnid']; ?>"/>
                    <label class="active" for="upssnid">SSNIT NO.</label>

                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                <div class="md-form">
                    <i class="prefix fa fa-graduation-cap active"></i>
                    <input id="upaqual" type="text" class="form-control" value="<?= $row['aqual']; ?>"/>
                    <label class="active" for="upaqual">Academic Qualification</label>
                </div>


            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                <div class="md-form">
                    <i class="prefix fa fa-star active"></i>
                    <input id="uppqual" type="text" class="form-control" value="<?= $row['pqual']; ?>"/>
                    <label class="active" for="uppqual">Professional Qualification</label>

                </div>


            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="md-form">
                    <i class="prefix fa fa-calendar-o active"> </i>
                    <input id="upappdate" type="date" class="form-control" placeholder="Enter Date"
                           value="<?= $row['appdate']; ?>"/>
                    <label class="active" for="upappdate">Date Of First Appointment</label>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="md-form">
                    <i class="active fa fa-calendar-plus-o prefix"></i>
                    <input id="upassdate" type="date" class="form-control" placeholder="Enter Date"
                           value="<?= $row['assdate']; ?>"/>
                    <label class="active" for="upassdate">Assumption Of Duty(Date)</label>
                </div>


            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="md-form">
                    <i class="prefix fa fa-bank active"> </i>
                    <input id="upbank" type="text" class="form-control" value="<?= $row['bank']; ?>"/>
                    <label class="active" for="upbank">Associated Bank</label>

                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="md-form">
                    <i class="prefix fa fa-universal-access active"></i>
                    <input id="upaccno" type="text" class="form-control" value="<?= $row['accno']; ?>"/>
                    <label class="active" for="upaccno">Account Number</label>
                </div>

            </div>
        </div>

    </form>

    <?php
}
