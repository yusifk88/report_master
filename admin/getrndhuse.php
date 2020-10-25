<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
$cfg = new config();
$cfg->connect();
$hse_array = array();
$hseids = mysqli_query($cfg->con, "select id,name from houses where house_type = 'genhouse'");
while ($row = mysqli_fetch_assoc($hseids)) {
    $hse_array[] = $row;
}
$lim = count($hse_array);
$rndid = $hse_array[rand(0, $lim - 1)];
//$hsename = mysql_result(mysqli_query("select name from houses WHERE id = '$rndid'"),0);
header("content-type:application/json");
echo json_encode($rndid);

