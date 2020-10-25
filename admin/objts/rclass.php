<?php
namespace APP;
require_once (__DIR__.'/vendor/autoload.php');

class Rclass
{


    var $class_name = null;
    //---------------------------------------------------------------------------------------------
    var $depid = null;


//------------------------------------------------------------------------------------------------

    function __construct()
    {
        //parent::__construct();
        include_once("config.php");
    }

    public function createclass()
    {
        $dbcon = new config();
        $dbcon->connect();
        if ($this->class_name == NULL || $this->depid == NULL) {
            $data = "Blank field(s) detected, please complete your entry";
        } elseif ($this->classexist($this->class_name, $this->depid)) {

            $data = "This class was already registered with this department";

        } else {
            mysqli_query($dbcon->con, "insert into classes(classname,dpid) values('$this->class_name','$this->depid')");

            $data = "Class created successfully";
        }
        return $data;

    }

    protected function classexist($classname, $dpid)
    {
        $dbcon = new config();
        $dbcon->connect();
        $chk = mysqli_fetch_object(mysqli_query($dbcon->con, "select count(*) as sm from classes where classname = '$classname' and dpid = '$dpid'"))->sm;
        if ($chk > 0) {
            $res = TRUE;

        } else {
            $res = FALSE;

        }
        return $res;
    }

    //---------------------------------------------------------------------------------------------

    Public function getclasses($classname = NULL, $dep = NULL)
    {

        $dbcon = new config();
        $dbcon->connect();
        if ($classname == NULL) {

            $data = mysqli_query($dbcon->con, "select classes.id,classes.classname,dept.depname, dept.id as dpid from classes,dept where classes.dpid = dept.id order by classname asc");

        } else {

            $data = mysqli_query($dbcon->con, "select classes.id,classes.classname,dept.depname from classes,dept where classes.dpid = dept.id and classname='$classname' or dpid = '$dep'");

        }

        return $data;

    }

    //---------------------------------------------------------------------------------------------
    Public function delclass($id)
    {
        $dbcon = new config();
        $dbcon->connect();
        mysqli_query($dbcon->con, "delete from classes where id = '$id'");
        $data = "Class deleted";
        return $data;
    }

    //---------------------------------------------------------------------------------------------
    public function update_class($id, $classname, $dep)
    {
        $dbcon = new config();
        $dbcon->connect();
        mysqli_query($dbcon->con, "update classes set classname = '$classname',dpid='$dep' where id = '$id'");
        $data = "Class updated";
        return $data;

    }
    //---------------------------------------------------------------------------------------------


}
