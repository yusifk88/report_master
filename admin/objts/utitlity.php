<?php

namespace APP;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * This class is used to handle that are genearl to application
 * most especially results processing tasks like positioning and remarks
 *
 * @author Katulie yusif
 */
class Utitlity
{
    /**
     * used to convert scores into remarks
     * @param double $score
     *
     *
     */
    var $host = "localhost";
    var $user = "root";
    var $password = "password";
    var $db = "reportdb";
    var $con;
    var $uid = 0;
    var $action ='';
    public $key = "null";
    public $message;
    public $numbers;
    public $sender = "MENJISHS";
    private $_endpoint;
    public function __construct()
    {
        $this->_endpoint = 'https://apps.mnotify.net/smsapi';
    }
    public function create_log(){
        $cfig = new config();
        $cfig->connect();
        mysqli_query($cfig->con,"insert into user_log(uid,action) values ('$this->uid','$this->action')");
    }


    public static function set_response($code=200){
        http_response_code($code);
    }

    /**
     * @param string $data
     * @return string
     * escapes mysql string wrapper
     */

    public static function escape($data=""){
        $connection = new config();
        $connection->connect();
        return mysqli_real_escape_string($connection->con,$data);

    }


    public static function response($data,$code=200){



        http_response_code($code);
        echo $data;
    }

    public function sendMessage()
    {
        $url = $this->_endpoint . "?key=" . $this->key . "&to=" . $this->numbers . "&msg=" . $this->message . "&sender_id=" . $this->sender;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
        curl_close($ch);
        return $this->interpret($result);
    }

    private function interpret($code)
    {
        $status = '';
        switch ($code) {
            case '1000':
                $status = 'Messages has been sent successfully';
                return $status;
                break;
            case '1002':
                $status = 'SMS sending failed. Might be due to server error or other reason';
                return $status;
                break;
            case '1003':
                $status = 'Insufficient SMS credit balance';
                return $status;
                break;
            case '1004':
                $status = 'Invalid API Key';
                return $status;
                break;
            case '1005':
                $status = 'Invalid recipient\'s phone number';
                return $status;
                break;
            case '1006':
                $status = 'Invalid sender id. Sender id must not be more than 11 characters. Characters include white space';
                return $status;
                break;
            case '1007':
                $status = 'Message scheduled for later delivery';
                return $status;
                break;
            case '1008':
                $status = 'Empty Message';
                return $status;
                break;
            default:
                return $status;
                break;
        }
    }

    public function position($sub, $cls, $ayear, $term)
    {
        $this->connect();
        $recs = mysqli_query($this->con, "select id from records where term='$term' and cls ='$cls' and acyear='$ayear' and subjt ='$sub' order by totlscore desc");
        $i = 1;
        while ($row = mysqli_fetch_assoc($recs)) {
            $id = $row['id'];
            $pos = $this->addsufix($i);
            mysqli_query($this->con, "update records set post = '$pos' where id = '$id'");
            $i++;
        }

    }

    public function connect()
    {

        $this->con = mysqli_connect($this->host, $this->user, $this->password);
        mysqli_select_db($this->con, $this->db);

    }

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

//public function addsufix($i){
//    $pos = NULL;
//    if(is_numeric($i)){
//       if((($i% 100)>10)&&(($i%100)<20)){
//           $pos = $i."th";
//       }else{
//           if(($i%100)===1){
//               $pos = $i."st";
//
//           }elseif(($i% 100)===2) {
//               $pos = $i."nd";
//                }  elseif(($i%100)===3){
//
//                    $pos = $i."rd";
//
//                } else{
//                        $pos = $i."th";
//
//                }
//       }
//
//    }
//
//    return $pos;
//
//
//}

    public function position_totls($ayear, $term, $cls)
    {
        $this->connect();
        $recs = mysqli_query($this->con, "select id from totls where term='$term' and ayear='$ayear' and cls ='$cls' order by totlscore desc");
        $i = 1;
        while ($row = mysqli_fetch_assoc($recs)) {
            $id = $row['id'];
            $pos = $this->addsufix($i);
            mysqli_query($this->con, "update totls set post = '$pos' where id = '$id'");
            $i++;
        }

    }

//----------------------------------overal position------------

    public function Process_refults($stid, $term, $ayear, $sub, $cls)
    {

        $this->connect();

        $ch = new school();
        $res = mysqli_query($this->con, "select id,subtotl,exam from records where stid='$stid'  and term='$term' and acyear='$ayear' and subjt='$sub' and cls='$cls'");
        $row = mysqli_fetch_assoc($res);
        $id = $row['id'];
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

//    mysqli_query($this->con,"update records set totlscore='$cvtotlscore' where id = '$id'");

    }

//------------------------------------------------------------

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
            } elseif ($score < 40 && $score >= 35) {
                $grd = "E8";
            } else {

                $grd = "F9";
            }
        }
        return $grd;

    }

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
            } elseif ($score < 40 && $score >= 35) {

                $remark = "PASS";

            } else {
                $remark = "FAIL";
            }
        }
        return $remark;
    }

    /**
     * @param $id
     * @param $subid
     * @param $term
     * @param $year
     * @param $cls
     * @return int
     * Determine the position of the student but subject
     */

    function getpost($id, $subid, $term, $year, $cls)
    {
        $i = 0;
        $sch = new school();
        $cf1 = new config();
        $cf1->connect();
        $rec = mysqli_query($cf1->con, "select ((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) as tscore,stid from records where cls = '$cls' and acyear = '$year' and term = '$term' and records.subjt ='$subid' ORDER BY tscore DESC");
        while ($trow = mysqli_fetch_object($rec)) {
            $i++;

            if ($trow->stid == $id) {
                break;

            }

        }

        return $i;

    }

//alternative and short function for processing results
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

//---------------end of utitlity class--------------------------------

    /**
     * @param string $message
     * @param string $title
     * @param string $type
     * display a business card for errors
     */

public static function showError(string $message,string $title="Error",string $type=""){

        $view ="<div class='card card-".$type."'><div class='card-header'>
                    <p class='card-title'> ".$title."</p>
                    </div>
                    <div class='card-body'>
                    ".$message."
                    </div>
                     </div>";

        echo $view;

}


public static function showAssignSubjects(int $id){
    $cf = new config();
    $cf->connect();
    $subjects = mysqli_query($cf->con,"select  subjects.subjdesc as subjectname,classes.classname,subas.clid,subas.stfid,subas.subid,subjects.id,classes.id,subas.id as asid from subjects,classes,subas where subas.stfid='$id' and subas.subid = subjects.id and subas.clid = classes.id");

     if (mysqli_error($cf->con)){
         Utitlity::set_response(mysqli_error($cf->con),500);
     }else{
         $view = "<div class='list-group list-group-flush'>";
         while ($row = mysqli_fetch_object($subjects)){
             $view.="<div class='list-group-item' id='sub_$row->asid'>$row->classname - $row->subjectname <br/> <button onclick='rmsub($id,$row->asid)' class='btn btn-link text-danger'>Remove <i class='fa fa-remove'></i></button></div>";

         }

         $view.="</div>";

         echo $view;


     }

}


}