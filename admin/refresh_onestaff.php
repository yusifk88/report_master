<?php
include_once './objts/config.php';
include_once './objts/staff.php';
$cfg = new config();
$cfg->connect();
$stf = new Staff();
$id = $_GET['id'];
$d = mysqli_fetch_object(mysqli_query($cfg->con,"select * from staff where id = '$id'"));
$ranklist = ["Senior Sup't","Prin. Sup't","Assist. Dir ii","Assist. Dir I","Dep. Dir.", "Dir. II","Dir. I"];
        $gender = $d->gender;
        $rank = is_numeric($d->rank)?$d->rank:0;
        $tday = date("Y-M-d");
        $tyear = substr($tday,0,4);
        $svyear = is_null($d->assdate)? substr($tday,0,4) : substr($d->assdate,0,4);;
        $apyear = is_null($d->appdate)? substr($tday,0,4) : substr($d->appdate,0,4);
        $dbyear = is_null($d->dob)? substr($tday,0,4) : substr($d->dob,0,4);
        $dbyear+=60;
        $dur = $tyear-$apyear;
        $years= $tyear-$svyear;
        $fname = $d->fname." ".$d->lname;

            ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card hoverable" style="margin: 0 !important;">
                    <div class="card-body p-0 ">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-sm">
                                <tr>
                                    <th colspan="2"><?= $d->fname." ".$d->lname ?> <br>
                                        <small class="text-muted ">Name</small>

                                    </th>

                                    <th><?php echo $d->gender; ?> <br>
                                        <small class="text-muted">Gender</small>

                                    </th>
                                    <th><?php echo $d->contact; ?> <br>
                                        <small class="text-muted">Contact</small>
                                    </th>
                                    <th><?php echo $d->stfid;?> <br>
                                        <small class="text-muted">Staff ID No.</small>

                                    </th>
                                </tr>
                                <tr>

                                    <th><?=$d->dob; ?> <br>
                                        <small class="text-muted">D .O. B:</small>

                                    </th>
                                    <th><?php echo $d->regno; ?> <br>
                                        <small class="text-muted">Reg. No.:</small>


                                    </th>
                                    <th><?php echo $d->aqual; ?> <br>
                                        <small class="text-muted">Aca. Qualification:</small>

                                    </th>
                                    <th ><?php echo $d->pqual; ?> <br>
                                        <small class="text-muted">Prof. Qualification:</small>
                                    </th>
                                    <th ><?php echo $d->snnid; ?> <br>
                                        <small class="text-muted">SSNIT NO.</small>

                                    </th>
                                </tr>
                                <tr>
                                    <th><?= $ranklist[$rank]; ?> <br>
                                        <small class="text-muted">Rank:</small>

                                    </th>

                                    <th><?php echo $d->appdate; ?> <br>
                                        <small class="text-muted">Date Of First Appointment</small>

                                    </th>
                                    <th><?=$years?> Years<br>
                                        <small class="text-muted">Years At Post:</small>

                                    </th>
                                    <th><?php echo $d->bank; ?> <br>

                                        <small class="text-muted">Associated Bank Name</small>

                                    </th>
                                    <th><?=$d->accno; ?> <br>
                                        <small>Account Number</small>

                                    </th>

                                </tr>
                            </table>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-info <?php echo "sub-inf-".$d->id; ?>" style="display: none;">
                                <?php
                                $id = $d->id;
                                $data = mysqli_query($cfg->con,"select subjects.subjdesc,classes.classname,subas.id from subjects,classes,subas  where subas.stfid ='$id' and subas.clid=classes.id and subjects.id=subas.subid");
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
                                    <tbody id="sub-body<?=$id?>">
                                    <?php
                                    while ($d = mysqli_fetch_assoc($data)) {
                                        ?>
                                        <tr id="sub_<?=$d['id']?>">

                                            <td>
                                                <?php
                                                echo $d['subjdesc'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $d['classname'];
                                                ?>
                                            </td>

                                            <td><i class="fa fa-chain-broken rmsub btn btn-danger btn-sm" title="Unasign this subject" data-del="delsubj.php" onclick="rmsub(<?=$id?>,<?=$d['id']?>)"  style="color: #F00; cursor: pointer;"></i></td>

                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                </table></div>
                        </div>

                    </div>

                    <div class="card-footer p-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <i title="Edit this staff's info" onclick="upstaff(<?=$id?>)" data-id="<?php echo $id;?>" class="fa fa-edit waves-effect waves-circle editicon4" style="color: deepskyblue; cursor: pointer;"></i>
                                <i title="Print staff profile" onclick="printstf(<?=$id?>)" class="fa fa-print waves-effect waves-circle " style="color: deepskyblue; cursor: pointer;"></i>
                                <i class="fa fa-book waves-effect waves-circle asub" onclick="asub(<?=$id?>)" title="Assign subjects to this staff" style="color: deepskyblue; cursor: pointer;"><sup><i class="fa fa-plus"></i></sup></i>
                                <i id="exduties" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: deepskyblue; cursor: pointer;" data-toggle="tooltip" class="fa fa-plus-square waves-effect waves-circle dropdown-toggle" title="Assing some extra duties to this staff"></i>
                                <ul class="dropdown-menu animated fadeInUp" aria-labelledby="exduties" >
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a onclick="mkform(<?=$id;?>)">Form <?=$gender=='Male'?'Master':'Mistress'?></a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a onclick="housem(<?=$id?>); return false;">House <?=($gender=='Male')? 'Master': 'Mistress'?></a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a onclick="addshm(<?=$id?>)">Senior House <?=($gender=='Male')? 'Master': 'Mistress'?> </a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a onclick="mkwo(<?=$id?>)">WAEC/Exam Officer</a></li>
                                    <li class="dropdown-item text-muted" style="cursor:pointer;"><a onclick="mklib(<?=$id?>)">Librarian</a></li>
                                </ul>
                                <i class="fa fa-repeat waves-effect waves-circle" title="Reset Password" onclick="respass(<?=$id?>,'<?=$fname?>')" style="color:red; cursor: pointer;"></i>
                                <i class="fa fa-remove waves-effect waves-circle" title="Delete this staff" onclick="delstaff(<?=$id?>)" style="color:red; cursor: pointer;"></i>
                                <i data-show="<?php echo (".sub-inf-".$id); ?>" onclick="show_sub(<?=$id?>)" class="fa fa-caret-down waves-effect waves-circle pull-right sub-show" title="View details about this staff" style="color: deepskyblue; cursor: pointer; font-size: 18px;"></i>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


