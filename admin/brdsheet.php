<?php
include_once './objts/config.php';
include_once './objts/school.php';
include_once './objts/utitlity.php';
$ut = new utitlity();
$sch = new school();
$term=$_GET['term'];
$ayear =$_GET['ayear'];
$cls =$_GET['cls'];
//$sub= $_GET['subjt'];
$cg = new config();
$cg->connect();
include_once './objts/utitlity.php';
$util = new Utitlity();
$subs = mysqli_query($cg->con,"select id,subjdesc from subjects where id in (select distinct(subjt) from records where acyear = '$ayear' and term = '$term' and cls = '$cls')");
$classname = mysqli_fetch_object(mysqli_query($cg->con,"select classname from classes where id = '$cls'"))->classname;
$numroll =  mysqli_fetch_object(mysqli_query($cg->con,"select count(*) as cn from records where term ='$term' and acyear = '$ayear' and cls = '$cls'"))->cn;
$avge = mysqli_fetch_object(mysqli_query($cg->con,"select avg(totlscore) as avgs from records where term ='$term' and acyear = '$ayear' and cls='$cls'"))->avgs;
$term_suf = $util->addsufix($term);
?>
<html>
<head>
	<title>Termly assessment Plan</title>
        <link href='css/bootstrap-print.css' rel='stylesheet' />
		     <style type="text/css">
            table, th, tr, td{
border:1px solid #000 !important;
}
#main_head{
font-size:28px;
font-weight: bold;
}
#sub_head{
font-size:20px;
font-weight: bold;
}
@media print{
     table, th, tr, td{
border:1px solid #000 !important;
}
}

</style>
</head>
<body>
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
          <center>
              <u><span id='main_head'><?=$sch->schname;?></span></u> <br/>
         <?=$sch->schooladdress;?>
        <br/><u><span id='sub_head'>TERMLY ASSESSMENT BROADSHEET</span></u>
         </center>
			</div>
		</div>
		<div class='row'>
			<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
			<table class='table table-striped table-condensed'>
				<thead>
						<tr>
                        <th colspan='2'>CLASS: </th> <td colspan='3' ><?=$classname;?></td>   <th colspan='2'>AC. YEAR:</th> <td colspan='3'><?=$ayear;?></td> <th>TERM: </th> <td colspan="5"><?=$term_suf;?> Term</td>
					</tr>
					<tr>

					</tr>
		
				<tr>
             <th style='text-align:center;'>S/N</th>
            <th >FULL NAME</th>
            <?php
            while ($row = mysqli_fetch_object($subs)) {
                ?>
            <th style="text-align: center; vertical-align: middle;">
                <?=$row->subjdesc;?>
            </th>
                <?php
            }

            ?>
                <th>POS.</th>
                <th>SUM MKS</th>
                <th>FAILS</th>
				</tr>
				</thead>				
				<tbody>
                    <?php
                    $studs = mysqli_query($cg->con,"SELECT id as stid,(SELECT SUM((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) FROM records WHERE records.stid = stuinfo.id and acyear='$ayear' and term='$term') as sm, fname,lname,oname  from stuinfo WHERE id in(SELECT DISTINCT(stid) from records where acyear = '$ayear' and term = '$term' and cls = '$cls') and stuinfo.id not in(SELECT stid from withdraw) ORDER by sm DESC");
                    $i=1;

                    while($studrows=  mysqli_fetch_object($studs)){
                        $fails = 0;
                    $stid = $studrows->stid;
                    $subs2 = mysqli_query($cg->con,"select id,subjdesc from subjects where id in (select distinct(subjt) from records where acyear = '$ayear' and term = '$term' and cls = '$cls')");
                    ?>
                    <tr>
                     <td style="text-align: center; vertical-align: middle;"><?=$i;?></td>
                     <td><?=$studrows->fname.' '.$studrows->lname.' '.$studrows->oname?></td>
                     <?php
                     while ($row1 = mysqli_fetch_object($subs2)) {
                     $subid = $row1->id;
                     $grds = mysqli_query($cg->con,"select ((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) as tscore from records where stid = '$stid' and subjt = '$subid' and term = '$term' and acyear = '$ayear'");

                         if(mysqli_num_rows($grds)>0) {
                            while ($row2 = mysqli_fetch_object($grds)) {


                                 //
                                 if ($ut->getgrd(number_format($row2->tscore,1)) === 'F9') {
                                     $fails++;
                                     ?>
                                     <td style=" vertical-align: middle; text-align: center; background-color: red; color: white;"><?= $ut->getgrd(number_format($row2->tscore,1)); ?></td>
                                     <?php
                                 } else {
                                     ?>
                                     <td style="text-align: center; vertical-align: middle;"><?= $ut->getgrd(number_format($row2->tscore,1)); ?></td>
                                     <?php
                                 }
                             }
                         }else{
                             ?>
                             <td style=" vertical-align: middle; text-align: center;">-</td>
                             <?php
                         }
                      }

                     ?>
                     <td style="text-align: center; vertical-align: middle;"><?=$util->addsufix($i);?></td>
                     <td style="text-align: center; vertical-align: middle;"><?=number_format($studrows->sm,1);?></td>
                     <td style="text-align: center; vertical-align: middle;"><?=$fails;?></td>
                     </tr>
                  <?php
                  $i++;
                   }?>
				</tbody>
			</table>
                <p>HEADMASTER'S/HEADMISTRESS' SIGNATURE.............................................................</p>
            </div>
		</div>
			<button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print</button>
	</div>
</body>
</html>