<?php
namespace APP;
class House
{
    var $house_name;
    var $house_des;
    var $housetype;

    function __construct()
    {
    }

    public function createhouse()
    {
        $dbconf = new config();
        $dbconf->connect();
        if (!$this->house_des || !$this->house_name) {
            $data = "Blank field(s) detected, please complete your entry";
        } else {
            if ($this->houseexist($this->house_name)) {
                $data = "This house was already registerd";
            } else {
                mysqli_query($dbconf->con, "insert into houses(name,des,house_type) values('$this->house_name','$this->house_des','$this->housetype')");
                $data = "house created successfully";
            }
        }
        return $data;
    }

//-----------------------------------------------------------------------------------------------

    protected function houseexist($housename)
    {
        $dbcon = new config();
        $dbcon->connect();
        $chk = mysqli_num_rows(mysqli_query($dbcon->con, "select * from houses where name ='$housename'"));
        if ($chk > 0) {
            $res = TRUE;
        } else {
            $res = FALSE;
        }
        return $res;
    }

    //================================================================================================

    public function gethouses($house_name = null, $house_dst = NULL)
    {
        $dbconf = new config();
        $dbconf->connect();
        if (!$house_dst && !$house_name) {
            $data = mysqli_query($dbconf->con, "select * from houses where house_type = 'genhouse'");

        } else {
            $data = mysqli_query($dbconf->con, "select * from houses where name = '$house_name' and des = '$house_dst' and house_type = 'genhouse'");

        }

        return $data;

    }

    //---------------------------------------------------------------------------------------------------
    public function delhouse($id)
    {
        $dbconf = new config();
        $dbconf->connect();
        mysqli_query($dbconf->con, "delete from houses where id = '$id'");
        $data = "House deleted";
        return $data;


    }

//---------------------------------------------------------------------------------------------------

    public function update_houses($id, $house_name, $house_des, $house_type)
    {
        $dbcon = new config();
        $dbcon->connect();

        mysqli_query($dbcon->con, "update houses set name='$house_name',des='$house_des',house_type='$house_type' where id ='$id'");

        $data = "House updated";
        return $data;
    }

    //--------------------------------------------------------------------------------------------------


}
