<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
$cf = new config();
$cf->connect();
$per_page = 20;
$prog = $_GET['prog'];
$cls = $_GET['cls'];
$huse = $_GET['huse'];
$form = $_GET['form'];
$ayear = $_GET['ayear'];
$gender = $_GET['gender'];
$ghouse = $_GET['ghouse'];
$resstatus = $_GET['resstatus'];

if ($ghouse) {
    $stql = "select stuinfo.id,fname,oname,lname,stindex,form,classes.classname,dept.depname,dob,dor,ffname,fhometown,
            ftel,gender,ayear,houses.des,houses.name,lschool,mfname,mhometown,mtel,photo,res_status, 
            (SELECT name from houses where id = stuinfo.ghouse) as ghouse from stuinfo,classes,dept,houses where 
            stuinfo.class = classes.id and stuinfo.dept = dept.id and stuinfo.house = houses.id and stuinfo.gender 
            like '$gender%' and  stuinfo.dept like '%$prog%' and stuinfo.class like '$cls%' and stuinfo.house like 
            '$huse%' and stuinfo.form like '$form%' and stuinfo.ayear like '%$ayear%' and stuinfo.ghouse 
            LIKE '$ghouse%' and stuinfo.res_status LIKE '%$resstatus%' order by ayear DESC ,fname ASC";

} else {
    $stql = "select stuinfo.id,fname,oname,lname,stindex,form,classes.classname,dept.depname,dob,dor,ffname,fhometown,ftel,gender,ayear,houses.des,houses.name,lschool,mfname,mhometown,mtel,photo,res_status, (SELECT name from houses where id = stuinfo.ghouse) as ghouse from stuinfo,classes,dept,houses where stuinfo.class = classes.id and stuinfo.dept = dept.id and stuinfo.house = houses.id and stuinfo.gender like '$gender%' and  stuinfo.dept like '$prog%' and stuinfo.class like '$cls%' and stuinfo.house like '$huse%' and stuinfo.form like '$form%' and stuinfo.ayear like '%$ayear%' and stuinfo.res_status LIKE '%$resstatus%' order by ayear DESC ,fname ASC";
}


$studs = mysqli_query($cf->con, $stql);

?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body table-responsive">
                <table id="table" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>ID#</th>
                            <th>Name</th>
                            <th>Boarding status</th>
                            <th>Gender</th>
                            <th>Date of birth</th>
                            <th>Form</th>
                            <th>House</th>
                            <th>program</th>
                            <th>Class</th>
                            <th>Last school attended</th>
                            <th>Gender house/hall</th>
                            <th>Father's name</th>
                            <th>Mother's name</th>
                            <th>Father's phone#</th>
                            <th>Mother's phone#</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php
                    while ($row = mysqli_fetch_assoc($studs)) {?>

                          <tr>
                            <td>
                                <img width="190" height="200" alt="<?= $row['fname'] ?>"
                                     datasrc="<?= file_exists($row['photo']) ? $row['photo'] : 'objts/dpic/photo.jpg' ?>"
                                     src='objts/dpic/photo.jpg' class="img-thumbnail img-fluid img-responsive st-photos"/>

                            </td>
                            <td>
                                <?php echo $row['stindex']; ?>
                            </td>

                            <td>
                                <a href="#/viewstudent?id=<?=$row['id']?>">

                                <?= $row['fname'] . ' ' . $row['lname'] . ' ' . $row['oname']; ?>
                                </a>

                            </td>
                            <td>
                                <?php
                                if ($row['res_status'] == 'Boarding Student') {
                                    ?>
                                    <small class=" text-success">Boarding Student</small>

                                    <?php
                                } else {

                                    ?>
                                    <small class="text-warning">Day Student</small>

                                    <?php
                                }


                                ?>

                            </td>
                            <td>
                                <?= $row['gender']; ?>
                            </td>
                            <td>
                                <?php echo $row['dob']; ?>
                            </td>
                            <td>
                                <?php echo "Form " . $row['form']; ?>
                            </td>
                            <td>
                                <?php echo $row['name']; ?>
                            </td>

                            <td>
                                <?= $row["depname"] ?>
                            </td>
                            <td>
                                <?= $row["classname"]; ?>
                            </td>
                            <td>
                                <?php echo $row['lschool']; ?>
                            </td>
                            <td>
                                <?= $row['ghouse'] ? $row['ghouse'] : 'None'; ?>
                            </td>
                            <td>
                                <?php echo $row['ffname']; ?>
                            </td>
                            <td>
                                <?php echo $row['mfname']; ?>
                            </td>

                            <td>
                                <?php echo $row['ftel']; ?>
                            </td>
                            <td>
                                <?php echo $row['mtel']; ?>
                            </td>

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

<script>

    $('#cbopage-list').change(function () {
        var page = $(this).val();
        getstud(page);
    });
    $("i").tooltip();
    var cachename = 'imgv1.0';
    var cachedimg = [];
    // $(".st-photos").each(function (key, obj) {
    //     obj.src = $(obj).attr('datasrc');
    //
    //     cachedimg[key] = $(obj).attr('datasrc');
//        caches.match($(obj).attr('datasrc')).then(function (responds) {
//           if(responds){
//               obj.src = responds.url.replace("http://localhost/online/report/admin/","");
//
//           } else{
//           obj.src = $(obj).attr('datasrc');
//           }
//
//        });
    //});
    // caches.open(cachename).then(function (cache) {
    //     return cache.addAll(cachedimg);
    //
    // })
</script>
