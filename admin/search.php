<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;

$cf = new config();
$cf->connect();
$keyword = $_GET['keyword'];
$search = mysqli_query($cf->con, "select stuinfo.ayear,stuinfo.id, stuinfo.photo, stuinfo.fname,stuinfo.lname,stuinfo.oname,stuinfo.form,classes.classname from stuinfo,classes where (fname like '%$keyword%' or lname like '%$keyword%' or oname like '%$keyword%' or ayear like '%$keyword%' or stindex like '%$keyword%') and  (stuinfo.class = classes.id) order by fname ASC LIMIT 0, 100");
$schnum = mysqli_num_rows($search);
?>

<?php

if (($schnum < 1) || !$keyword) {
    ?>
    <span style="color: #FC3; font-style: italic; text-align: center; font-weight: bold;" class="text-center">No records found that matches with the keyword: <?= $keyword; ?></span>

    <?php
} else {
    ?>
    <div class="row" style="margin-bottom: 5px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php
            if ($schnum === 1) {
                ?>

                <span style="color: #FC3 !important; font-weight: bold;" class="pull-left"><?= $schnum ?> Search Result Found</span>

                <?php
            } else {

                ?>
                <span style="color: #FC3 !important; font-weight: bold;" class="pull-left"><?= $schnum ?> Search Results Found</span>

                <?php
            }

            ?>


        </div>


    </div>

    <?php
    while ($row = mysqli_fetch_object($search)) {
        $wtest =  mysqli_fetch_object(mysqli_query($cf->con,"select count(*) as cn from withdraw where stid = '$row->id'"))->cn;
        if($wtest < 1) {
            ?>
            <div class="row result-row ">
                <div class="col-md-12 col-12">
                    <div class="card mb-1 hoverable">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-3">
                                <img class="img-responsive img-fluid"
                                     src="<?= file_exists($row->photo) ? $row->photo : 'objts/dpic/photo.jpg'; ?>"/>
                            </div>
                            <div class=" col-md-7 col-7">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-muted">
                                        <?= $row->fname . " " . $row->lname . " " . $row->oname ?> <br>
                                        <small style="font-size: xx-small;" class="font-small">Name</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-6 text-muted">
                                        <?= $row->classname; ?> <br/>
                                        <small style="font-size: xx-small;">Class</small>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-6 text-muted">

                                        Form <?= $row->form; ?><br>
                                        <small style="font-size: xx-small;">Form</small>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-muted">
                                        <?= $row->ayear; ?> <br/>
                                        <small style="font-size: xx-small;">Year</small>

                                    </div>

                                </div>

                            </div>
                            <div class="col-md-2 col-2">
                                <button data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        id="staction<?= $row->id ?>"
                                        class="btn btn-link text-center text-white align-text-middle  dropdown-toggle"></button>
                                <ul class="dropdown-menu animated zoomIn" aria-labelledby="staction<?= $row->id ?>">
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="upstud(<?= $row->id; ?>)">Edit Info.</a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="printstud(<?= $row->id; ?>)">Print Profile</a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="Comnt(<?= $row->id; ?>)">Add Comment</a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="printrep(<?= $row->id; ?>)">Print Reports</a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="printtransc(<?= $row->id; ?>)">Print Transcript</a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="exiat(<?= $row->id; ?>)">Sign Exeat</a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="resetlogin(<?= $row->id; ?>)">Reset Password</a></li>
                                    <li class="dropdown-item text-danger" style="cursor:pointer;"><a
                                                onclick="withdraw(<?= $row->id; ?>)">Withdraw</a></li>
                                    <li class="dropdown-item text-danger" style="cursor:pointer;"><a
                                                onclick="delstud(<?= $row->id; ?>)">Delete</a></li>
                                </ul>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <?php
        }else{
            ?>
            <div class="row result-row ">
                <div class="col-md-12 col-12">
                    <div class="card mb-2 hoverable border-danger">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-3">
                                <img class="img-responsive img-fluid"
                                     src="<?= file_exists($row->photo) ? $row->photo : 'objts/dpic/photo.jpg'; ?>"/>
                            </div>
                            <div class=" col-md-7 col-sm-7 col-7">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-muted">
                                        <?= $row->fname . " " . $row->lname . " " . $row->oname ?> <br>
                                        <small style="font-size: xx-small;" class="font-small">Name</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-6 text-muted">
                                        <?= $row->classname; ?> <br/>
                                        <small style="font-size: xx-small;">Class</small>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-6 text-muted">

                                        Form <?= $row->form; ?><br>
                                        <small style="font-size: xx-small;">Form</small>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-muted">
                                        <?= $row->ayear; ?> <br/>
                                        <small style="font-size: xx-small;">Year</small>

                                    </div>

                                </div>

                            </div>
                            <div class="col-md-2 col-2">
                                <button data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        id="staction<?= $row->id ?>"
                                        class="btn btn-link bg-info text-center text-info align-text-middle bg-transparent dropdown-toggle"></button>
                                <ul class="dropdown-menu animated zoomIn" aria-labelledby="staction<?= $row->id ?>">
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="upstud(<?= $row->id; ?>)">Edit Info.</a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="printstud(<?= $row->id; ?>)">Print Profile</a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="Comnt(<?= $row->id; ?>)">Add Comment</a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="printrep(<?= $row->id; ?>)">Print Reports</a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="printtransc(<?= $row->id; ?>)">Print Transcript</a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="resetlogin(<?= $row->id; ?>)">Reset Password</a></li>
                                    <li class="dropdown-item text-success" style="cursor:pointer;"><a
                                                onclick="unwithdraw(<?= $row->id; ?>)">Resume</a></li>
                                    <li class="dropdown-item text-danger" style="cursor:pointer;"><a
                                                onclick="delstud(<?= $row->id; ?>)">Delete</a></li>
                                </ul>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <?php
        }
    }
}

?>

