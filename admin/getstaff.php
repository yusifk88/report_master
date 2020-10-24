<?php
include_once './objts/config.php';
include_once './objts/staff.php';
$cfg = new config();
$cfg->connect();
$stf = new Staff();
$keyword = $_GET['search'];
$d = $stf->getstaff($keyword, $keyword);
$ranklist = ["Senior Sup't", "Prin. Sup't", "Assist. Dir ii", "Assist. Dir I", "Dep. Dir.", "Dir. II", "Dir. I"];
?>
<div class="card">
    <div class="card-header bg-primary2 text-white">
        STAFF LIST
        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
           class="btn bg-warning mr-auto btn-sm text-white">
            <i class="fa fa-print text-white"> </i> Print Staff List <i class="fa fa-caret-down"></i> </a>
        <ul class="dropdown-menu animated zoomIn" aria-labelledby="exduties">
            <li class="dropdown-item text-muted" style="cursor:pointer;"><a onclick="print_staff();return false;">Print
                    All Staff</a></li>
            <li class="dropdown-item text-muted" style="cursor:pointer;"><a onclick="hmasters(); return false;">House
                    Masters/Mistresses</a></li>
            <li class="dropdown-item text-muted" style="cursor:pointer;"><a onclick="fmasters()">Form
                    Masters/Mistresses </a></li>
            <li class="dropdown-item text-muted" style="cursor:pointer;"><a onclick="substf()">Subject Teachers</a></li>
        </ul>
    </div>
</div>
<?php
if (mysqli_num_rows($d) > 0) {
    while ($row = mysqli_fetch_assoc($d)) {
        $gender = $row['gender'];
        $rank = is_numeric($row['rank']) ? $row['rank'] : 0;
        $thay = date("Y-M-d");
        $tyear = substr($thay, 0, 4);
        $svyear = is_null($row['assdate']) ? substr($thay, 0, 4) : substr($row['assdate'], 0, 4);;
        $apyear = is_null($row['appdate']) ? substr($thay, 0, 4) : substr($row['appdate'], 0, 4);
        $dbyear = is_null($row['dob']) ? substr($thay, 0, 4) : substr($row['dob'], 0, 4);
        $dbyear += 60;
        $dur = $tyear - $apyear;
        $years = $tyear - $svyear;
        $fname = $row['fname'] . " " . $row['lname'];
        ?>
        <div id="row_<?= $row['id'] ?>" class="row mb-1">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card hoverable" style="margin: 0 !important;">
                    <div class="card-body p-0 ">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-condensed table-hover table-sm">
                                <tr>
                                    <th colspan="2"><?= $row['fname'] . " " . $row['lname'] ?> <br>
                                        <small class="text-muted ">Name</small>
                                    </th>
                                    <th><?php echo $row['gender']; ?> <br>
                                        <small class="text-muted">Gender</small>
                                    </th>
                                    <th><?php echo $row['contact']; ?> <br>
                                        <small class="text-muted">Contact</small>
                                    </th>
                                    <th><?php echo $row['stfid']; ?> <br>
                                        <small class="text-muted">Staff ID No.</small>

                                    </th>
                                </tr>
                                <tr>
                                    <th><?php echo $row['dob']; ?> <br>
                                        <small class="text-muted">D .O. B:</small>
                                    </th>
                                    <th><?php echo $row['regno']; ?> <br>
                                        <small class="text-muted">Reg. No.:</small>
                                    </th>
                                    <th><?php echo $row['aqual']; ?> <br>
                                        <small class="text-muted">Aca. Qualification:</small>
                                    </th>
                                    <th><?php echo $row['pqual']; ?> <br>
                                        <small class="text-muted">Prof. Qualification:</small>
                                    </th>
                                    <th><?php echo $row['snnid']; ?> <br>
                                        <small class="text-muted">SSNIT NO.</small>

                                    </th>
                                </tr>
                                <tr>
                                    <th><?= $ranklist[$rank]; ?> <br>
                                        <small class="text-muted">Rank:</small>
                                    </th>
                                    <th><?php echo $row['appdate']; ?> <br>
                                        <small class="text-muted">Date Of First Appointment</small>
                                    </th>
                                    <th><?= $years ?> Years<br>
                                        <small class="text-muted">Years At Post:</small>
                                    </th>
                                    <th><?php echo $row['bank']; ?> <br>

                                        <small class="text-muted">Associated Bank Name</small>
                                    </th>
                                    <th><?= $row['accno']; ?> <br>
                                        <small>Account Number</small>
                                    </th>
                                </tr>
                            </table>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-info <?php echo "sub-inf-" . $row['id']; ?>"
                                 style="display: none;">
                                <?php
                                $id = $row['id'];
                                $data = mysqli_query($cfg->con, "select subjects.subjdesc,classes.classname,subas.id from subjects,classes,subas  where subas.stfid ='$id' and subas.clid=classes.id and subjects.id=subas.subid");
                                ?>
                                <div class="alert alert-info">Subject/Classes Taught</div>
                                <table class="table table-condensed table-hover table-striped table-sm">
                                    <thead>
                                    <tr>

                                        <th>Subject</th>
                                        <th>Class</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody id="sub-body<?= $id ?>">
                                    <?php
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        ?>
                                        <tr id="sub_<?= $row['id'] ?>">

                                            <td>
                                                <?php
                                                echo $row['subjdesc'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $row['classname'];
                                                ?>
                                            </td>

                                            <td><i class="fa fa-chain-broken rmsub btn btn-danger btn-sm"
                                                   title="Unasign this subject" data-del="delsubj.php"
                                                   onclick="rmsub(<?= $id ?>,<?= $row['id'] ?>)"
                                                   style="color: #F00; cursor: pointer;"></i></td>

                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>

                                </table>
                            </div>


                        </div>

                    </div>

                    <div class="card-footer p-0 bg-white">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <i title="Edit this staff's info" onclick="upstaff(<?= $id ?>)"
                                   data-id="<?php echo $id; ?>" class="fa fa-edit waves-effect waves-circle editicon4"
                                   style="color: deepskyblue; cursor: pointer;"></i>
                                <i title="Print staff profile" onclick="printstf(<?= $id ?>)"
                                   class="fa fa-print waves-effect waves-circle "
                                   style="color: deepskyblue; cursor: pointer;"></i>
                                <i class="fa fa-book waves-effect waves-circle asub" onclick="asub(<?= $id ?>)"
                                   title="Assign subjects to this staff"
                                   style="color: deepskyblue; cursor: pointer;"><sup><i
                                                class="fa fa-plus"></i></sup></i>
                                <i id="exduties" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                   style="color: deepskyblue; cursor: pointer;" data-toggle="tooltip"
                                   class="fa fa-plus-square waves-effect waves-circle dropdown-toggle"
                                   title="Assign some extra duties to this staff"></i>
                                <ul class="dropdown-menu animated zoomIn" aria-labelledby="exduties">
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="mkform(<?= $id; ?>)">Form <?= $gender == 'Male' ? 'Master' : 'Mistress' ?></a>
                                    </li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="housem(<?= $id ?>); return false;">House <?= ($gender == 'Male') ? 'Master' : 'Mistress' ?></a>
                                    </li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="addshm(<?= $id ?>)">Senior
                                            House <?= ($gender == 'Male') ? 'Master' : 'Mistress' ?> </a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="mkwo(<?= $id ?>)">WAEC/Exam Officer</a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a
                                                onclick="mklib(<?= $id ?>)">Librarian</a></li>
                                </ul>
                                <i class="fa fa-repeat waves-effect waves-circle text-info" title="Reset Password"
                                   onclick="respass(<?= $id ?>,'<?= $fname ?>')"></i>
                                <i class="fa fa-remove waves-effect waves-circle" title="Delete this staff"
                                   onclick="delstaff(<?= $id ?>)" style="color:red; cursor: pointer;"></i>

                                <i data-show="<?= (".sub-inf-" . $id); ?>" onclick="show_sub(<?= $id ?>)"
                                   class="fa fa-caret-down waves-effect waves-circle pull-right sub-show"
                                   title="View details about this staff"
                                   style="color: deepskyblue; cursor: pointer; font-size: 18px;"></i>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <?php
    }
} else {

    ?>

    <p><h1 class="text-muted" style="text-align: center; margin-top: 5em;">No staff registered at the moment <span
                class="glyphicon glyphicon-warning-sign"></span></h1></p>


    <?php

}

?>

<script>

    $("span,i").tooltip();


</script>
