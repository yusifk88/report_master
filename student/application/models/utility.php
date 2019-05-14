<?php

/**
 * This class is used to handle that are genearl to application
 * most especially results processing tasks like positioning and remarks
 *
 * @author Katulie yusif
 */
class utility extends CI_Model
{
    /**
     * used to convert scores into remarks
     * @param double $score
     */

    var $host = "localhost";
    var $user = "root";
    var $password = "";
    var $db = "reportdb";
    var $con;
    var $clscore_ratio = 30;
    var $sba = 100;
    var $exam_ratio = 70;

    public function addsufix($i)
    {
        $j = (int)$i % 10;
        $k = (int)$i % 100;
        if ($j == 1 && $k != 11) {
            return $i . "st";
        }
        if ($j == 2 && $k != 12) {
            return $i . "nd";
        }
        if ($j == 3 && $k != 13) {
            return $i . "rd";
        }
        return $i . "th";
    }

    /**
     * @param $id
     * @param $subid
     * @param $term
     * @param $year
     * @param $cls
     * @return int
     * Determins the position of the student buy subject
     */
    public function getpos($id, $subid, $term, $year, $cls)
    {
        $i = 1;
        $cls_ratio = $this->clscore_ratio;
        $sba = $this->sba;
        $exam_ratio = $this->exam_ratio;
        $rec = $this->db->query("select (((subtotl*$cls_ratio)/$sba)+(exam*($exam_ratio/100))) as tscore,stid from records where cls = '$cls' and acyear = '$year' and term = '$term' and records.subjt ='$subid' ORDER BY tscore DESC")->result();
        // $rec = "select (((subtotl*$cls_ratio)/$sba)+(exam*($exam_ratio/100))) as tscore,stid from records where cls = '$cls' and acyear = '$year' and term = '$term' and records.subjt ='$subid' ORDER BY tscore DESC";
//        foreach($rec as $r){
//            $i++;
//
//            if($r->stid == $id){
//                break;
//            }
//        }
//        return $i;

    }

    public function Process_refults_by_id($id)
    {
        $this->connect();
        $ch = new school();
        $res = mysqli_query($this->con, "select subtotl,exam from records where id='$id'");
        $row = mysqli_fetch_assoc($res);
        //$recid=$row['id'];
        $subtotl = $row['subtotl'];
        $exam = $row['exam'];
        $clsratio = $ch->clscore_ratio;
        $examratio = $ch->exam_ratio;
        $exsumcls = $ch->sba;
        $cvclscore = ($subtotl * $clsratio) / $exsumcls;
        $cvexam = ($examratio / 100) * $exam;
        $cvtotlscore = ($cvexam + $cvclscore);
        $grade = $this->getgrd($cvtotlscore);
        $remark = $this->getremark($cvtotlscore);
        mysqli_query($this->con, "update records set cvsubtotl = '$cvclscore',cvexam='$cvexam',totlscore='$cvtotlscore',grd='$grade',remark='$remark' where id = '$id'");

    }

//------------------------------------------------------------

    public function connect()
    {
        $this->con = mysqli_connect($this->host, $this->user, $this->password);
        mysqli_select_db($this->con, $this->db);
    }

    public function getgrd($score)
    {
        $grd = null;
        if (is_numeric($score)) {
            if ($score >= 80 && $score <= 100) {
                $grd = "A1";
            } elseif ($score < 80 && $score >= 70) {
                $grd = "B2";
            } elseif ($score < 70 && $score >= 60) {
                $grd = "B3";
            } elseif ($score < 60 && $score >= 55) {
                $grd = "C4";
            } elseif ($score < 55 && $score >= 50) {
                $grd = "C5";
            } elseif ($score < 50 && $score >= 45) {
                $grd = "C6";
            } elseif ($score < 45 && $score >= 40) {
                $grd = "D7";
            } elseif ($score < 40) {
                $grd = "F9";
            }
        }
        return $grd;

    }


//alternative and short function for processing results

    public function getremark($score)
    {
        $remark = null;
        if (is_numeric($score)) {
            if ($score >= 80 && $score <= 100) {
                $remark = "EXCELLENT";
            } elseif ($score >= 70 && $score < 80) {
                $remark = "VERY GOOD";
            } elseif ($score < 70 && $score >= 60) {
                $remark = "GOOD";
            } elseif ($score < 60 && $score >= 55) {
                $remark = "CREDIT";
            } elseif ($score < 55 && $score >= 50) {
                $remark = "CREDIT";
            } elseif ($score < 50 && $score >= 45) {
                $remark = "CREDIT";
            } elseif ($score < 45 && $score >= 40) {
                $remark = "PASS";
            } elseif ($score < 40) {

                $remark = "FAIL";

            }
        }
        return $remark;
    }

}