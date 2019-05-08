<?php
include("objts/config.php");

$cf = new config();
$cf->connect();
$key = $_GET['key'];
$inactive = mysqli_query($cf->con,"select exiat.*,staff.fname as stfname, staff.lname as stlname,stuinfo.lname,stuinfo.fname,stuinfo.oname,stuinfo.photo,TIMESTAMPDIFF(HOUR,return_date,returned_time) as duedays from exiat,staff,stuinfo WHERE exiat.stfid = staff.id and exiat.stid = stuinfo.id and returned = 1 and return_date < NOW() and (stuinfo.fname LIKE'%$key%' or stuinfo.lname LIKE '%$key%' or stuinfo.oname LIKE '%$key%')");

while($row = mysqli_fetch_object($inactive)){
    ?>
    <div class="list-group-item " id="exeat_<?=$row->id?>">
        <div class="row ">

            <div class="col-2 col-md-1">
                <img class="img-fluid img-responsive img-rounded m-2" src="<?= file_exists($row->photo)? $row->photo :'objts/dpic/photo.jpg'?>" alt="">
            </div>
            <div class="col-10 col-md-11 ml-2">
                <a href="#" onclick="printstud(<?=$row->stid?>); return false;"><h6><?=$row->fname." ".$row->lname." ".$row->oname?></h6></a>
                         <span class="text-muted">
                             <?=$row->reason?>
                         </span> <br>
                <small class="text-muted">
                    Authorised By: <a href="#" onclick="printstf(<?=$row->stfid?>); return false;"><?=$row->stfname.' '.$row->stlname?></a> <small class="text-muted"><strong>Remark:</strong> <?=$row->remark ? $row->remark : "No Comment "?></small>
                </small>
                <small class="text-muted ml-2"><i class="fa fa-clock-o"></i> <?=$row->date_signed?> To</small> <small class="text-muted"><i class="fa fa-clock-o"></i> <?=$row->return_date?></small> <small class="text-muted ml-2"> Return Date/Time:<?=$row->returned_time?></small> <small class="ml-3 p-1 bg-light text-success"><?=$row->ex_type = 'in'?'Internal Exeat':'External Exeat'?></small>
                <small class="pull-right p-2 bg-danger text-white"><?=($row->duedays<1)?($row->duedays*60).'Min.':$row->duedays.'Hours'?> Late</small>
            </div>
        </div>
    </div>
    <?php
}
?>
