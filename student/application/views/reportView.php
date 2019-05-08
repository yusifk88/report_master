<html>
<head>
    <meta charset="UTF-8">
    <link href="<?=base_url()?>assets/css/bootstrap-print.css" rel="stylesheet" type="text/css"/>
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
    <div class="row" style="border-bottom: solid 1px #000; margin-bottom: 10px;">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <img style="margin: 10px;" class="img-responsive" src="<?=str_replace("student/","",base_url())?>admin/objts/<?= $crest ?>" alt="School Crest" />
        </div>
        <div class="col-lg-10 col-md-10">
            <center>
                <u><span style="font-size: 25px; font-weight: bold;"><?= ucwords($schname) ?></span><br/></u>
                <span style="font-size: 13px;"><?= ucwords($schaddress) ?></span><br/>
                <strong>Email:</strong>tumusectec@gmail.com <br>
                <span style="font-size: 20px;">STUDENT'S TERMLY ASSESSMENT REPORT </span> <br>
                <strong>Community:</strong> <?=$info->fhometown;?>, <stronng>Tel:</stronng> <?=$info->ftel;?><?=$info->mtel ?"/".$info->mtel:""?>,
                <strong>House:</strong> <?=$info->name;?>
            </center>
        </div>
    </div>
    <table class="table table-striped table-condensed" style=" font-size: 12px; background-image:  url('./img/wmark2.png'); background-repeat: no-repeat; background-position: center; background-size: contain; background-color: transparent !important;">
        <thead>
        <tr>
            <th rowspan="2" style="text-align: center;">
                <img width="120" height="140" src="<?=str_replace("student/","",base_url())?>admin/<?=$info->photo;?>" />
            </th>
            <th style="vertical-align: middle;">NAME:</th>
            <td style="vertical-align: middle;" colspan="3"><?=strtoupper($info->fname).' '.strtoupper($info->lname).' '.strtoupper($info->oname)?></td>
            <th style="vertical-align: middle;">No. Roll:</th><td style="vertical-align: middle; text-align: center;"><?= $num_rol?></td>
        </tr>
        <tr>
            <th style="vertical-align: middle;">Class:</th>
            <td style="vertical-align: middle;"><?=$myclas->classname;?></td>
            <th style="vertical-align: middle;">Academic Year:</th>
            <td style="vertical-align: middle;"><?=$ayear;?></td>
            <th style="vertical-align: middle;">Term:</th>
            <td  style="vertical-align: middle;"><?= $this->utility->addsufix($term).' Term';?></td>
        </tr>
        <tr>
            <th>
                SUBJECT
            </th>
            <th style="text-align: center;">
                SBA(<?=$this->school->clscore_ratio.'%';?>)
            </th>
            <th style="text-align: center;">
                EXAM(<?=$this->school->exam_ratio.'%';?>)
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
            <td class="text-muted" colspan="7" style="text-align: center; font-weight: bold; font-style: italic;"><h5>CORE SUBJECTS</h5></td>
        </tr>
        <?php
        $i=1;
        $tscore1=0;
        $numsb1=0;
        $tscore2=0;
        $numsb2=0;
       foreach($rep1 as $r){
            $cvsubtotal = (($this->school->clscore_ratio/$this->school->sba)*$r->subtotl);
            $cvexam = (($this->school->exam_ratio/100)*$r->exam);
            $totlscore = ($cvsubtotal + $cvexam);
            $tscore1+= $r->tscore;
            $numsb1++;
           $subpost=0;
           $pos = $this->db->query("select (((subtotl*$cls_ratio)/$sba)+(exam*($exam_ratio/100))) as tscore,stid from records where cls = '$myclas->id' and acyear = '$ayear' and term = '1' and records.subjt ='$r->subjt' ORDER BY tscore DESC")->result();
           foreach($pos as $p){
               $subpost++;
               if($p->stid == $id){

                   break;
               }
           }
            ?>
            <tr>
                <td><?=strtoupper($r->subjdesc);?></td>
                <td style="text-align: center;"><?=$cvsubtotal;?></td>
                <td style="text-align: center;"><?=$cvexam;?></td>
                <td style="text-align: center;"><?=number_format($r->tscore,1);?></td>
                <td style="text-align: center;"><?=$this->utility->getgrd(number_format($r->tscore,1));?></td>
                <td style="text-align: center;"><?=$this->utility->getremark(number_format($r->tscore,1));?></td>
                <td style="text-align: center;"><?=$this->utility->addsufix($subpost)?></td>
            </tr>
            <?php
            $i++;
        }
        ?>
        <tr>
            <td class="text-muted" colspan="7" style="text-align: center; font-weight: bold; font-style: italic;"><h4>ELECTIVE SUBJECTS</h4></td>
        </tr>
        <?php
        $i=1;
        foreach($rep2 as $r2){
            $cvsubtotal = (($this->school->clscore_ratio/$this->school->sba)*$r2->subtotl);
            $cvexam = (($this->school->exam_ratio/100)*$r2->exam);
            $totlscore = ($cvsubtotal + $cvexam);
            $tscore2+= $r2->tscore;
            $numsb2++;
            $subpost2=0;
            $pos2 = $this->db->query("select (((subtotl*$cls_ratio)/$sba)+(exam*($exam_ratio/100))) as tscore,stid from records where cls = '$myclas->id' and acyear = '$ayear' and term = '1' and records.subjt ='$r2->subjt' ORDER BY tscore DESC")->result();
            foreach($pos2 as $p){
                $subpost2++;
                if($p->stid == $id){
                    break;
                }
            }
            ?>
            <tr>
                <td><?=strtoupper($r2->subjdesc);?></td>
                <td style="text-align: center;"><?=$cvsubtotal;?></td>
                <td style="text-align: center;"><?=$cvexam;?></td>
                <td style="text-align: center;"><?=number_format($r2->tscore,1);?></td>
                <td style="text-align: center;"><?=$this->utility->getgrd(number_format($r2->tscore,1));?></td>
                <td style="text-align: center;"><?=$this->utility->getremark(number_format($r2->tscore,1));?></td>
                <td style="text-align: center;"><?=$this->utility->addsufix($subpost2)?></td>
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
            <td style="text-align: center;"><?php
                $stids = $this->db->query("SELECT id as stid,(SELECT SUM((subtotl*$cls_ratio)/$sba+(exam*($exam_ratio/100))) FROM records WHERE stid = stuinfo.id and acyear='$ayear' and term='$term') as sm from stuinfo WHERE id in(SELECT DISTINCT(stid) from records where acyear = '$ayear' and term = '$term' and cls = '$myclas->id') and id not in(select stid from withdraw) ORDER by sm DESC")->result();
                $pos=1;
                foreach($stids as $st){
                    if($st->stid === $id){
                        echo($this->utility->addsufix($pos));
                    }
                    $pos++;
                }
                ?>
            </td>
            <th>Overall Average Score:</th>
            <td style="text-align: center;"><?= number_format($avg,2);?></td>
            <td style="text-align: center;">SUM OF SCORES</td>
            <td style="text-align: center;"><?= number_format($tscore,2);?></td>
        </tr>
        </tfoot>
    </table>
    <div class="row" style="border-top: 1px solid #000; padding-top: 5px;">
        <div  class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?php
            $frmrces = $this->db->query("select * from frmass where stid = '$id' and term='$term' and ayear='$ayear'")->result();
            if(count($frmrces)<1) {
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
                $frmrow = $frmrces[0];
                $frmmaster = $this->db->query("select fname,lname,gender from staff,frmmaters where staff.id = frmmaters.stfid and frmmaters.clid = '$frmrow->cls'");
                $frminfo = $frmmaster->result()[0];
                ?>
                <br>
                <div class='row'>
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' style="font-size: 12px;">
                        <p><strong>ATTENDANCE:</strong> <?= $frmrow->attnded; ?> OUT OF <?= $frmrow->attdance; ?></p>
                    </div>
                </div>
                <br>
                <div class='row'>
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' style="font-size: 12px;">
                        <p><strong>CONDUCT:</strong> <?= $frmrow->cnduct; ?></p>
                    </div>
                </div>
                <br>
                <div class='row' style="font-size: 12px;">
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <p><strong>INTEREST:</strong> <?= $frmrow->interest; ?></p>
                    </div>
                </div>
                <br>
                <div class='row' style="font-size: 12px;">
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <p><strong>FORM MASTER'S/MISTRESS' REMARK:</strong> <?= $frmrow->remark; ?></p>

                    </div>
                </div>
                <br>
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
                <br>
                <div class='row' style="font-size: 12px;">
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <p>  <strong>HEADMASTER'S/HEADMISTRESS'
                                SIGNATURE/STAMP:.............................................................................................</strong>

                        </p>
                    </div>
                </div>
                <?php
            }
            $cmnt = $this->db->query("select * from ginfo WHERE stid = '$id' and term='$term' and ayear='$ayear' order BY id DESC ")->result();
            if(count($cmnt)>0) {
                ?>
                <p><strong><h4><u>Achievements/Comments</u></h4></strong></p>
                <?php
               foreach($cmnt as $c){
                    ?>
                    <div class="row" style="border-bottom: solid 1px #000;">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <strong>
                                On <?= $c->dentry ?>, <?= $c->ayear ?> Academic Year, <?= $this->utility->addsufix($c->term) ?>
                                Term
                            </strong><br>
                            <?= $c->coment; ?>
                        </div>
                    </div>

                    <?php

                }
            }
            ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <table CLASS="table table-condensed pull-right" style="font-size: 10px; width: 250px; height: 50px; text-align: center">
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

    <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print</button>
</div>
</body>
</html>

