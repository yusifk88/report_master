<?php


require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');

$cfg = new \APP\config();
$cfg->connect();
$stf = new \APP\Staff();
$d = $stf->getstaff();
$ranklist = ["Senior Sup't", "Prin. Sup't", "Assist. Dir ii", "Assist. Dir I", "Dep. Dir.", "Dir. II", "Dir. I"];
?>
<div class="card">
    <div class="card-header bg-primary2 text-white">
        STAFF LIST
        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
           class="btn bg-warning mr-auto btn-sm text-white">
            <i class="fa fa-print text-white"> </i> Print Staff List <i class="fa fa-caret-down"></i> </a>
        <ul class="dropdown-menu" aria-labelledby="exduties">
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

        <div id="row_<?= $row['id'] ?>" class="row mb-1">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card hoverable" style="margin: 0 !important;">
                        <div class="table-responsive text-nowrap card-body">
                            <table id="table" class="table table-condensed table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Contact</th>
                                        <th>Staff ID</th>
                                        <th>SSNIT No.</th>
                                        <th>Date of appointment</th>
                                    </tr>
                                </thead>
                                <tbody>

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
                                    <tr>
                                        <td>
                                            <a href="#/viewstaff?id=<?=$row['id']?>">
                                                <?= $row['fname'] . " " . $row['lname'] ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $row['gender']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['contact']; ?>
                                        </td>
                                        <td><?php echo $row['stfid']; ?>

                                        </td>

                                        <td>
                                            <?php echo $row['snnid']; ?>

                                        </td>
                                        <td>
                                            <?php echo $row['appdate']; ?>
                                        </td>

                                    </tr>
                                    <?php
                                }}
                                ?>
                                </tbody>

                            </table>



                            <?php
                            $id = $row['id'];
                            $data = mysqli_query($cfg->con, "select subjects.subjdesc,classes.classname,subas.id from subjects,classes,subas  where subas.stfid ='$id' and subas.clid=classes.id and subjects.id=subas.subid");
                            $show_carret=false;

                            if (mysqli_num_rows($data)>0){
                                $show_carret=true;

                                ?>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-info <?php echo "sub-inf-" . $row['id']; ?>"
                                 style="display: none;">

                                <div class="alert alert-primary">Asigned Subject/Classes</div>
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

                            <?php
                            }
                            ?>
                    </div>


                </div>

            </div>
        </div>


