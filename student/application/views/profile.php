<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="<?=base_url()?>assets/css/bootstrap-print.css" rel="stylesheet" type="text/css"/>
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
<div class="container">

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <img style="margin: 10px;" class="img-responsive" src="<?=str_replace("student/","",base_url())?>admin/objts/<?= $crest ?>" alt="School Crest" />



            </div>
            <div class="col-lg-10 col-md-10">
                <center>
                    <u><span style="font-size: 25px; font-weight: bold;"><?= ucwords($schname) ?></span><br/></u>
                    <span style="font-size: 20px;"><?= ucwords($address) ?></span><br/>
                    <span style="font-size: 25px;">STUDENT'S PROFILE</span>


                </center>



            </div>


        </div>


        <table class="table table-striped">
            <tr>
                <td  rowspan="6" style="text-align: center;">

                    <img width="180" height="200" src="<?=str_replace("student/","",base_url())?>admin/<?=$myinfo->photo;?>" />

                </td>
            </tr>
            <tr>
                <th>FULL NAME:</th> <td colspan="3"><?= strtoupper($myinfo->fname.' '.$myinfo->lname.' '.$myinfo->oname)?></td>
                <th>REG. DATE:</th> <td colspan="2"><?= $myinfo->dor?></td>

            </tr>
            <tr>
                <th>ID NUMBER:</th> <td><?= $myinfo->stindex; ?></td>
                <th>GENDER:</th> <td><?= strtoupper($myinfo->gender); ?></td>
                <th>D.O.B:</th> <td><?=$myinfo->dob; ?></td>

            </tr>
            <tr>
                <th>PROGRAME:</th> <td colspan="3"><?=strtoupper($myinfo->depname);?></td>
                <th>YEAR</th> <td colspan="2"><?= $myinfo->ayear;?></td>
            </tr>

            <tr>
                <th>FORM:</th> <td><?= "FORM".$myinfo->form; ?></td>
                <th>LAST SCH:</th> <td colspan="3"><?=strtoupper($myinfo->lschool); ?></td>

            </tr>
            <tr>
                <th>CLASS:</th> <td><?= strtoupper($myinfo->classname); ?></td>
                <th>HOUSE:</th> <td colspan="3"><?=strtoupper($myinfo->name);?> (<?=strtoupper($myinfo->des)?>)</td>

            </tr>
            <tr>
                <th>JHS NUMBER:</th> <td colspan="2" ><?= $myinfo->jhsno; ?></td>
                <th>SHS NUMBER:</th> <td colspan="3" ><?= $myinfo->shsno; ?></td>

            </tr>
            <tr>
                <th>FARTHER'S NAME:</th> <td colspan="6" ><?= strtoupper($myinfo->ffname); ?></td>

            </tr>


            <tr>
                <th>FARTHER'S HOMETOWN:</th> <td colspan="6" ><?= strtoupper($myinfo->fhometown); ?></td>

            </tr>
            <tr>
                <th>FARTHER'S CONTACT NO.:</th> <td colspan="6" ><?= $myinfo->ftel; ?></td>

            </tr>

            <tr>
                <th>MOTHER'S NAME:</th> <td colspan="6" ><?= strtoupper($myinfo->mfname); ?></td>

            </tr>
            <tr>
                <th>MOTHER'S HOMETOWN:</th> <td colspan="6" ><?= strtoupper($myinfo->mhometown); ?></td>

            </tr>
            <tr>
                <th>MOTHER'S CONTACT NO.:</th> <td colspan="6" ><?= $myinfo->mtel; ?></td>

            </tr>





        </table>
        <?php


   foreach($cmnt as $c){
        ?>
        <div class="row" style="border-bottom: solid 1px #000;">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <strong>
                    On <?=$c->dentry?>, <?=$c->ayear?> Academic Year, <?=$this->utility->addsufix($c->term)?> Term
                </strong><br>
                <?=$c->coment;?>

            </div>
        </div>
        <?php
    }
    ?>



    <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print</button>

</div>
</body>
</html>
