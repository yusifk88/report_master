<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$id = $_GET['id'];
$studs = mysqli_query($cf->con,"select stuinfo.id,fname,oname,lname,stindex,form,classes.classname,dept.depname,dob,dor,ffname,fhometown,ftel,gender,ayear,houses.des,houses.name,lschool,mfname,mhometown,mtel,photo,res_status from stuinfo,classes,dept,houses where stuinfo.class = classes.id and stuinfo.dept = dept.id and stuinfo.house = houses.id and stuinfo.id = '$id' ");
while ($row = mysqli_fetch_assoc($studs)) {
$id = $row['id'];
$wtest=mysqli_query($cf->con,"select * from withdraw WHERE stid = '$id'");
if(mysqli_num_rows($wtest)<1) {

    ?>

    <div id="row_<?=$id?>"  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 !important;">
        <div class="panel panel-default"
             style="margin:0 !important; margin-bottom: 2px !important; border-radius: 0 !important;">
            <div class="panel-body" style="padding: 0 !important; margin: 0 !important;">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"
                         style="margin: 0 !important;  text-align: center !important; padding-right: 0 !important; ">


                        <img style="max-height: 170px; border-radius: 0 !important; " alt="<?php echo $row['fname']; ?>"
                             src="<?php echo $row['photo'] ?>" class="img-thumbnail img-responsive"/>

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-9"
                         style="margin: 0 !important; padding-left: 0 !important;">

                        <div class="table-responsive" style="margin: 0 !important; padding: 0 !important;">


                            <table class="table table-condensed"
                                   style="padding: 0 !important; margin: 0 !important;">
                                <tr>

                                    <th style="text-align: right;">ID:</th>
                                    <td><?php echo $row['stindex']; ?></td>

                                    <th style="text-align: right;">Name:</th>
                                    <td colspan='2'>
                                        <?php echo $row['fname'] . ' ' . $row['lname'] . ' ' . $row['oname']; ?>

                                    </td>
                                    <td>
                                        <?php
                                        if($row['res_status'] == 'Boarding Student'){
                                            ?>
                                            <span class="label label-success">Boarding Student</span>

                                            <?php
                                        }elseif($row['res_status'] == 'Day Student'){

                                            ?>
                                            <span class="label label-warning">Day Student</span>

                                            <?php
                                        }


                                        ?>

                                    </td>

                                    <th style="text-align: right;">Gender:</th>
                                    <td>
                                        <?= $row['gender']; ?>
                                </tr>
                                <tr>


                                    <th style="text-align: right;">D.O.B:</th>
                                    <td>
                                        <?php echo $row['dob']; ?>
                                    </td>
                                    <th style="text-align: right;">Form:</th>
                                    <td>
                                        <?php echo "Form " . $row['form']; ?>

                                    </td>

                                    <th style="text-align: right;">Program:</th>
                                    <td>
                                        <?= $row["depname"] ?>


                                    </td>
                                    <th style="text-align: right;">Class</th>
                                    <td>


                                        <?= $row["classname"]; ?>


                                        </select>

                                    </td>

                                </tr>

                                <tr>
                                    <th style="text-align: right;">House:</th>
                                    <td colspan='2'><?php echo $row['name']; ?></td>
                                    <th style="text-align: right;">Last Sch.:</th>
                                    <td colspan='2'><?php echo $row['lschool']; ?> </td>
                                    <th style="text-align: right;">Reg. Date:</th>
                                    <td><?php echo $row['dor']; ?></td>
                                </tr>

                                <tr>
                                    <th style="text-align: right;">Father's Name:</th>
                                    <td colspan='3'>
                                        <?php echo $row['ffname']; ?>
                                    </td>
                                    <th style="text-align: right;">Father's Hometown:</th>
                                    <td>
                                        <?php echo $row['fhometown']; ?>
                                    </td>
                                    <th style="text-align: right;">Father's Tel.:</th>
                                    <td>
                                        <?php echo $row['ftel']; ?>

                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: right;">Mother's Name:</th>
                                    <td colspan='3'>
                                        <?php echo $row['mfname']; ?>
                                    </td>
                                    <th style="text-align: right;">Mother's Hometown:</th>
                                    <td>
                                        <?php echo $row['mhometown']; ?>


                                    </td>
                                    <th style="text-align: right;">Mother's Tel.:</th>
                                    <td>
                                        <?php echo $row['mtel']; ?>

                                    </td>
                                </tr>
                            </table>
                            </form>

                        </div>
                    </div>
                </div>

                <i onclick="upstud(<?= $row['id']; ?>)" title="Edit this student's info." data-toggle='tooltip'
                      id="edstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-edit waves-effect waves-circle btn btn-link"></i> 
                <i onclick="printstud(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print this student's profile" data-toggle='tooltip' id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-print waves-effect waves-circle btn btn-link"></i>
                <i onclick="Comnt(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Add extra info. to this studen's profile eg. suspension" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-comment waves-effect waves-circle btn btn-link"></i>
                      <i onclick="printrep(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print termnal report" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-bar-chart-o waves-effect waves-circle btn btn-link"></i> 
                      <i onclick="printtransc(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print Transcript" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-line-chart waves-effect waves-circle btn btn-link"></i> 
					  

                <i onclick="withdraw(<?= $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Withdraw this student from the school" data-toggle='tooltip'
                      style="font-weight: bold; color: red; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-undo waves-circle waves-effect btn btn-link"></i>

                <i onclick="delstud('<?php echo $row['id']; ?>')" data-stid="<?php echo $row['id']; ?>"
                      title="Delete this student" data-toggle='tooltip' id="delstud"
                      style="color: red; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-remove btn waves-effect waves-circle btn-link"></i>
            </div>
        </div>


    </div>


    <?php
}else{

    ?>

    <div id="row_<?=$id?>"  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 !important;">
        <div class="panel panel-default"
             style="margin:0 !important; margin-bottom: 2px !important; border-radius: 0 !important;">
            <div class="panel-body" style="padding: 0 !important; margin: 0 !important;">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"
                         style="margin: 0 !important;  text-align: center !important; padding-right: 0 !important; ">
                        <img style="max-height: 170px; border-radius: 0 !important; " alt="<?php echo $row['fname']; ?>"
                             src="<?php echo $row['photo'] ?>" class="img-thumbnail img-responsive"/>

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-9"
                         style="margin: 0 !important; padding-left: 0 !important;">
                        <div class="table-responsive text-danger" style="margin: 0 !important; padding: 0 !important;">
                            <table class="table table-striped table-bordered table-condensed"
                                   style="padding: 0 !important; margin: 0 !important;">
                                <tr>

                                    <th style="text-align: right;">ID:</th>
                                    <td><?php echo $row['stindex']; ?></td>

                                    <th style="text-align: right;">Name:</th>
                                    <td colspan='3'>
                                        <?php echo $row['fname'] . ' ' . $row['lname'] . ' ' . $row['oname']; ?>

                                    </td>


                                    <th style="text-align: right;">Gender:</th>
                                    <td>
                                        <?= $row['gender']; ?>
                                </tr>
                                <tr>


                                    <th style="text-align: right;">D.O.B:</th>
                                    <td>
                                        <?php echo $row['dob']; ?>
                                    </td>
                                    <th style="text-align: right;">Form:</th>
                                    <td>
                                        <?php echo "Form " . $row['form']; ?>

                                    </td>

                                    <th style="text-align: right;">Program:</th>
                                    <td>
                                        <?= $row["depname"] ?>


                                    </td>
                                    <th style="text-align: right;">Class</th>
                                    <td>


                                        <?= $row["classname"]; ?>


                                        </select>

                                    </td>

                                </tr>

                                <tr>
                                    <th style="text-align: right;">House:</th>
                                    <td colspan='2'><?php echo $row['name']; ?></td>
                                    <th style="text-align: right;">Last Sch.:</th>
                                    <td colspan='2'><?php echo $row['lschool']; ?> </td>
                                    <th style="text-align: right;">Reg. Date:</th>
                                    <td><?php echo $row['dor']; ?></td>
                                </tr>

                                <tr>
                                    <th style="text-align: right;">Father's Name:</th>
                                    <td colspan='3'>
                                        <?php echo $row['ffname']; ?>
                                    </td>
                                    <th style="text-align: right;">Father's Hometown:</th>
                                    <td>
                                        <?php echo $row['fhometown']; ?>
                                    </td>
                                    <th style="text-align: right;">Father's Tel.:</th>
                                    <td>
                                        <?php echo $row['ftel']; ?>

                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: right;">Mother's Name:</th>
                                    <td colspan='3'>
                                        <?php echo $row['mfname']; ?>
                                    </td>
                                    <th style="text-align: right;">Mother's Hometown:</th>
                                    <td>
                                        <?php echo $row['mhometown']; ?>


                                    </td>
                                    <th style="text-align: right;">Mother's Tel.:</th>
                                    <td>
                                        <?php echo $row['mtel']; ?>

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
                <span onclick="upstud(<?= $row['id']; ?>)" title="Edit this student's info." data-toggle='tooltip'
                      id="edstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="glyphicon glyphicon-edit btn btn-link"></span> &nbsp; &nbsp;
                <span onclick="printstud(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print this student's profile" data-toggle='tooltip' id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="glyphicon glyphicon-print btn btn-link"></span>&nbsp; &nbsp;
                <span onclick="Comnt(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Add extra info. to this studen's profile eg. suspension" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="glyphicon glyphicon-comment btn btn-link"></span>&nbsp; &nbsp;
                      <i onclick="printrep(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print termnal report" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-bar-chart-o waves-effect waves-circle btn btn-link"></i> 
                      <i onclick="printtransc(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print Transcript" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-line-chart waves-effect waves-circle btn btn-link"></i> 					  
                <span onclick="unwithdraw(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Resume this student back into the school" data-toggle='tooltip'
                      style="font-weight: bold; color: deepskyblue; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-plus-square btn btn-link"></span>&nbsp; &nbsp;

                <span onclick="delstud('<?php echo $row['id']; ?>')" data-stid="<?php echo $row['id']; ?>"
                      title="Delete this student" data-toggle='tooltip' id="delstud"
                      style="color: red; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="glyphicon glyphicon-remove-circle btn btn-link"></span>
            </div>
        </div>
    </div>
    
<?php }

} ?>
    
