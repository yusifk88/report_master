<?php
include("check_session.php");

include_once './objts/school.php';
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
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
        <div class="container">
            
            
            
        <?php
        $cfg = new config();
        $cfg->connect();
        $cls_list = mysqli_query($cf->con,"select fname,oname,lname,stindex,gender from stuinfo where class = '$cls' and ayear = '$ayear' and id not in (SELECT stid from withdraw) order by fname ASC ");
        $sch = new school();
        $clas = mysqli_query($cf->con,"select classname from classes where id = '$cls'");
        $cl = mysqli_fetch_object($clas)->classname;
          

        ?>
            
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <img style="margin: 10px;"  class="img-responsive" src="objts/<?= $sch->logopath ?>" alt="School Crest" />
              
                    
                </div>
                <div class="col-lg-10 col-md-10">
                     <center>
                         <u><span style="font-size: 25px; font-weight: bold;"><?= ucwords($sch->schname) ?></span><br/></u>
                         <span style="font-size: 15px;"><?= strtoupper($sch->schooladdress) ?></span><br/>
                <span style="font-size: 20px;">LIST OF STUDENTS IN <?= strtoupper($cl)." (". $ayear .")";?> </span>
                
                
            </center>
            
                    
                    
                </div>
                
                
            </div>
           
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="text-align: center;">

                            S/N


                    </th>
                    <th><center>
                            ID No.
                        </center>

                    </th>
                    <th>
                        FULL NAME
                    </th>
                    <th>
                        <center>
                            GENDER
                        </center>

                    </th>
                    <th>
                        <center>
                            Remark/Sign.
                        </center>

                    </th>
                  
                </tr>
                
                
                
            </thead>
            <tbody>
                <?php
                $i=0;
                $males =0;
                $female =0;
                 while ($row = mysqli_fetch_object($cls_list)) {
                     $row->gender == 'Male' ? $males++ : $female++;
                     $i++;
                     ?>
             
                <tr>
                    <td style="text-align: center;"><?=$i;?></td>
                    <td><center><?=$row->stindex;?></center></td>
                    <td><?=$row->fname.' '.$row->lname.' '.$row->oname;?></td>
                    <td><center><?=$row->gender;?></center></td>
                    <td></td>
                    
                    
                </tr>  
              <?php  

        }
        ?> 
                
            </tbody>
                
                
                
           
        </table>
            <div class="row" style="border-top: 1px solid #000;">
                <h4><strong>SUMMARY</strong></h4>

               <p><strong>Total Number:</strong> <?=$i;?></p>
                <p><strong>Number Of Girls:</strong> <?=$female;?></p>
                <p><strong>Number Of Boys:</strong> <?=$males;?></p>




            </div>
       
            <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print</button>
	
        </div>
    </body>
</html>
