<?php

include_once './objts/config.php';
$cf = new config();
$cf->connect();
$dpid = $_GET['depid'];
$dep = mysqli_query($cf->con,"select classname,id from classes where dpid='$dpid'");

while ($row = mysqli_fetch_assoc($dep)) {
    
    ?>

<option value="<?php echo $row['id']; ?>" ><?php echo $row['classname']; ?></option>
    
    
    
 <?php   
    
}
?>

