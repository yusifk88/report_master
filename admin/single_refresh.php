<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;

$cf = new config();
$cf->connect();
$id = $_GET['id'];
$stud = mysqli_query($cf->con, "select stuinfo.id,fname,oname,lname,stindex,form,classes.classname,dept.depname,dob,dor,ffname,fhometown,ftel,gender,ayear,houses.des,houses.name,lschool,mfname,mhometown,mtel,photo,res_status,(SELECT name from houses where id = stuinfo.ghouse) as ghouse from stuinfo,classes,dept,houses where stuinfo.class = classes.id and stuinfo.dept = dept.id and stuinfo.house = houses.id and stuinfo.id = '$id' ");
while ($row = mysqli_fetch_object($stud)) {

    $id = $row->id;
    $wtest = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from withdraw WHERE stid = '$id'"))->cn;
    ?>

    <div class="card <?= ($wtest < 0) ? 'border-success' : 'border-danger'?> ">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-2" id="imgcont_<?= $row->stindex ?>">
                <img alt="<?= $row->fname ?>"
                     src='<?= file_exists($row->photo) ? $row->photo : 'objts/dpic/photo.jpg' ?>'
                     class="img-thumbnail img-fluid img-responsive st-photos"/>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-10"
                 style="margin: 0 !important; padding-left: 0 !important;">
                <div class="table-responsive text-nowrap">
                    <table class="table table-sm"
                           style="padding: 0 !important; margin: 0 !important;">
                        <tr>
                            <th class="th-sm"><?php echo $row->stindex; ?><br>
                                <small class="text-muted">ID</small>
                            </th>

                            <th class="th-sm">
                                <?= $row->fname . ' ' . $row->lname . ' ' . $row->oname; ?> <br>
                                <small class="text-muted">Name</small>
                            </th>
                            <th class="th-sm">
                                <?php
                                if ($row->res_status == 'Boarding Student') {
                                    ?>
                                    <span class=" text-white bg-success p-2">Boarding Student</span>

                                    <?php
                                } elseif ($row->res_status == 'Day Student') {

                                    ?>
                                    <span class="text-white p-2 bg-warning">Day Student</span>

                                    <?php
                                }


                                ?>

                            </th>
                            <th class="th-sm">
                                <?= $row->gender; ?> <br>
                                <small class="text-muted">Gender</small>
                            </th>
                            <th class="th-sm">
                                <?php echo $row->dob; ?> <br>
                                <small class="text-muted">D.O.B</small>
                            </th>
                            <th class="th-sm">
                                <?php echo "Form " . $row->form; ?> <br>
                                <small class="text-muted">Form</small>
                            </th>

                        </tr>
                        <tr>
                            <th class="th-sm"><?= $row->name; ?> <br>
                                <small class="text-muted">House</small>
                            </th>
                            <th class="th-sm"><?= $row->lschool; ?> <br>
                                <small class="text-muted">Last Sch.</small>
                            </th>
                            <th class="th-sm"><?= $row->dor; ?><br>
                                <small class="text-muted">Reg Date</small>
                            </th>
                            <th class="th-sm"><?= $row->ghouse ? $row->ghouse : 'None'; ?><br>
                                <small class="text-muted">Gender House/Hall</small>
                            </th>
                            <th class="th-sm">
                                <?= $row->classname; ?> <br>
                                <small class="text-muted">Class</small>
                            </th>
                            <th class="th-sm">
                                <?= $row->depname ?> <br>
                                <small class="text-muted">Program</small>
                            </th>

                        </tr>
                        <tr>
                            <td>
                                <?php echo $row->ffname; ?> <br>
                                <small class="text-muted">Father's Name</small>
                            </td>
                            <td>
                                <?php echo $row->fhometown; ?> <br>
                                <small class="text-muted">Father's Hometown</small>
                            </td>

                            <td>
                                <?php echo $row->ftel; ?> <br>
                                <small class="text-muted">Father's Tel</small>
                            </td>

                            <td>
                                <?php echo $row->mfname; ?> <br>
                                <small class="text-muted">Mother's Name</small>
                            </td>
                            <td>
                                <?php echo $row->mhometown; ?> <br>
                                <small class="text-muted">Mother's Hometown</small>
                            </td>
                            <td>
                                <?php echo $row->mtel; ?> <br>
                                <small class="text-muted">Motyher's Tel</small>
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-footer  p-0 bg-white">
            <i onclick="upstud(<?= $row->id; ?>, '<?= 'row_' . $row->id ?>')" title="Edit this student's info."
               data-toggle='tooltip'
               id="edstud"
               style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
               class="fa fa-edit waves-effect waves-circle btn btn-link text-muted"></i>
            <i onclick="printstud(<?= $row->id; ?>)" data-id="<?= $row->id; ?>"
               title="Print this student's profile" data-toggle='tooltip' id="printstud"
               style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
               class="fa fa-print waves-effect waves-circle btn btn-link"></i>
            <i onclick="Comnt(<?= $row->id; ?>)" data-id="<?= $row->id; ?>"
               title="Add extra info. to this studen's profile eg. suspension" data-toggle='tooltip'
               id="printstud"
               style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
               class="fa fa-comment-o waves-effect waves-circle btn btn-link"></i>

            <i onclick="printrep(<?= $row->id; ?>)" data-id="<?php echo $row->id; ?>"
               title="Print termnal report" data-toggle='tooltip'
               id="printrep"
               style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
               class="fa fa-bar-chart-o waves-effect waves-circle btn btn-link"></i>
            <i onclick="printtransc(<?= $row->id; ?>)" data-id="<?= $row->id; ?>"
               title="Print Transcript" data-toggle='tooltip'
               id="printstud"
               style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
               class="fa fa-line-chart waves-effect waves-circle btn btn-link"></i>

            <i onclick="resetlogin('<?= $row->stindex; ?>')"
               title="Reset this student's login account" data-toggle='tooltip'
               id="printstud"
               style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
               class="fa fa-retweet waves-effect waves-circle btn btn-link"></i>
            <?php
            if ($wtest > 0) {
                ?>
                <i onclick="unwithdraw(<?= $row->id; ?>)" data-id="<?=$row->id; ?>"
                   title="Resume this student back into the school" data-toggle='tooltip'
                   style="font-weight: bold; color: red; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                   class="fa fa-arrow-circle-o-right waves-circle waves-effect btn btn-link"></i>

                <?php
            } else {
                ?>
                <i onclick="withdraw(<?= $row->id?>)" data-id="<?=$row->id?>"
                   title="Withdraw this student from the school" data-toggle='tooltip'
                   style="font-weight: bold; color: red; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                   class="fa fa-undo waves-circle waves-effect btn btn-link"></i>
                <i onclick="exiat(<?= $row->id; ?>)" data-stid="<?=$row->id?>"
                   title="Sign a permission for this student. eg. Exiat" data-toggle='tooltip' id="delstud"
                   style="font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                   class="fa fa-id-card-o btn waves-effect waves-circle btn-link"></i>

                <?php

            }


            ?>


            <i onclick="delstud('<?php echo $row->id; ?>')" data-stid="<?php echo $row->id; ?>"
               title="Delete this student" data-toggle='tooltip' id="delstud"
               style="font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
               class="fa fa-remove btn waves-effect waves-circle btn-link text-danger"></i>


        </div>
    </div>


    <?php


}
