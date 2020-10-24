<?php
include_once './objts/config.php';
include_once './objts/utitlity.php';
$cnfg = new config();
$cnfg->connect();
$id = $_GET['id'];
$sfid = $_GET['sfid'];
$subinfo = mysqli_fetch_object(mysqli_query($cnfg->con, "select subjects.subjdesc,classes.classname,subas.id,staff.fname,staff.lname from subjects,classes,subas,staff  where subas.stfid ='$sfid' and subas.clid=classes.id and subjects.id=subas.subid and subas.stfid = staff.id and subas.id = '$id'"));
$ut = new utitlity();
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action = "Unassigned $subinfo->subjdesc with class $subinfo->classname from $subinfo->fname $subinfo->lname";
$ut->create_log();
mysqli_query($cnfg->con, "delete from subas where id = '$id'");
$data = mysqli_query($cnfg->con, "select subjects.subjdesc,classes.classname,subas.id from subjects,classes,subas  where subas.stfid ='$sfid' and subas.clid=classes.id and subjects.id=subas.subid");
while ($row = mysqli_fetch_assoc($data)) {
    ?>
    <tr>
        <td>
            <?php
            echo $row['id'];
            ?>
        </td>
        <td>
            <?php
            echo $row['subjdesc'];
            ?>
        </td>
        <td>
            <?php
            echo $row['classname'];
            ?>
        </td>

        <td><span class="glyphicon glyphicon-remove rmsub" title="Unasign this subject" data-del="delsubj.php"
                  data-sfid="<?php echo $id; ?>" data-id="<?php echo $row['id']; ?>"
                  style="color: #F00; cursor: pointer;"></span></td>

    </tr>
    <?php
}

?>
<script>


    $("span").tooltip();

</script>