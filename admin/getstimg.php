<?php
/**
 * Created by PhpStorm.
 * User: Godson
 * Date: 10/18/2017
 * Time: 2:58 PM
 */
include_once("objts/config.php");
$cfg = new config();
$cfg->connect();
$id = $_GET["id"];
$stud = mysqli_fetch_object(mysqli_query("select photo,fname from stuinfo where id = $id"));
?>

<img style="max-height: 170px; border-radius: 0 !important; " alt="<?=$stud->fname?>"
     src="<?= $stud->photo?>" class="img-thumbnail img-responsive"/>