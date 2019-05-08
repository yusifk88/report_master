<?php
include("check_session.php");
include_once './objts/school.php';
include_once 'objts/config.php';
include_once './objts/utitlity.php';

$util = new utitlity();
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
$sch = new school();
$cfg = new config();
$cfg->connect();

?>

<html>
    <head>
        <meta charset="UTF-8">
   
        <link href="css/bootstrap-print.css" rel="stylesheet" type="text/css"/>
        <style type="text/css">
            table, th, tr, td{
border:1px solid #000 !important;

background-color: transparent !important;
-webkit-background-color: transparent !important;
}

@media print{
    
     table, th, tr, td{
border:1px solid #000 !important;
background-color: transparent !important;
-webkit-background-color: transparent !important;

}
table.table-striped{
    background-image:  url('./img/wmark2.png') !important; background-repeat: no-repeat; background-position: center; background-size: contain;
   background-repeat: no-repeat !important; background-position: center !important; background-size: 50% !important; 
}
    
}
            
        </style>
    </head>
    <body>
        <div class="container-fluid">
        <?php

        $stids = mysqli_query($cfg->con,"SELECT id as stid,(SELECT SUM((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) FROM records WHERE stid = stuinfo.id and acyear='$ayear' and term='$term') as sm from stuinfo WHERE id in(SELECT DISTINCT(stid) from records where acyear = '$ayear' and term = '$term' and cls = '$cls') and id not in(select stid from withdraw) ORDER by sm DESC");
        $pos =1;
        while ($row1 = mysqli_fetch_object($stids)) {
        $stid = $row1->stid;
        $stinfo = mysqli_fetch_object(mysqli_query($cfg->con,"select fname,lname,oname,photo,ftel,fhometown,mtel,houses.name from stuinfo,houses where stuinfo.id = '$stid' and stuinfo.house = houses.id"));
        $rep1 = mysqli_query($cfg->con,"select subjt,stid,subtotl,exam,cvsubtotl,cvexam,totlscore,subjects.subjdesc,post,((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) as tscore from records,subjects where cls = '$cls' and acyear = '$ayear' and term = '$term' and stid = '$stid' and records.subjt = subjects.id and subjects.type = 'Core Subject'");
        $rep2 = mysqli_query($cfg->con,"select subjt,stid,subtotl,exam,cvsubtotl,cvexam,totlscore,subjects.subjdesc,grd,remark,post,((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) as tscore from records,subjects where cls = '$cls' and acyear = '$ayear' and term = '$term' and stid = '$stid' and records.subjt = subjects.id and subjects.type = 'Elective Subject'");
        $clas = mysqli_query($cfg->con,"select classname from classes where id = '$cls'");
        $cl = mysqli_fetch_object($clas)->classname;
        $num_rol = mysqli_num_rows(mysqli_query($cfg->con,"select distinct(stid) from records where cls = '$cls' and acyear = '$ayear' and term = '$term'"));
        $numsb1 = 0;
        $numsb2 = 0;
        $tscore1 =0;
        $tscore2 =0;
        ?>
            <div class="row" style="border-bottom: solid 1px #000; margin-bottom: 10px;">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <img style="margin: 10px;" class="img-responsive" src="objts/<?= $sch->logopath ?>" alt="School Crest" />
                </div>
                <div class="col-lg-10 col-md-10">
                     <center>
                         <u><span style="font-size: 25px; font-weight: bold;"><?= ucwords($sch->schname) ?></span><br/></u>
                <span style="font-size: 15px;"><?= ucwords($sch->schooladdress) ?></span><br/>
                         <strong>Email:</strong>tumusectec@gmail.com <br>

                         <span style="font-size: 22px;">STUDENT'S TERMLY ASSESSMENT REPORT </span><br>

                         <strong>Community:</strong> <?=$stinfo->fhometown;?>, <strong>Tel:</strong> <?=$stinfo->ftel;?><?=$stinfo->mtel ?"/".$stinfo->mtel:""?>
                         <strong>House:</strong> <?=$stinfo->name;?>
                     </center>
                </div>
            </div>
         <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print</button>
            <div style="background-image: url('./img/wmark2.png'); background-repeat: no-repeat !important; background-position: center !important; background-size: cover !important;">
	
        <table class="table table-striped" style=" font-size: 12px;">
            <thead>
                <tr>
                    
                    
                    <th rowspan="2" style="text-align: center;">
                        <img width="120" height="140" src="<?=$stinfo->photo;?>" />
                        
                    </th>
                     <th style="vertical-align: middle;">NAME:</th>
                    <td style="vertical-align: middle;" colspan="3"><?=strtoupper($stinfo->fname).' '. strtoupper($stinfo->lname).' '.strtoupper($stinfo->oname)?></td>
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
                    <th>
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
                <td  colspan="7" style="text-align: center; font-weight: bold; font-style: italic;"><h4>CORE SUBJECTS</h4></td>
                </tr>
                <?php



                $i=1;
                 while ($row = mysqli_fetch_object($rep1)) {
                     $cvsubtotal = (($row->subtotl*$sch->clscore_ratio)/$sch->sba);
                     $cvexam = (($sch->exam_ratio/100)*$row->exam);
                     $totlscore = ($cvsubtotal + $cvexam);
                     $tscore1+= $row->tscore;
                     $numsb1++;
                     ?>
                <tr>
                    <td><?=strtoupper($row->subjdesc);?></td>
                    <td style="text-align: center;"><?=$cvsubtotal;?></td>
                    <td style="text-align: center;"><?=$cvexam;?></td>
                    <td style="text-align: center;"><?=number_format($row->tscore,1);?></td>
                    <td style="text-align: center;"><?=$util->getgrd(number_format($row->tscore,1));?></td>
                    <td style="text-align: center;"><?=$util->getremark(number_format($row->tscore,1));?></td>
                    <td style="text-align: center;"><?=$util->addsufix($util->getpost($row->stid,$row->subjt,$term,$ayear,$cls))?></td>
                    
                </tr>  
              <?php  
              $i++;
        }
        ?> 
                
                 <tr>
                 <td  colspan="7" style="text-align: center; font-weight: bold; font-style: italic;"><h4>ELECTIVE SUBJECTS</h4></td>
                </tr>
                
                     <?php
                $i=1;
                 while ($row2 = mysqli_fetch_object($rep2)) {
                     $cvsubtotal = (($row2->subtotl*$sch->clscore_ratio)/$sch->sba);
                     $cvexam = (($sch->exam_ratio/100)*$row2->exam);
                     $totlscore = ($cvsubtotal + $cvexam);
                     $tscore2+= $row2->tscore;
                     $numsb2++;


                     ?>
             
                <tr>
                    <td><?=strtoupper($row2->subjdesc);?></td>
                    <td style="text-align: center;"><?=$cvsubtotal;?></td>
                    <td style="text-align: center;"><?=$cvexam;?></td>
                    <td style="text-align: center;"><?=$totlscore;?></td>
                    <td style="text-align: center;"><?=$util->getgrd($totlscore);?></td>
                    <td style="text-align: center;"><?=$util->getremark($totlscore);?></td>
                    <td style="text-align: center;"><?=$util->addsufix($util->getpost($row2->stid,$row2->subjt,$term,$ayear,$cls))?></td>
                    
                </tr>  
              <?php  
              $i++;
        }

         $numsb = $numsb1+$numsb2;
         $tscore = $tscore1+$tscore2;
         $avg = ($tscore/$numsb);
        ?> 
                
            </tbody>
            <tfoot>
                
                <tr style="color:red;">
                    <th>Overall Position:</th>
                    <td style="text-align: center;"><?=$util->addsufix($pos);?></td>
                    <th>Overall Average Score:</th>
                    <td colspan="2" style="text-align: center;"><?=number_format($avg,2)?></td>
                    <td style="text-align: center;">SUM OF SCORES</td>
                    <td style="text-align: center;"><?=number_format($tscore,2)?></td>
                </tr>
                
                
                
            </tfoot>
                
                
                
           
        </table>
                </div>
            <div class="row" style="border-top: 1px solid #000; padding-top: 5px;">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding-left: 10px;">
            <?php

            $frmrces = mysqli_query($cfg->con,"select * from frmass where stid = '$stid' and term='$term' and ayear='$ayear'");
            if(mysqli_num_rows($frmrces)<1) {

                ?>
                <br>

                <div class='row' style="font-size: 12px;">
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <strong>ATTENDANCE:........... OUT OF.............</strong>
                    </div>
                </div>
                <br>

                <div class='row' style="font-size: 12px;">
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <strong>CONDUCT:..........................................................................................................................................</strong>

                    </div>
                </div>
                <br>

                <div class='row' style="font-size: 12px;">
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <strong>INTEREST:..........................................................................................................................................</strong>

                    </div>
                </div>

                <br>

                <div class='row' style="font-size: 12px;">
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <strong>FORM MASTER's/MISTRESS'
                            REMARK:...........................................................................................................................................</strong>

                    </div>
                </div>
                <br>
                <div class='row' style="font-size: 12px;">
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <strong>HEAD MATER'S/MISTRESS'
                            SIGNATURE/STAMP:.........................................................................................................................</strong>

                    </div>
                </div>
                <?php

            }else {
                $frmrow = mysqli_fetch_object($frmrces);
                $frmmaster = mysqli_query($cfg->con,"select fname,lname,gender,frmmaters.id from staff,frmmaters where staff.id = frmmaters.stfid and frmmaters.clid = '$cls'");
                $frminfo = mysqli_fetch_object($frmmaster);
                ?>
                <div class='row' style="font-size: 12px;">
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <p><strong>ATTENDANCE:</strong> <?= $frmrow->attnded; ?> OUT OF <?= $frmrow->attdance; ?></p>
                    </div>
                </div>
                <div class='row' style="font-size: 12px;">
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <p><strong>CONDUCT:</strong> <?= $frmrow->cnduct; ?></p>
                    </div>
                </div>

                <div class='row' style="font-size: 12px;">
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <p><strong>INTEREST:</strong> <?= $frmrow->interest; ?></p>


                    </div>
                </div>
                <div class='row' style="font-size: 12px;">
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <p><strong>FORM MASTER's/MISTRESS' REMARK:</strong> <?= $frmrow->remark; ?></p>

                    </div>
                </div>

                <div class='row' style="font-size: 12px;">
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <p>
                            <?php
                            if($frminfo->gender == "Male"){
                                ?>
                                <strong>CURRENT FORM MASTER's INITIALS:</strong> <?= strtoupper(substr($frminfo->fname,0,1)).". ".strtoupper(substr($frminfo->lname,0,1));?>

                                <?php
                            }else{
                                ?>

                                <strong>CURRENT FORM MISTRESS' INITIALS:</strong> <?= substr($frminfo->fname,0,1)." ".substr($frminfo->lname,0,1);?>


                                <?php
                            }

                            ?>
                        </p>
                    </div>
                </div>
                <div class='row' style="font-size: 12px;">
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <p>  <strong>HEAD MASTER'S/MISTRESS'
                                SIGNATURE/STAMP:.........................................................................................................................</strong>

                        </p>
                    </div>
                </div>

                <?php

            }
            $cmnt = mysqli_query($cfg->con,"select * from ginfo WHERE stid = '$stid' and term='$term' and ayear='$ayear' order BY id DESC ");
            if(mysqli_num_rows($cmnt)>0){
            ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size: 13px;">
                <p><strong><u>Achievements/Comments</u></strong></p>
                </div></div>

                <?php
                while($c = mysqli_fetch_object($cmnt)){
                ?>
                <div class="row" >
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <strong>
                            On <?=$c->dentry?>, <?=$c->ayear?> Academic Year, <?=$util->addsufix($c->term)?> Term
                        </strong><br>
                        <?=$c->coment;?>
                    </div>
                </div>
                <?php

            }}

            ?>

</div>

       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">


           <table CLASS="table table-condensed pull-right" style="font-size: 10px; width: 200px; height: 30px; text-align: center">
               <thead>
               <tr>
                   <td colspan="3"><center><strong>GRADING SYSTEM</strong></center></td>
               </tr>
               <tr>
                   <th style="text-align: center;">
                       SCORE
                   </th>
                   <th style="text-align: center;">
                       GRADE
                   </th>
                   <th style="text-align: center;">
                       REMARK
                   </th>
               </tr>
               </thead>
               <tbody>
               <tr>

                   <td>80-100</td>
                   <td>A1</td>
                   <td>EXCELLENT</td>
               </tr>

               <tr>

                   <td>70-79</td>
                   <td>B2</td>
                   <td>VERY GOOD</td>
               </tr>  <tr>

                   <td>60-69</td>
                   <td>B3</td>
                   <td>GOOD</td>
               </tr>  <tr>

                   <td>55-59</td>
                   <td>C4</td>
                   <td>CREDIT</td>
               </tr>  <tr>

                   <td>50-54</td>
                   <td>C5</td>
                   <td>CREDIT</td>
               </tr>
               <tr>

                   <td>45-49</td>
                   <td>C6</td>
                   <td>CREDIT</td>
               </tr>  <tr>

                   <td>40-44</td>
                   <td>D7</td>
                   <td>PASS</td>
               </tr>
               <tr>

                   <td>35-39</td>
                   <td>E8</td>
                   <td>PASS</td>
               </tr>
               <tr>

                   <td>0-34</td>
                   <td>F9</td>
                   <td>FAIL</td>
               </tr>
               </tbody>
           </table>



       </div>
</div>
<div style="page-break-after: always;" class="row">

</div>


            <?php

            $pos++;

        } ?>
            
            <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print</button>
	
        </div>
    </body>
</html>

