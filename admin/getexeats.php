<?php
include("objts/config.php");
$cf = new config();
$cf->connect();
$active = mysqli_query($cf->con,"select exiat.*,staff.fname as stfname, staff.lname as stlname,stuinfo.lname,stuinfo.fname,stuinfo.oname,stuinfo.photo,TIMESTAMPDIFF(HOUR,NOW(),return_date) as duedays from exiat,staff,stuinfo WHERE exiat.stfid = staff.id and exiat.stid = stuinfo.id and returned = 0 and return_date > NOW()");
$due = mysqli_query($cf->con,"select exiat.*,staff.fname as stfname, staff.lname as stlname,stuinfo.lname,stuinfo.fname,stuinfo.oname,stuinfo.photo,TIMESTAMPDIFF(HOUR,return_date,NOW()) as duedays from exiat,staff,stuinfo WHERE exiat.stfid = staff.id and exiat.stid = stuinfo.id and returned = 0 and return_date < NOW()");
$inactive = mysqli_query($cf->con,"select exiat.*,staff.fname as stfname, staff.lname as stlname,stuinfo.lname,stuinfo.fname,stuinfo.oname,stuinfo.photo,TIMESTAMPDIFF(HOUR,return_date,returned_time) as duedays from exiat,staff,stuinfo WHERE exiat.stfid = staff.id and exiat.stid = stuinfo.id and returned = 1 and return_date < NOW() order by returned_time asc LIMIT 0, 50");

?>
<div id="accordion">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Active Exeats
                </button>
            </h5>
        </div>
        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
        <div class="list-group list-group-flush">

            <?php
             while($row = mysqli_fetch_object($active)){
             ?>
             <div class="list-group-item ">
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
                             Authorised By: <a href="#" onclick="printstf(<?=$row->stfid?>); return false;"><?=$row->stfname.' '.$row->stlname?></a>
                         </small>
                         <small class="text-muted ml-2"><i class="fa fa-clock-o"></i> <?=$row->date_signed?> To</small> <small class="text-muted"><i class="fa fa-clock-o"></i> <?=$row->return_date?></small> <small class="ml-3 p-1 bg-light text-success"><?=$row->ex_type = 'in'?'Internal Exeat':'External Exeat'?></small>
                         <small class="pull-right p-2 bg-danger text-white"><?=$row->duedays?> Hours To Due Time</small>
                     </div>
                 </div>
             </div>
             <?php
             }
            ?>
        </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Due Exeats
                </button>
            </h5>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php
                    while($row = mysqli_fetch_object($due)){
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
                                        Authorised By: <a href="#" onclick="printstf(<?=$row->stfid?>); return false;"><?=$row->stfname.' '.$row->stlname?></a>
                                    </small>
                                    <small class="text-muted ml-2"><i class="fa fa-clock-o"></i> <?=$row->date_signed?> To</small> <small class="text-muted"><i class="fa fa-clock-o"></i> <?=$row->return_date?></small> <small class="ml-3 p-1 bg-light text-success"><?=$row->ex_type = 'in'?'Internal Exeat':'External Exeat'?></small>
                                   <button onclick="mark_ex(<?=$row->id?>)" class="btn bg-info text-white btn-sm">Mark as done</button>
                                    <small class="pull-right p-2 bg-danger text-white">Due <?=($row->duedays<1)?($row->duedays*60).'Min.':$row->duedays.'Hours'?> ago</small>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingThree">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Inactive Exeats
                </button>
            </h5>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
                <div class="list-group list-group-flush" id="inactive_ex_list">

                    <div class="list-group-item list-group-item-heading">
                        <div class="md-form">
                            <i class="prefix fa fa-search"></i>
                            <input class="form-control" type="search" name="search_ex" id="search_ex">
                            <label for="search_ex">Search By student Name...</label>
                        </div>
                        <small class="text-muted">Showing first 50 latest inactive exeats, please search if you can't see the record you are looking for</small>
                    </div>
                    <div id="ex-body">
                    <?php
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#search_ex").keyup(function () {

$
    .get("search_ex.php?key="+$("#search_ex").val())
    .done(function (d) {
    $("#ex-body").html(d);
    })
    .error(function () {

        show_error();

    });
    });
</script>