<?php
include_once './objts/config.php';
$cf = new config();
$cf->connect();
$stfid = $_GET['id'];
$staff = mysqli_fetch_object(mysqli_query($cf->con,"select * from staff where id = '$stfid'"));
$status = mysqli_query($cf->con,"select * from librian where stfid = '$stfid'");
?>
<div class="row" style="border-bottom: 1px solid #ccc;">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <img src="<?=($staff->photo)?$staff->photo:'objts/dpic/photo.jpg'?>" class="img-responsive img-thumbnail img-rounded" alt="">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <h5><?=strtoupper($staff->fname." ".$staff->lname)?></h5>
        <?php
        if(mysqli_num_rows($status)<1){
            ?>
            <button onclick="mklibrian(<?=$stfid?>)" type="button" class="btn bg-info">Assign Duty</button>
            <?php
        }else{

            ?>
            <div class="alert alert-info">This staff is already the Librarian of the school.</div>
            <button onclick="rmlibrian(<?=$stfid?>)" type="button" class="btn btn-danger waves-effect waves-light">Unassign Duty</button>
            <?php
        }
        ?>

    </div>
</div>
