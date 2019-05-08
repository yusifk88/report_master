<?php
include_once './objts/school.php';
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$form = $_GET['form'];
$term = $_GET['term'];
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
        $frm_list = mysqli_query("select fname,oname,lname,stindex,gender,classes.classname from stuinfo,classes where form = '$form' and ayear = '$ayear' and stuinfo.class = classes.id order by fname ASC ");
        $sch = new school();
        
          

        ?>
            
            <div class="row">
              
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <img  class="img-responsive" src="objts/<?= $sch->logopath ?>" alt="School Crest" />
              
                    
                </div>
                <div class="col-lg-10 col-md-10">
                     <center>
                         <u><span style="font-size: 25px; font-weight: bold;"><?= ucwords($sch->schname) ?></span><br/></u>
                <span style="font-size: 20px;"><?= ucwords($sch->schooladdress) ?></span><br/>
                <span style="font-size: 25px;">LIST OF STUDENTS IN <?="FORM". $form?> </span>
                
                
            </center>
            
                    
                    
                </div>
                
                
            </div>
           
        
        <table class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th style="text-align: center;">
                        S/N
                    </th>
                   
                    <th>
                        FULL NAME
                    </th>
                    <th>
                        GENDER
                    </th>
                    <th>
                        CLASS
                    </th>
                   
                </tr>
            </thead>
            <tbody>
                <?php
                $i=1;
                 while ($row = mysqli_fetch_object($frm_list)) {
            
             ?>
             
                <tr>
                    <td style="text-align: center;"><?=$i;?></td>
               
                    <td><?=$row->fname.' '.$row->lname.' '.$row->oname;?></td>
                    <td><?=$row->gender;?></td>
                    <td><?=$row->classname;?></td>
                                       
                </tr>  
              <?php  
              $i++;
        }
        ?> 
                
            </tbody>
                
                
                
           
        </table>
       
            <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print</button>
	
        </div>
    </body>
</html>
