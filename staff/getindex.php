<?php
include_once './objts/config.php';
include_once './objts/school.php';
$sch = new school();
$code = $sch->code;
$cnfg = new config();
$cnfg->connect();
$num = mysqli_query("select count(id) from stuinfo");
$testindex = mysqli_query("select stindex from stuinfo");
$n = mysql_result($num, 0);
$index = 0;
if ($n < 1) {
    $index = $code . "0001";
} else {
    while ($row = mysqli_fetch_object($testindex)) {
        if ($n >= 1 && $n <= 9) {
            $n++;
            $index = $code . "000" . $n;
            if ($index === $row->stindex) {
                $n++;
                $index = $code . "000" . $n;
            }
        } else if ($n >= 10 && $n <= 99) {
            $n++;
            $index = $code . "00" . $n;
            if ($index === $row->stindex) {
                $n++;
                $index = $code . "00" . $n;
            }

        } else if ($n >= 100 && $n <= 999) {
            $n++;

            $index = $code . "0" . $n;

            if ($index === $row->stindex) {
                $n++;
                $index = $code . "0" . $n;

            }
        } else {
            $n++;

            $index = $code . $n;
            if ($index === $row->stindex) {
                $n++;
                $index = $code . $n;

            }
        }
    }
}

//$index = $code."0001";
echo $index;



