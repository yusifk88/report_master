<?php
include_once("objts/config.php");
$cf = new config();
$cf->connect();
mysqli_query($cf->con,"update waec set grade_val = 1 WHERE grade = 'A1'");
mysqli_query($cf->con,"update waec set grade_val = 2 WHERE grade = 'B2'");
mysqli_query($cf->con,"update waec set grade_val = 3 WHERE grade = 'B3'");
mysqli_query($cf->con,"update waec set grade_val = 4 WHERE grade = 'C4'");
mysqli_query($cf->con,"update waec set grade_val = 5 WHERE grade = 'C5'");
mysqli_query($cf->con,"update waec set grade_val = 6 WHERE grade = 'C6'");
mysqli_query($cf->con,"update waec set grade_val = 7 WHERE grade = 'D7'");
mysqli_query($cf->con,"update waec set grade_val = 8 WHERE grade = 'E8'");
mysqli_query($cf->con,"update waec set grade_val = 9 WHERE grade = 'F9'");
mysqli_query($cf->con,"update waec set grade_val = 9 WHERE grade = 'F9'");
mysqli_query($cf->con,"update waec set grade_val = 9 WHERE grade = 'CNL'");
mysqli_query($cf->con,"update waec set grade_val = 0 WHERE grade = 'WH'");
echo("<h2>Your WAEC records were successfully corrected</h2>");