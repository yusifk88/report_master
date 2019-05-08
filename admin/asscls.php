<?php
/**
 * Created by PhpStorm.
 * User: Godson
 * Date: 5/29/2017
 * Time: 2:16 AM
 */

include_once "objts/config.php";
$cf = new config();
$cf->connect();

$ayears = mysqli_query($cf->con,"select id,classname from classes");

while($row=mysqli_fetch_object($ayears)){
    ?>
    <option value="<?=$row->id?>"><?=$row->classname?></option>

    <?php
}