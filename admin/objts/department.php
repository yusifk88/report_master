<?php
namespace APP;


class Department
{
//    function __construct() {
//        parent::__construct();
//        }
    var $data = null;
    var $depname = null;
    var $entrydate = null;

//----------------------------------------------------------------------------------

    function createdept()
    {
        $dbcon = new config();
        $dbcon->connect();
        if ($this->depname === NULL || $this->entrydate === NULL) {
            $this->data = "blank field detected, please check and try again";
        } elseif ($this->depexist($this->depname)) {
            $this->data = "This department was alredy entered";

        } else {
            mysqli_query($dbcon->con, "insert into dept(depname,dentry) values('$this->depname','$this->entrydate')");
            $this->data = "Department registered successfully";

        }
        return $this->data;

    }

//----------------------------------------------------------------------------------

    protected function depexist($deptname)
    {
        $dbcon = new config();
        $dbcon->connect();
        $chk = mysqli_fetch_object(mysqli_query($dbcon->con, "select count(*) as sm from dept where depname = '$deptname'"))->sm;
        if ($chk > 0) {
            $res = TRUE;

        } else {
            $res = FALSE;

        }


        return $res;

    }

//----------------------------------------------------------------------------------

    public function getdpts($dptname = NULL)
    {
        $dbcon = new config();
        $dbcon->connect();

        if ($dptname == NULL) {

            $this->data = mysqli_query($dbcon->con, "select * from dept");
        } else {


            $this->data = mysqli_query($dbcon->con, "select * from dept where depname = $dptname");

        }
        return $this->data;

    }

//----------------------------------------------------------------------------------
    public function delpdpts($id)
    {
        $dbcon = new config();
        $dbcon->connect();

        mysqli_query($dbcon->con, "delete from dept where id = '$id'");
        $data = "Department deleted";
        return $data;
    }

    //----------------------------------------------------------------------------------
    public function updatedept($id, $dptname)
    {
        $dbcon = new config();
        $dbcon->connect();
        mysqli_query($dbcon->con, "update dept set depname = '$dptname' where id = '$id'");
        $data = "Department updated successfully";
        return $data;
    }
//----------------------------------------------------------------------------------

}
