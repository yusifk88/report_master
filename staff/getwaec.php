<?php
include_once("../admin/objts/config.php");
$cf = new config();
$cf->connect();
$grade_val = array(
    "A1"=>1,
    "B2"=>2,
    "B3"=>3,
    "C4"=>4,
    "C5"=>5,
    "C6"=>6,
    "D7"=>7,
    "E8"=>8,
    "F9"=>9,
    "WH"=>0,
    "CNL"=>9
);
function mkindex($i){
    if($i<10){
        return "010040200".$i;

    }else if($i<99 && $i>9){

        return "01004020".$i;

    }else{
        return "0100402".$i;
    }
}

$search = $_GET['search'];
$ayear = $_GET['ayear'];
$studs = mysqli_query($cf->con,"select * from stuinfo where form = '3' and ayear = '$ayear' and (fname LIKE '%$search%' or lname LIKE '%$search%') order by lname ASC");
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
    <table class="table table-condensed table-bordered table-hover">
    <?php
    $sn = 1;
    while($row = mysqli_fetch_object($studs)){
        $stid = $row->id;
        $recs = mysqli_query($cf->con,"select waec.*,subjects.* from waec,subjects where subjects.id = waec.subid and waec.stid = '$stid'");
        $recs2 = mysqli_query($cf->con,"select waec.*,subjects.* from waec,subjects where waec.subid = subjects.id and waec.stid = '$stid'");
        $core = mysqli_fetch_object(mysqli_query($cf->con,"select sum(grade_val) as sm from waec where stid = '$stid' and subid in (SELECT id from subjects where type = 'Core Subject' and subjdesc not LIKE '%social studies%' and subjdesc not LIKE '%PE%' and subjdesc not LIKE '%P.E%' and subjdesc not LIKE '%physical education%' and subjdesc not LIKE '%ict%' and subjdesc not LIKE '%I.C.T%')"))->sm;
        $elec = mysqli_query($cf->con,"select grade_val from waec where stid = '$stid' and subid in (SELECT id from subjects where type = 'Elective Subject') ORDER  by grade_val ASC ");
        $elec_val = 0;
        $i = 1;
        while($val = mysqli_fetch_object($elec)){
            if($i<4) {
                $elec_val += $val->grade_val;
            }
            $i++;
        }

        $grade = $core + $elec_val;

        if(mysqli_num_rows($recs2)>0){
    ?>
    <tr>
    <td rowspan="3" style="vertical-align: middle"><?=$sn?></td>
    <td rowspan="3" style="vertical-align: middle"><a href="#" onclick="printstud(<?=$row->id?>); return false;"><?=$row->lname." ".$row->oname." ".$row->fname?></a></td>
    </tr>
    <tr class="text-center">
        <th class="text-center">Index No.</th>
        <th class="text-center">DOB</th>
    <?php
    while($recrow = mysqli_fetch_object($recs)){
        ?>
        <th><?=$recrow->subjdesc?></td>
    <?php
    }
    ?>
    <th style="color: deepskyblue;" colspan="2">Aggregate</th>
    </tr>
    <tr class="text-center">
    <td class="text-center"><?=mkindex($sn)?></td>
        <td class="text-center"><?=$row->dob?></td>
        <?php
    while($recrow2 = mysqli_fetch_object($recs2)){
    ?>
    <td><?=$recrow2->grade?></td>
    <?php
    }
    ?>
    <td><?=$grade?></td>
    <td><i onclick="delwaec(<?=$stid?>)" class="fa fa-remove text-danger waves-effect waves-circle"></i></td>
    </tr>
    <?php
        $sn++;
    }}
    ?>
    </table>
        </div>
</div>
<script>
    function printstud(id){
        window.open("studprofile.php?id="+id,"Student's Profile","outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");


    }
function delwaec(id){
    BootstrapDialog.show({
        title:"Confirm Delete",
        message:"Are you sure you want to delete this record?",
        buttons:[{label:"DELETE",cssClass:"btn-bad waves-effect",action:function(d){

            $
                .get("delwaec.php?id="+id)
                .done(function(){
                    getwaec();
                d.close();

                });
        }}]
    });
}
</script>

