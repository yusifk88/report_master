<?php
include_once './objts/config.php';
include_once './objts/school.php';
$sch = new school();
$code = $sch->code;
$cnfg = new config();
$cnfg->connect();
$num = mysqli_query($cnfg->con, "select count(id) from stuinfo");
$n = mysqli_fetch_object(mysqli_query($cnfg->con, "select max(id) as mx from stuinfo"))->mx;
$testindex = mysqli_query($cnfg->con, "select stindex from stuinfo");
//$n = mysql_result($num,0);
$index = 0;
if (!$n || $n < 1) {
    $index = $code . "000001";
} else {
    $n++;
    while ($row = mysqli_fetch_object($testindex)) {

        if ($n >= 1 && $n <= 9) {

            $index = $code . "00000" . $n;
            if ($index == $row->stindex) {
                $index = $code . "00000" . $n;
            }
        } else if ($n >= 10 && $n <= 99) {
            $index = $code . "0000" . $n;
            if ($index == $row->stindex) {
                // $n++;
                $index = $code . "0000" . $n;
            }

        } else if ($n >= 100 && $n <= 999) {


            $index = $code . "000" . $n;

            if ($index == $row->stindex) {
                // $n++;
                $index = $code . "000" . $n;

            }
        } else if ($n >= 1000 && $n <= 9999) {
            $index = $code . "00" . $n;
            if ($index == $row->stindex) {
                /// $n++;
                $index = $code . "00" . $n;
            }
        } else if ($n >= 10000 && $n <= 99999) {
            $index = $code . "0" . $n;
            if ($index == $row->stindex) {
                // $n++;
                $index = $code . "0" . $n;
            }

        } else {

            $index = $code . $n;
            if ($index == $row->stindex) {
                // $n++;
                $index = $code . $n;
            }


        }
    }
}
//$index = $code."0001";
echo $index;



