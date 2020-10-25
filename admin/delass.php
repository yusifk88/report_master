<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\configl;
use APP\Utitlity;

$cf = new config();
$cf->connect();
$util = new Utitlity();
$id = $_GET['id'];
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$cls = $_GET['cls'];
$sub = $_GET['subjt'];
$oldrecs = mysqli_query($cf->con, "select stid,subtotl,exam from records where id ='$id'");
$oldrecrow = mysqli_fetch_object($oldrecs);
$stid = $oldrecrow->stid;
$oldsubtotl = $oldrecrow->subtotl;
$oldexam = $oldrecrow->exam;
$oldtotls = ($oldexam + $oldsubtotl);
mysqli_query($cf->con, "delete from records where id = " . $id);
//$util->position($sub, $cls, $ayear, $term);
//$util->position_totls($ayear, $term, $cls);
