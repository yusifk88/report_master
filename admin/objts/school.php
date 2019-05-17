<?php

class school
{
    var $schname = "TUMU SENIOR HIGH TECHNICAL SCHOOL";
    var $schooladdress = "P.O. Box 24, TUMU, UPPER WEST REGION, GHANA, WEST AFRICA <br> <strong>DIGITAL ADDRESS:</strong> N/A";
    var $logopath = "crest.jpg";
    var $code = "TSHTSC0";
    var $clscore_ratio = 30;
    var $sba = 100;
    var $exam_ratio = 70;
    var $schoolID = "TUMUSECTEC";
    var $SMSsub = false;
    var $sub_date = '2019-09-10' ;
    function __construct()
    {
    }
    function sub_expired(){
date_default_timezone_set('Africa/Accra');
            $td = date('Y-m-d');
            $tday = strtotime($td);
            $ex = strtotime($this->sub_date);
            $diff =  $ex-$tday;
            $exstatus = false;
            if($tday > $ex){
                $exstatus = true;
            }

        return $exstatus;
    }
    function get_subdays(){

        $today = new DateTime('now');
        $sub = date_create($this->sub_date);
        $diff = date_diff($today,$sub);
        return $diff->days;

    }



}


