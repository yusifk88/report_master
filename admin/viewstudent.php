
<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
$conf = new \APP\config();
$conf->connect();
$id =  $_GET['id'];
$sql = "select stuinfo.id,fname,oname,lname,stindex,form,classes.classname,dept.depname,dob,dor,ffname,fhometown,ftel,gender,ayear,houses.des,houses.name,lschool,mfname,mhometown,mtel,photo,res_status,jhsno,shsno, (SELECT name from houses where id = stuinfo.ghouse) as ghouse from stuinfo,classes,dept,houses where stuinfo.class = classes.id and stuinfo.dept = dept.id and stuinfo.house = houses.id and stuinfo.id='$id'";
$student = mysqli_fetch_object(mysqli_query($conf->con,$sql));
$c = mysqli_query($conf->con,"select * from ginfo where stid = '$student->id' ");
if ($student){
?>


<div class="row">

    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-12 col-md-12">

                        <button class="btn btn-outline-primary" onclick="window.history.back()">
                            <i class="fa fa-arrow-left"></i>Back
                        </button>
                        <button title="Edit <?= $student->fname ?>'s information " onclick="upstud(<?= $student->id ?>)"
                                class="btn btn-link">
                            Edit
                        </button>

                        <button title="Print <?= $staff->fname ?>'s information " onclick="printstud(<?= $student->id; ?>)"
                                class="btn btn-link">
                            Print
                        </button>


                        <button title="Assign a subject and class to <?= $staff->fname ?>"
                                onclick="Comnt(<?=$student->id; ?>)"class="btn btn-link">
                            Comments
                        </button>


                        <button title="print<?= $staff->fname ?>'s report"
                                onclick="printrep(<?= $student->id; ?>)" class="btn btn-link">
                            Print report

                        </button>

                        <button title="print <?= $student->fname ?>'s transcript"
                                onclick="printtransc(<?= $student->id ?>)" class="btn btn-link">
                            Print transcript
                        </button>


                        <button title="Reset <?= $student->fname ?>'s password"
                                onclick="resetlogin('<?= $student->id?>')" class="btn btn-link d-none">
                            Reset Login
                        </button>

                        <?php
                        if (\APP\Students::isWithdrawn($student->id)) {
                            ?>
                            <button onclick="unwithdraw(<?= $student->id; ?>)"
                               title="Resume this student back into the school" data-toggle='tooltip'
                               class="btn btn-link text-primary">
                                Resume <?=$student->fname." ".$student->lname?>
                            </button>

                            <?php
                        } else {
                            ?>
                            <button onclick="withdraw(<?= $student->id; ?>)" data-id="<?php echo $row['id']; ?>"
                               title="Withdraw this student from the school" data-toggle='tooltip'
                               class="btn btn-link text-danger">
                                Withdraw <?=$student->fname." ".$student->lname?>
                            </button>

                            <button onclick="exiat(<?= $row['id']; ?>)" data-stid="<?php echo $row['id']; ?>"
                               title="Sign a permission for this student. eg. Exeat"
                               class="btn btn-link text-primary-">
                                Grant Exeat/permission
                            </button>
                            <?php

                        }


                        ?>

                        <button title="Delete <?= $staff->fname ?>" onclick="delstud('<?= $student->id; ?>')"
                                class="btn btn-link text-danger">
                            Delete <?=$student->fname." ".$student->lname?>
                        </button>



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
                             src="<?= $student->photo ? $student->photo : 'img/photo.jpg' ?>"> <br>
                        <?php
                        if ($student->res_status == 'Boarding Student') {
                            ?>
                            <small class=" bg-success text-white p-2 m-2">Boarding Student</small>

                            <?php
                        } else {

                            ?>
                            <small class="bg-warning text-white p-2 m-2">Day Student</small>

                            <?php
                        }


                        ?>
                    </div>
                    <div class="col-md-10">




                <table class="table">
                    <tr class="w-100">
                        <td>
                            <?= $student->fname . " " . $student->lname." ".$student->oname ?><br>
                            <small class="text-muted">Name</small>
                        </td>

                        <td>
                            <?= $student->gender ?><br>
                            <small class="text-muted">Gender</small>
                        </td>

                        <td>
                            <?= $student->depname ?><br>
                            <small class="text-muted">Program</small>
                        </td>

                        <td>
                            <?= $student->classname ?><br>
                            <small class="text-muted">Class</small>
                        </td>

                    </tr>

                    <tr class="w-100">
                        <td>
                            <?= $student->dob ?><br>
                            <small class="text-muted">Date of Birth</small>
                        </td>

                        <td>
                           Form <?= $student->form ?><br>
                            <small class="text-muted">Form</small>
                        </td>

                        <td>
                            <?= $student->name ?><br>
                            <small class="text-muted">House</small>
                        </td>

                        <td>
                            <?= $student->ghouse ?><br>
                            <small class="text-muted">Gender house/hall</small>
                        </td>
                    </tr>

                    <tr class="w-100">


                        <td>
                            <?= $student->ffname ?><br>
                            <small class="text-muted">Father's name</small>
                        </td>

                        <td>
                            <?= $student->fhometown ?><br>
                            <small class="text-muted">Father's hometown</small>
                        </td>

                        <td>
                            <?= $student->ftel ?><br>
                            <small class="text-muted">Father's Phone#</small>
                        </td>
                        <td>
                            <?= $student->mfname ?><br>
                            <small class="text-muted">Mother's Name</small>
                        </td>
                    </tr>

                    <tr class="w-100">


                        <td>
                            <?=$student->mhometown?><br>
                            <small class="text-muted">Mother's hometown</small>
                        </td>

                        <td>
                            <?=$student->mtel?><br>
                            <small class="text-muted">Mother's Phone#</small>
                        </td>

                        <td>
                            <?=$student->jhsno?><br>
                            <small class="text-muted">JHS Number</small>
                        </td>

                        <td>
                            <?=$student->shsno?><br>
                            <small class="text-muted">SHS Number</small>
                        </td>

                    </tr>

                </table>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

 <?php
    if ($student){
     ?>
     <div class="row">
         <div class="col-md-10 mx-auto">
             <div class="card">
                 <div class="card-header">
                     <h4>Comments logged on <?=$student->fname." ".$student->lname?>'s profile</h4>

                 </div>
                 <div class="card-body">
                     <table class="table table-hover table-striped" id="table">
                         <thead>
                         <tr>
                             <th>Terms/Semester</th>
                             <th>Year</th>
                             <th>Comment</th>
                             <th>Date</th>
                         </tr>
                         </thead>
                         <tbody>
                         <?php
                         while ($record = mysqli_fetch_object($c)){
                             ?>
                             <tr>
                                 <td><?=$record->term?></td>
                                 <td><?=$record->ayear?></td>
                                 <td><?=$record->coment?></td>
                                 <td><?=$record->dentry?></td>

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
    ?>
<div class="col-md-4 mx-auto">
    <?php
    \APP\Utitlity::showError("Student not found!","Invalid Identifier",'danger');

    ?>

</div>

    <?php

}
    ?>

