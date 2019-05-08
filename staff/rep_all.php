<?php
include_once './objts/school.php';
include_once 'objts/config.php';
include_once './objts/utitlity.php';
$cf = new config();
$cf->connect();
$util = new Utitlity();
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
?>

<html>
    <head>
        <meta charset="UTF-8">
   
        <link href="css/bootstrap-print.css" rel="stylesheet" type="text/css"/>
        <style type="text/css">
            table, th, tr, td{
border:1px solid #000 !important;


}

@media print{
    
     table, th, tr, td{
border:1px solid #000 !important;


}
    
}
            
        </style>
    </head>
    <body>
        <div class="container-fluid">
            
            
            
        <?php
        $cfg = new config();
        $cfg->connect();
        $stids = mysqli_query("select distinct(stid) from records where acyear = '$ayear' and cls = '$cls' and term = '$term'");
        
        while ($row1 = mysqli_fetch_object($stids)) {
            $stid = $row1->stid;

        $stinfo = mysqli_fetch_object(mysqli_query("select fname,lname,oname,photo from stuinfo where id = '$stid'"));
        $rep1 = mysqli_query("select cvsubtotl,cvexam,totlscore,subjects.subjdesc,grd,remark,post from records,subjects where cls = '$cls' and acyear = '$ayear' and term = '$term' and stid = '$stid' and records.subjt = subjects.id and subjects.type = 'Core Subject'");
        $rep2 = mysqli_query("select cvsubtotl,cvexam,totlscore,subjects.subjdesc,grd,remark,post from records,subjects where cls = '$cls' and acyear = '$ayear' and term = '$term' and stid = '$stid' and records.subjt = subjects.id and subjects.type = 'Elective Subject'");
       
        $sch = new school();
        $clas = mysqli_query("select classname from classes where id = '$cls'");
        $cl = mysql_result($clas, 0);
         // $summark = mysql_result(mysqli_query("select sum(totlscore) from records where stid = '$stid' and cls = '$cls' and acyear = '$ayear' and term = '$term'"),0);
        //  $totlpost = mysql_result(mysqli_query("select post from totls where stid = '$stid' and cls = '$cls' and ayear = '$ayear' and term = '$term'"),0);
        $summark = mysql_result(mysqli_query("select sum(totlscore) from records where stid = '$stid' and cls = '$cls' and acyear = '$ayear' and term = '$term'"),0);
        $subcount = mysqli_query("select count(subjt) from records where stid = '$stid' and cls = '$cls' and acyear = '$ayear' and term = '$term'");
        $scount = mysql_result($subcount, 0);
        $avg = $summark/$scount;
        $totlpost = mysql_result(mysqli_query("select post from totls where stid = '$stid' and cls = '$cls' and ayear = '$ayear' and term = '$term'"),0);
        $num_rol = mysqli_num_rows(mysqli_query("select distinct(stid) from records where cls = '$cls' and acyear = '$ayear' and term = '$term'"));
      
        ?>
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <img  class="img-responsive" src="objts/<?= $sch->logopath ?>" alt="School Crest" />

                </div>
                <div class="col-lg-10 col-md-10">
                     <center>
                         <u><span style="font-size: 25px; font-weight: bold;"><?= ucwords($sch->schname) ?></span><br/></u>
                <span style="font-size: 15px;"><?= ucwords($sch->schooladdress) ?></span><br/>
                <span style="font-size: 22px;">STUDENT'S TERMLY ASSESSMENT REPORT </span>

                
            </center>
            
                    
                    
                </div>
                
                
            </div>
           
         <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print</button>
	
        <table class="table table-striped">
            <thead>
                <tr>
                    
                    
                    <th rowspan="2" style="text-align: center;">
                        <img width="90" height="100" src="<?=$stinfo->photo;?>" />
                        
                    </th>
                     <th style="vertical-align: middle;">NAME:</th>
                    <td style="vertical-align: middle;" colspan="3"><?=$stinfo->fname.' '.$stinfo->lname.' '.$stinfo->oname?></td>
                    <th style="vertical-align: middle;">No. Roll:</th><td style="vertical-align: middle; text-align: center;"><?= $num_rol?></td>
                    
                </tr>
                <tr>
                    <th style="vertical-align: middle;">Class:</th>
                    <td style="vertical-align: middle;"><?=$cl;?></td>
                    
                    <th style="vertical-align: middle;">Academic Year:</th>
                    <td style="vertical-align: middle;"><?=$ayear;?></td>
                    <th style="vertical-align: middle;">Term:</th>
                    <td style="vertical-align: middle;"><?= $util->addsufix($term).' Term';?></td>
                    
                </tr>
                
                <tr>
                    <th style="text-align: center;">
                        SUBJECT
                    </th>
                    <th style="text-align: center;">
                        SBA(<?=$sch->clscore_ratio.'%';?>)
                    </th>
                    <th style="text-align: center;">
                        EXAM(<?=$sch->exam_ratio.'%';?>)
                    </th>
                    <th style="text-align: center;">
                        TOTAL MARK
                    </th>
                    <th style="text-align: center;">
                        GRADE
                    </th>
                  
                    <th style="text-align: center;">
                        REMARK
                    </th>
                  
                    <th style="text-align: center;">
                        POS.
                    </th>
                  
                </tr>
                
                
                
            </thead>
            <tbody>
                <tr>
                    
                                        <td class="text-muted" colspan="7" style="text-align: center; font-weight: bold; font-style: italic;">CORE SUBJECTS</td>
    
                </tr>
                <?php
                $i=1;
                 while ($row = mysqli_fetch_object($rep1)) {
            
             ?>
             
                <tr>
                    <td style="text-align: center;"><?=$row->subjdesc;?></td>
                    <td style="text-align: center;"><?=$row->cvsubtotl;?></td>
                    <td style="text-align: center;"><?=$row->cvexam;?></td>
                    <td style="text-align: center;"><?=$row->totlscore;?></td>                   
                    <td style="text-align: center;"><?=$row->grd;?></td>                   
                    <td style="text-align: center;"><?=$row->remark;?></td>                   
                    <td style="text-align: center;"><?=$row->post;?></td>                   
                    
                </tr>  
              <?php  
              $i++;
        }
        ?> 
                
                 <tr>
                    
                                         <td class="text-muted" colspan="7" style="text-align: center; font-weight: bold; font-style: italic;">ELECTIVE SUBJECTS</td>
   
                </tr>
                
                     <?php
                $i=1;
                 while ($row2 = mysqli_fetch_object($rep2)) {
            
             ?>
             
                <tr>
                    <td style="text-align: center;"><?=$row2->subjdesc;?></td>
                    <td style="text-align: center;"><?=$row2->cvsubtotl;?></td>
                    <td style="text-align: center;"><?=$row2->cvexam;?></td>
                    <td style="text-align: center;"><?=$row2->totlscore;?></td>                   
                    <td style="text-align: center;"><?=$row2->grd;?></td>                   
                    <td style="text-align: center;"><?=$row2->remark;?></td>                   
                    <td style="text-align: center;"><?=$row2->post;?></td>                   
                    
                </tr>  
              <?php  
              $i++;
        }
        ?> 
                
            </tbody>
            <tfoot>
                
                <tr style="color:red;">
                    <th>Overall Position:</th>
                    <td style="text-align: center;"><?=$totlpost;?></td>
                    <th>Overall Average Score:</th>
                    <td style="text-align: center;"><?=number_format($avg,2);?></td>
                </tr>
                
                
                
            </tfoot>
                
                
                
           
        </table>
       <div class='row'>
			<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
			<strong>ATTENDANCE:........... OUT OF.............</strong>
		
		</div>	
	</div>


		<div class='row'>
			<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
			<strong>CONDUCT:........................................................................................................................................................................................</strong>
		
		</div>	
	</div>

	</div>
		<div class='row'>
			<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
			<strong>INTEREST:........................................................................................................................................................................................</strong>
		
		</div>	
	</div>
		<div class='row'>
			<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
			<strong>FORM MASTER's/MISTRESS' REMARK:........................................................................................................................................</strong>
		
		</div>	
	</div>
            <div class='row' style="page-break-after: always;">
			<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
			<strong>HEAD TEACHER'S SIGNATURE:.....................................................................................................................................................</strong>
		
		</div>	
	</div>
            <?php } ?>
            
            <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print</button>
	
        </div>
    </body>
</html>

