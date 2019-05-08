
<?php
include_once './objts/config.php';
include_once './objts/school.php';
$sch = new school();
$term=$_GET['term'];
$ayear =$_GET['ayear'];
$cls =$_GET['cls'];
$sub= $_GET['sub'];

$cg = new config();
$cg->connect();
include_once './objts/utitlity.php';
$util = new Utitlity();
$classname = mysqli_fetch_object(mysqli_query($cg->con,"select classname from classes where id = '$cls'"))->classname;
$staff = mysqli_fetch_object(mysqli_query($cg->con,"select lname,fname from staff where id = (select stfid from subas where clid='$cls' and subid = '$sub')"));
$subname = mysqli_fetch_object(mysqli_query($cg->con,"select subjdesc from subjects where id = '$sub'"))->subjdesc;
$numroll =  mysqli_fetch_object(mysqli_query($cg->con,"select count(*) as cn from records where term ='$term' and acyear = '$ayear' and subjt = '$sub' and cls = '$cls'"))->cn;
$term_suf = $util->addsufix($term);
if(!$staff){
    $stfname = "";
    $stlname = "";
    
}else{
    
    $stfname = $staff->fname;
    $stlname = $staff->lname;
    
    
}
?>
<html>
<head>
	<title>Termly Score Sheet</title>
        <link href='css/bootstrap-print.css' rel='stylesheet' />
		     <style type="text/css">
            table, th, tr, td{
border:1px solid #000 !important;
				font-size: 13px;
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
                            <br/><u><span id='sub_head'>TERMLY ASSESSMENT SCORE SHEET (<?=$ayear;?>)</span></u> 
                             </center>
			</div>
		</div>
		<div class='row'>
			<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
			<table class='table table-striped table-condensed'>
				<thead>
					<tr>
					<th>SUBJECT: </th> <td colspan="3"><?=$subname;?></td><td colspan="6"><strong>TUTOR:</strong> <?= $stfname." ".$stlname;?></td>  <td colspan="3"><strong>CLASS: </strong> <?=$classname;?></td><td colspan="2"><strong>TERM:</strong><?=$term_suf;?> Term </td>

					</tr>
					
				<tr>
                    <th style='text-align:center;'>S/N</th>
						<th >FULL NAME</th>
						<th  style='text-align :center;' colspan='4'>CLASS TEST</th>
						<th  style='text-align :center;' >Sub<br/> Total</th>
						<th style='text-align: center;' colspan='4'>CLASS EXERCISE</th>
						<th style='text-align: center;' >Sub<br/> Total</th>
<!--						<th style='text-align: center; '  colspan="2">PROJECT <br> WORK</th>-->
<!--						<th style='text-align: center; '>Sub<br/>Total</th>-->
						<th style='text-align: center;'> Total SBA</th>
						<th style='text-align: center;'>EXAMS<br/>100%</th>
				</tr>				
				</thead>				
				<tbody> 
                                    
                                    <?php
                                   $recs = mysqli_query($cg->con,"select fname,lname,oname from stuinfo where class = '$cls' and ayear = '$ayear' and id not in(SELECT stid from withdraw) order by fname ASC, lname ASC ");
                                 $i=1;
                                   while($recrows=  mysqli_fetch_object($recs)){
                                    
                                    ?>
                                    
                                    
                    <tr>
                                        <td style='text-align: center;'><?=$i;?></td>
					<td><?= $recrows->fname." ".$recrows->lname." ".$recrows->oname;?></td>
					<td style='text-align:center;'></td>
					<td style='text-align:center;'></td>
					<td style='text-align:center;'></td>
					<td style='text-align:center;'></td>
					<td style='text-align:center;'></td>
					<td style='text-align:center;'></td>
					<td style='text-align:center;'></td>
					<td style='text-align:center;'></td>
					<td style='text-align:center;'></td>
					<td style='text-align:center;'></td>
					<td style='text-align:center;'></td>
<!--					<td style='text-align:center;'></td>-->
<!--					<td style='text-align:center;'></td>-->
<!--					<td style='text-align:center;'></td>-->
					<td style='text-align:center;'></td>
					
					
				</tr>  
                                  <?php 
                                  
                                  $i++;
                                   }?>
            
				</tbody>
			
			</table>
			
		</div>
		
		</div>
		<div class='row'>
		
		
		</div>

			<button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print</button>
	
	</div>
</body>
</html>