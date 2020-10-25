<?php

namespace APP;
require_once (__DIR__.'/vendor/autoload.php');

class Subjects
{

    var $subdescrip = null;
    var $type = null;


    //================================================================================================

    public function createsubjects()
    {
        $dbconf = new config();
        $dbconf->connect();
        if (!$this->subdescrip || !$this->type) {
            $data = "Blank field(s) detected, please complete your entry";

        } else {
            if ($this->subjectexist($this->subdescrip)) {
                $data = "This subject was already registerd";
            } else {
                mysqli_query($dbconf->con, "insert into subjects(subjdesc,type) values('$this->subdescrip','$this->type')");
                $data = "Subject created successfully";
            }

        }

        return $data;


    }

//================================================================================================

    protected function subjectexist($Subdescrip)
    {
        $dbcon = new config();
        $dbcon->connect();
        $chk = mysqli_num_rows(mysqli_query($dbcon->con, "select * from subjects where subjdesc ='$Subdescrip'"));
        if ($chk > 0) {
            $res = TRUE;
        } else {
            $res = FALSE;
        }
        return $res;

    }

//================================================================================================

    public function getsubjects($subdescrip = NULL)
    {
        $dbconf = new config();
        $dbconf->connect();
        if (!$subdescrip) {
            $data = mysqli_query($dbconf->con, "select * from subjects");

        } else {
            $data = mysqli_query($dbconf->con, "select * from subjects where subjdesc = '$subdescrip'");

        }

        return $data;

    }

    //---------------------------------------------------------------------------------------------------
    public function delsubject($id)
    {
        $dbconf = new config();
        $dbconf->connect();
        mysqli_query($dbconf->con, "delete from subjects where id = '$id'");
        $data = "Subject deleted";
        return $data;

    }

//---------------------------------------------------------------------------------------------------

    public function update_subject($id, $subdescrip, $type)
    {
        $dbcon = new config();
        $dbcon->connect();

        mysqli_query($dbcon->con, "update subjects set subjdesc='$subdescrip',type='$type' where id ='$id'");

        $data = "Subject updated";
        return $data;
    }

}
