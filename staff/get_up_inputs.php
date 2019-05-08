<?php
include_once './objts/config.php';
$cnn = new config();
$cnn->connect();
$id = $_GET['id'];
$query = mysqli_query($cnn->con,"select * from staff where id = '$id'");
while ($row = mysqli_fetch_assoc($query)) {
    $ranklist = ["Senior Sup't","Prin. Sup't","Assist. Dir ii","Assist. Dir I","Dep. Dir.", "Dir. II","Dir. I"];

    ?>
    
<form>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm12 col-xs-12">
        <label class="control-label">First Name</label>
        <input class="form-control" id="upfname"  type="text" value="<?php echo "$row[fname]";?>" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm12 col-xs-12">

        <label class="control-label">Last Name</label>
        <input class="form-control" id="uplname" type="text" value="<?php echo "$row[lname]";?>" />
        </div>
        </div>
        <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <label class="control-label">Gender</label>
        <select class="form-control" id="upgender">
            <?php
        if($row['gender']==="Male"){
            ?>
        <option>Male</option>
        
        <option>Female</option>
        
        
        <?php    
        }else{
            
            ?>
        
           <option>Female</option>
                <option>Male</option>       
     
            
            <?php
        }
        
        
        ?>
        
    </select>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label class="control-label">Contact</label>
            <input type="text" class="form-control" value="<?php echo $row['contact'];?>" id="upcontact" />
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label class="control-label">Rank</label>

                <select id="uprank" class="form-control">

                    <?php

                    for($i=0;$i<count($ranklist);$i++){

                     ?>
                        <option <?= ($i==$row['rank'])? "Selected" : ""?> value="<?=$i?>"><?=$ranklist[$i]?></option>

                       <?php
                    }
                    ?>


                </select>


            </div>


        </div>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <label class="control-label">Staff ID No.</label>
            <input id="upstfid" type="text" class="form-control" placeholder="Enter staff ID" value="<?=$row['stfid'];?>" />
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <label class="control-label">D.O.B</label>
            <input id="updob" type="date" class="form-control" placeholder="Enter Date Of Birth" value="<?=$row['dob'];?>" />
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <label class="control-label">Registered No.</label>
            <input id="upregno" type="text" class="form-control" placeholder="Enter Registered Number" value="<?=$row['regno'];?>" />
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <label class="control-label">SSNIT NO.</label>
            <input id="upssnid" type="text" class="form-control" placeholder="Enter SSNIT Number" value="<?=$row['snnid'];?>" />
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label class="control-label">Academic Qualification</label>
            <input id="upaqual" type="text" class="form-control" placeholder="Enter qualification" value="<?=$row['aqual'];?>" />
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label class="control-label">Professional Qualification</label>
            <input id="uppqual" type="text" class="form-control" placeholder="Enter Qualification" value="<?=$row['pqual'];?>" />
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label class="control-label">Date Of First Appointment</label>
            <input id="upappdate" type="date" class="form-control" placeholder="Enter Date" value="<?=$row['appdate'];?>" />
        </div>

        </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label class="control-label">Assumption Of Duty(Date)</label>
            <input id="upassdate" type="date" class="form-control" placeholder="Enter Date" value="<?=$row['assdate'];?>" />
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label class="control-label">Associated Bank</label>
            <input id="upbank" type="text" class="form-control" placeholder="Enter Bank Name" value="<?=$row['bank'];?>" />
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label class="control-label">Account Number</label>
            <input id="upaccno" type="text" class="form-control" placeholder="Enter Registered Number" value="<?=$row['accno'];?>" />
        </div>
    </div>

</form>    
    
    <?php
}
