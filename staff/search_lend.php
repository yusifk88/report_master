<?php
include_once("objts/config.php");
$cf = new config();
$cf->connect();
$stname = $_GET['lendsearch'];
$studs = mysqli_query($cf->con,"select * from stuinfo where fname like'%$stname%' or lname like'%$stname%' or oname like '%$stname%' order BY fname");
while($row = mysqli_fetch_object($studs)){
    ?>
    <div onclick="selectstud(<?=$row->id?>)" class="list-group-item st-item waves-effect waves-light" style="cursor: pointer;">
        <img height="70" width="60" src="../admin/<?=$row->photo?>" alt=""> <?=$row->fname?> <?=$row->lname?> <?=$row->oname?> <br>
        <button onclick="printstud(<?=$row->id; ?>)" class="btn btn-good waves-effect">View Details</button>
    </div>
    <?php
}
?>
<script>


    $("div.st-item").click(function () {

        $(".st-item").removeClass("st-selected");
        $(this).addClass("st-selected");

    });
</script>