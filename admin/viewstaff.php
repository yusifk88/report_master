<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');

if ($_GET['id']) {
    $id = $_GET['id'];
    $staff = \APP\Staff::find($id);
    $config = new \APP\config();
    $config->connect();
    $activities = mysqli_query($config->con, "select * from user_log where uid = '$id'");
    if ($staff){
    ?>

    <div class="row">

        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">

                            <a class="btn btn-outline-primary" href="#/regstaf">
                                <i class="fa fa-arrow-left"></i>Back
                            </a>
                            <button title="Edit <?= $staff->fname ?>'s information " onclick="upstaff(<?= $id ?>)"
                                    class="btn btn-link">
                                Edit
                                <i title="Edit this staff's info"
                                   data-id="<?php echo $id; ?>" class="fa fa-edit"
                                ></i>
                            </button>

                            <button title="Print <?= $staff->fname ?>'s information " onclick="printstf(<?= $id ?>)"
                                    class="btn btn-link">
                                Print
                                <i title="Edit this staff's info"
                                   data-id="<?php echo $id; ?>" class="fa fa-print"
                                ></i>
                            </button>


                            <button title="Assign a subject and class to <?= $staff->fname ?>"
                                    onclick="asub(<?= $id ?>)" class="btn btn-link">
                                Assign Subject
                                <i title="Edit this staff's info"
                                   data-id="<?php echo $id; ?>" class="fa fa-book"
                                ></i>
                            </button>


                            <button title="Change <?= $staff->fname ?>'s login password"
                                    onclick="respass(<?= $id ?>,'<?= $staff->fname ?>')" class="btn btn-link">
                                Reset <?= $staff->fname ?>'s Password
                                <i
                                        data-id="<?php echo $id; ?>" class="fa fa-repeat"
                                ></i>
                            </button>

                            <button title="Delete <?= $staff->fname ?>" onclick="delstaff(<?= $id ?>)"
                                    class="btn btn-link text-danger">
                                Delete
                                <i title="Edit this staff's info"
                                   data-id="<?php echo $id; ?>" class="fa fa-remove"
                                ></i>
                            </button>


                            <button id="exduties" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    class="btn btn-primary"
                                    title="Assign some extra duties like exam officer to <?= $staff->fname ?>">
                                Manage Extra Duties <i class="fa fa-caret-down"></i>
                            </button>


                            <ul class="dropdown-menu animated" aria-labelledby="exduties">
                                <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                            onclick="mkform(<?= $id; ?>)">Form <?= $staff->gender == 'Male' ? 'Master' : 'Mistress' ?></a>
                                </li>
                                <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                            onclick="housem(<?= $id ?>); return false;">House <?= ($staff->gender == 'Male') ? 'Master' : 'Mistress' ?></a>
                                </li>
                                <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                            onclick="addshm(<?= $id ?>)">Senior
                                        House <?= ($staff->gender == 'Male') ? 'Master' : 'Mistress' ?> </a></li>
                                <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                            onclick="mkwo(<?= $id ?>)">WAEC/Exam Officer</a></li>
                                <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                            onclick="mklib(<?= $id ?>)">Librarian</a></li>
                            </ul>


                        </div>
                    </div>


                </div>

            </div>

        </div>

    </div>


    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <p>Demographic Info.</p>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-2">
                            <img width="190" height="200" class="img-thumbnail"
                                 src="<?= $staff->photo ? $staff->photo : 'img/photo.jpg' ?>">
                        </div>
                        <div class="col-md-10">
                            <table class="table">
                                <tr class="w-100">
                                    <td>
                                        <?= $staff->fname . " " . $staff->lname ?><br>
                                        <small class="text-muted">Name</small>
                                    </td>

                                    <td>
                                        <?= $staff->gender ?><br>
                                        <small class="text-muted">Gender</small>
                                    </td>

                                    <td>
                                        <?= $staff->contact ?><br>
                                        <small class="text-muted">Contact</small>
                                    </td>

                                    <td>
                                        <?= $staff->uname ?><br>
                                        <small class="text-muted">E-Mail/User Name</small>
                                    </td>

                                </tr>

                                <tr class="w-100">
                                    <td>
                                        <?= $staff->pqual ?><br>
                                        <small class="text-muted">Professional Qualification</small>
                                    </td>

                                    <td>
                                        <?= $staff->aqual ?><br>
                                        <small class="text-muted">Academic Qualification</small>
                                    </td>

                                    <td>
                                        <?= \APP\Staff::resolveRank($staff->staff_rank) ?><br>
                                        <small class="text-muted">Rank</small>
                                    </td>

                                    <td>
                                        <?= $staff->stfid ?><br>
                                        <small class="text-muted">Staff Number</small>
                                    </td>
                                </tr>

                                <tr class="w-100">
                                    <td>
                                        <?= $staff->dob ?><br>
                                        <small class="text-muted">Date of Birth</small>
                                    </td>

                                    <td>
                                        <?= $staff->appdate ?><br>
                                        <small class="text-muted">Appointment Date</small>
                                    </td>

                                    <td>
                                        <?= $staff->assdate ?><br>
                                        <small class="text-muted">Assumed duty on</small>
                                    </td>

                                    <td>
                                        <?= $staff->snnid ?><br>
                                        <small class="text-muted">SNNIT Number</small>
                                    </td>
                                </tr>

                                <tr class="w-100">
                                    <td>
                                        <?= $staff->bank ?><br>
                                        <small class="text-muted">Bank Name</small>
                                    </td>

                                    <td>
                                        <?= $staff->accno ?><br>
                                        <small class="text-muted">Bank Account Number</small>
                                    </td>


                                </tr>



                            </table>
                        </div>

                    </div>





                </div>

            </div>

        </div>

    </div>

    <div class="row">
        <div class="col-md-10 mx-auto">

            <div class="card">
                <div class="card-header">
                    <p class="card-title">Classes and Subjects assigned
                        to <?= $staff->fname . " " . $staff->lname ?></p>
                </div>
                <div class="card-body">
                    <?php \APP\Utitlity::showAssignSubjects($id); ?>

                </div>

            </div>

        </div>
    </div>

     <?php
        if (mysqli_num_rows($activities)>0) {
            ?>

            <div class="row">
                <div class="col-md-10 mx-auto">

                    <div class="card">
                        <div class="card-header">
                            <p class="card-title"><?= $staff->fname . " " . $staff->lname ?>'s Activities</p>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="table" class="table table-striped">

                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($action = mysqli_fetch_object($activities)) {
                                    ?>
                                    <tr>
                                        <td><?= $action->datetime_entry ?></td>
                                        <td><?= $action->action ?></td>

                                    </tr>
                                    <?php

                                }
                                ?>
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
            </div>

            <?php
        }
    }else{
       \APP\Utitlity::showError("Staff not found",'Unknown staff','danger');

    }

}else{
    ?>
    <div class="row">
        <div class="col-md-4 mx-auto">
            <?php\APP\Utitlity::showError("Something went wrong, this link is invalid",'invalid link','warning');;?>
        </div>

    </div>
<?php
}

?>