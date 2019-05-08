<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$id = $_GET['id'];
$stud = mysqli_query($cf->con,"select stuinfo.id,fname,oname,lname,stindex,form,classes.classname,dept.depname,dob,dor,ffname,fhometown,ftel,gender,ayear,houses.des,houses.name,lschool,mfname,mhometown,mtel,photo,(SELECT name from houses where id = stuinfo.ghouse) as ghouse from stuinfo,classes,dept,houses where stuinfo.class = classes.id and stuinfo.dept = dept.id and stuinfo.house = houses.id and stuinfo.id = '$id' ");
while ($row = mysqli_fetch_object($stud)) {

$id = $row->id;
$wtest=mysqli_query($cf->con,"select * from withdraw WHERE stid = '$id'");
if(mysqli_num_rows($wtest)<1) {
?>

    <div class="panel panel-default" style="margin:0 !important; margin-bottom: 2px !important; border-radius: 0 !important;">
        <div class="panel-body alert-success" style="padding: 0 !important; margin: 0 !important;">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3" style="margin: 0 !important;  text-align: center !important; padding-right: 0 !important; " id="imgcont_<?=$row->stindex?>">
                    <img style="max-height: 170px; border-radius: 0 !important; " alt="<?= $row->fname?>"
                         src="../admin/<?=$row->photo ?>" class="img-thumbnail img-responsive"/>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-9"
                     style="margin: 0 !important; padding-left: 0 !important;">
                    <div class="table-responsive" style="margin: 0 !important; padding: 0 !important;">


                        <table class="table table-striped table-condensed"
                               style="padding: 0 !important; margin: 0 !important;">
                            <tr>
                                <th style="text-align: right;">ID:</th>
                                <td><?php echo $row->stindex; ?></td>

                                <th style="text-align: right;">Name:</th>
                                <td colspan='3'>
                                    <?php echo $row->fname . ' ' . $row->lname . ' ' . $row->oname; ?>

                                </td>
                                <th style="text-align: right;">Gender:</th>
                                <td>
                                <?= $row->gender; ?>
                            </tr>
                            <tr>
                                <th style="text-align: right;">D.O.B:</th>
                                <td>
                                    <?php echo $row->dob; ?>
                                </td>
                                <th style="text-align: right;">Form:</th>
                                <td>
                                    <?php echo "Form " . $row->form; ?>

                                </td>
                                <th style="text-align: right;">Program:</th>
                                <td>
                                    <?= $row->depname ?>
                                </td>
                                <th style="text-align: right;">Class</th>
                                <td>
                                    <?= $row->classname; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: right;">House:</th>
                                <td><?php echo $row->name; ?></td>
                                <th style="text-align: right;">Last Sch.:</th>
                                <td><?php echo $row->lschool; ?> </td>
                                <th style="text-align: right;">Reg. Date:</th>
                                <td><?php echo $row->dor; ?></td>
                                <th>Gender House</th>
                                <td><?=$row->ghouse? $row->ghouse:'None';?></td>
                            </tr>
                            <tr>
                                <th style="text-align: right;">Father's Name:</th>
                                <td colspan='3'>
                                    <?=$row->ffname; ?>
                                </td>
                                <th style="text-align: right;">Father's Hometown:</th>
                                <td>
                                    <?= $row->fhometown; ?>
                                </td>
                                <th style="text-align: right;">Father's Tel.:</th>
                                <td>
                                    <?=$row->ftel; ?>

                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: right;">Mother's Name:</th>
                                <td colspan='3'>
                                    <?=$row->mfname; ?>
                                </td>
                                <th style="text-align: right;">Mother's Hometown:</th>
                                <td>
                                    <?=$row->mhometown; ?>


                                </td>
                                <th style="text-align: right;">Mother's Tel.:</th>
                                <td>
                                    <?=$row->mtel; ?>

                                </td>
                            </tr>
                        </table>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer hidden-print"
             style=" padding: 0 !important; margin-top: 0!important; height: 2em !important;  padding-left: 10px !important;">
            <i onclick="upstud(<?= $row->id; ?>, '<?='row_'.$row->id?>')" title="Edit this student's info." data-toggle='tooltip'
               id="edstud"
               style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
               class="fa fa-edit waves-effect waves-circle btn btn-link"></i>
            <i onclick="printstud(<?=$row->id; ?>)" data-id="<?= $row->id; ?>"
               title="Print this student's profile" data-toggle='tooltip' id="printstud"
               style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
               class="fa fa-print waves-effect waves-circle btn btn-link"></i>
            <i onclick="Comnt(<?= $row->id; ?>)" data-id="<?=$row->id; ?>"
               title="Add extra info. to this studen's profile eg. suspension" data-toggle='tooltip'
               id="printstud"
               style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
               class="fa fa-comment waves-effect waves-circle btn btn-link"></i>


            <i onclick="printrep(<?= $row->id; ?>)" data-id="<?=$row->id; ?>"
               title="Print termnal report" data-toggle='tooltip'
               id="printrep"
               style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
               class="fa fa-bar-chart-o waves-effect waves-circle btn btn-link"></i>
            <i onclick="printtransc(<?=$row->id; ?>)" data-id="<?=$row->id; ?>"
               title="Print Transcript" data-toggle='tooltip'
               id="printstud"
               style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
               class="fa fa-line-chart waves-effect waves-circle btn btn-link"></i>


            <i onclick="withdraw(<?= $row->id; ?>)" data-id="<?=$row->id; ?>"
               title="Withdraw this student from the school" data-toggle='tooltip'
               style="font-weight: bold; color: red; cursor: pointer; margin: 0 !important; padding: 0 !important;"
               class="fa fa-undo waves-circle waves-effect btn btn-link"></i>

            <i onclick="delstud('<?=$row->id; ?>')" data-stid="<?=$row->id; ?>"
               title="Delete this student" data-toggle='tooltip' id="delstud"
               style="color: red; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
               class="fa fa-remove btn waves-effect waves-circle btn-link"></i>
        </div>
    </div>




<?php
}else{

    ?>

        <div class="panel panel-default"
             style="margin:0 !important; margin-bottom: 2px !important; border-radius: 0 !important;">
            <div class="panel-body" style="padding: 0 !important; margin: 0 !important;">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"
                         style="margin: 0 !important;  text-align: center !important; padding-right: 0 !important; ">
                        <img style="max-height: 170px; border-radius: 0 !important; " alt="<?= $row->fname; ?>"
                             src="<?= $row->photo ?>" class="img-thumbnail img-responsive"/>

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-9"
                         style="margin: 0 !important; padding-left: 0 !important;">
                        <div class="table-responsive text-danger" style="margin: 0 !important; padding: 0 !important;">
                            <table class="table table-striped table-bordered table-condensed"
                                   style="padding: 0 !important; margin: 0 !important;">
                                <tr>

                                    <th style="text-align: right;">ID:</th>
                                    <td><?=$row->stindex; ?></td>

                                    <th style="text-align: right;">Name:</th>
                                    <td colspan='3'>
                                        <?= $row->fname . ' ' . $row->lname . ' ' . $row->oname; ?>

                                    </td>


                                    <th style="text-align: right;">Gender:</th>
                                    <td>
                                        <?= $row->gender; ?>
                                </tr>
                                <tr>


                                    <th style="text-align: right;">D.O.B:</th>
                                    <td>
                                        <?= $row->dob; ?>
                                    </td>
                                    <th style="text-align: right;">Form:</th>
                                    <td>
                                        <?= "Form " . $row->form; ?>

                                    </td>

                                    <th style="text-align: right;">Program:</th>
                                    <td>
                                        <?= $row->depname ?>


                                    </td>
                                    <th style="text-align: right;">Class</th>
                                    <td>


                                        <?= $row->classname; ?>


                                        </select>

                                    </td>

                                </tr>

                                <tr>
                                    <th style="text-align: right;">House:</th>
                                    <td colspan='2'><?= $row->name; ?></td>
                                    <th style="text-align: right;">Last Sch.:</th>
                                    <td colspan='2'><?=$row->lschool; ?> </td>
                                    <th style="text-align: right;">Reg. Date:</th>
                                    <td><?=$row->dor; ?></td>
                                </tr>

                                <tr>
                                    <th style="text-align: right;">Father's Name:</th>
                                    <td colspan='3'>
                                        <?=$row->ffname; ?>
                                    </td>
                                    <th style="text-align: right;">Father's Hometown:</th>
                                    <td>
                                        <?=$row->fhometown; ?>
                                    </td>
                                    <th style="text-align: right;">Father's Tel.:</th>
                                    <td>
                                        <?=$row->ftel; ?>

                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: right;">Mother's Name:</th>
                                    <td colspan='3'>
                                        <?=$row->mfname; ?>
                                    </td>
                                    <th style="text-align: right;">Mother's Hometown:</th>
                                    <td>
                                        <?=$row->mhometown; ?>


                                    </td>
                                    <th style="text-align: right;">Mother's Tel.:</th>
                                    <td>
                                        <?=$row->mtel; ?>

                                    </td>
                                </tr>
                            </table>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer"
                 style=" padding: 0 !important; margin-top: 0!important; height: 2em !important;  padding-left: 10px !important;">
                <i onclick="upstud(<?= $row->id; ?>)" title="Edit this student's info." data-toggle='tooltip'
                   id="edstud"
                   style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                   class="fa fa-edit  waves-effect waves-circle btn btn-link"></i>
                <i onclick="printstud(<?= $row->id; ?>)" data-id="<?=$row->id; ?>"
                   title="Print this student's profile" data-toggle='tooltip' id="printstud"
                   style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                   class="fa fa-print waves-effect waves-circle btn btn-link"></i>
                <i onclick="Comnt(<?=$row->id; ?>)" data-id="<?=$row->id; ?>"
                   title="Add extra info. to this studen's profile eg. suspension" data-toggle='tooltip'
                   id="printstud"
                   style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                   class="fa fa-comment waves-effect waves-circle btn btn-link"></i>


                <i onclick="printrep(<?=$row->id; ?>)" data-id="<?=$row->id; ?>"
                   title="Print termnal report" data-toggle='tooltip'
                   id="printstud"
                   style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                   class="fa fa-bar-chart-o waves-effect waves-circle btn btn-link"></i>

                <i onclick="printtransc(<?= $row->id; ?>)" data-id="<?=$row->id; ?>"
                   title="Print Transcript" data-toggle='tooltip'
                   id="printstud"
                   style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                   class="fa fa-line-chart waves-effect waves-circle btn btn-link"></i>



                <i onclick="unwithdraw(<?= $row->id; ?>)" data-id="<?=$row->id; ?>"
                   title="Resume this student back to the school" data-toggle='tooltip'
                   style="font-weight: bold; color: deepskyblue; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                   class="fa fa-plus-square waves-effect waves-circle btn btn-link"></i>

                <i onclick="delstud('<?=$row->id; ?>')" data-stid="<?=$row->id; ?>"
                   title="Delete this student" data-toggle='tooltip' id="delstud"
                   style="color: red; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                   class="fa fa-remove waves-effect waves-circle btn btn-link"></i>
            </div>
        </div>
    <?php
}
}
