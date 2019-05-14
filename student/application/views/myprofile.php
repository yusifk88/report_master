<div class="row mt-5 pt-5">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-3">
        <div class="card hoverable animated fadeInUp">
            <center><img class="img-responsive img-thumbnail animated fadeInUp"
                         style="margin-top: -70px; width: 150px; height: 150px; border-radius: 50%; box-shadow: 0 0 3px; z-index: 99 !important;"
                         src="<?= str_replace("student/", '', base_url()) ?>admin/<?= $_SESSION['photo'] ?>"></center>
            <div class="card-header bg-white">
                <button onclick="print_profile(<?= $myinfo->stid ?>)" class="btn rgba-cyan-strong pull-right">Print
                </button>
            </div>
            <div class="card-body text-muted ">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <strong>ADMISSION ID:</strong> <?= strtoupper($myinfo->stindex) ?>
                            </div>
                            <div class="list-group-item">
                                <strong>JHS NO:</strong> <?= strtoupper($myinfo->jhsno) ?>
                            </div>
                            <div class="list-group-item">
                                <strong>SHS NO:</strong> <?= strtoupper($myinfo->shsno) ?>
                            </div>
                            <div class="list-group-item">
                                <strong>NAME:</strong> <?= strtoupper($myinfo->fname . " " . $myinfo->lname . " " . $myinfo->oname) ?>
                            </div>
                            <div class="list-group-item">
                                <strong>SEX:</strong> <?= strtoupper($myinfo->gender) ?>
                            </div>
                            <div class="list-group-item">
                                <strong>DATE OF BIRTH:</strong> <?= strtoupper($myinfo->dob) ?>
                            </div>
                            <div class="list-group-item">
                                <strong>LAST BASIC SCHOOL: </strong> <?= strtoupper($myinfo->lschool) ?>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <strong>PROGRAMME:</strong> <?= strtoupper($myinfo->depname) ?>
                            </div>
                            <div class="list-group-item">
                                <strong>CURRENT CLASS:</strong> <?= strtoupper($myinfo->classname) ?>
                            </div>
                            <div class="list-group-item">
                                <strong>CURRENT FORM:</strong> FORM <?= strtoupper($myinfo->form) ?>
                            </div>
                            <div class="list-group-item">
                                <strong>HOUSE:</strong> <?= strtoupper($myinfo->name) ?>(<?= strtoupper($myinfo->des) ?>
                                )
                            </div>
                            <div class="list-group-item">
                                <strong>DATE OF REGISTERATION</strong> <?= strtoupper($myinfo->dor) ?>
                            </div>
                            <div class="list-group-item">
                                <strong>CURRENT ACADEMIC YEAR</strong> <?= strtoupper($myinfo->ayear) ?>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="card ">
                            <div class="card-header text-white rgba-cyan-strong">
                                <h4 class="card-title">Father's info.</h4>
                            </div>
                            <div class="card-body text-muted">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item">
                                        <strong>NAME:</strong> <?= strtoupper($myinfo->ffname) ?>
                                    </div>

                                    <div class="list-group-item">
                                        <strong>HOMETOWN:</strong> <?= strtoupper($myinfo->fhometown) ?>
                                    </div>

                                    <div class="list-group-item">
                                        <strong>PHONE NO:</strong> <?= strtoupper($myinfo->ftel) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="card ">
                            <div class="card-header text-white rgba-indigo-strong">
                                <h4 class="card-title">Mother's info.</h4>
                            </div>
                            <div class="card-body text-muted">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item">
                                        <strong>NAME:</strong> <?= strtoupper($myinfo->mfname) ?>
                                    </div>

                                    <div class="list-group-item">
                                        <strong>HOMETOWN:</strong> <?= strtoupper($myinfo->mhometown) ?>
                                    </div>

                                    <div class="list-group-item">
                                        <strong>PHONE NO:</strong> <?= strtoupper($myinfo->mtel) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert rgba-orange-strong mt-5">

                    <div class="row text-white">
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <i class="fa fa-info-circle fa-5x"></i>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                            <h3>If you realised any error in your details please contact your school admin</h3>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<div class="row mt-5">
    <div class="col-lg-12 col-md-12 ol-sm-12 col-xs-12">
        <div class="card hoverable animated fadeInUp" id="account">
            <div class="card-header bg-white">
                <h5 class="card-title">Account settings</h5>
            </div>
            <div class="card-body">

                <form id="accntfrm">
                    <p class="h4 text-center mb-4 text-muted">Change Password</p>
                    <div class="md-form">
                        <i class="fa fa-user prefix grey-text"></i>
                        <input name="myindex" readonly value="<?= $_SESSION['stindex'] ?>" type="text" id="myindex"
                               class="form-control">
                        <label for="myindex">Admission ID</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-lock prefix grey-text"></i>
                        <input required name="newpass" type="password" id="mypass" class="form-control">
                        <label for="mypass">Password</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-lock prefix grey-text"></i>
                        <input required name="cnewpass" type="password" id="cmypass" class="form-control">
                        <label for="cmypass">Confirm Password</label>
                    </div>

                    <button id="accntbtn" type="submit" class="btn rgba-cyan-strong">Change</button>
                    <span class="pt-2" id="progcont"></span>
                </form>
            </div>
        </div>
    </div>
</div>