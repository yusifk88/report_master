<?php
namespace APP;


class Staff
{
    var $fname;
    var $lname;
    var $gender;
    var $contact;
    var $uname;
    var $upass;
    var $rank;
    var $stfid;
    var $dob;
    var $bank;
    var $acno;
    var $regno;
    var $aqual;
    var $pqual;
    var $appdate;
    var $assdate;
    var $bankname;
    var $accno;
    var $ssnid;
    var $id;
    function __construct()
    {

    }

    //=================================================================================================


    /**
     * @return bool
     * validates the properties of the staff before creating a new staff
     */
    public function validate(){

         return ($this->fname && $this->lname && $this->contact && $this->gender && $this->uname && $this->upass);

    }

    /**
     * @return bool
     * create a new staff
     */

    public function create()
    {
        $dbcon = new config();
        $dbcon->connect();


      //$staff = mysqli_query($dbcon->con, "insert into staff(fname,lname,gender,contact,rank,stfid,dob,regno,aqual,pqual,appdate,assdate,bank,accno,snnid,uname,upass,type,status,photo) values('$this->fname','$this->lname','$this->gender','$this->contact','$this->rank','$this->stfid','$this->dob','$this->regno','$this->aqual','$this->pqual','$this->appdate','$this->assdate','$this->bankname','$this->accno','$this->ssnid','$this->uname','$this->upass','staff','active','img/photo.jpg')");
        mysqli_query($dbcon->con,"insert into staff(fname,lname,gender,contact,stfid,dob,regno,aqual,pqual,uname,upass,type,status) values('$this->fname','$this->lname','$this->gender','$this->contact','$this->stfid','$this->dob','$this->regno','$this->aqual','$this->pqual','$this->uname','$this->upass','staff','active')");

            $ut = new utitlity();
            session_start();
            $ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
            $ut->action = "Registered a new staff ($this->fname $this->lname )";
            $ut->create_log();

            if (mysqli_error($dbcon->con)){
                echo mysqli_error($dbcon->con);
            }




    }

    //=================================================================================================

    public function exists()
    {
        $dbcon = new config();
        $dbcon->connect();
        $chk = mysqli_num_rows(mysqli_query($dbcon->con, "select * from staff where uname = '$this->uname'"));
        if ($chk > 0) {
            $res = TRUE;
        } else {
            $res = FALSE;
        }


        return $res;

    }

    //=================================================================================================

    public function getstaff($fname, $lname)
    {

        $dbcon = new config();
        $dbcon->connect();

        $data = mysqli_query($dbcon->con, "select * from staff where type <> 'admin' and (fname LIKE '%$fname%' or lname LIKE '%$lname%') order by fname asc, lname asc");

        return $data;
    }


    //=================================================================================================
    Public function deletestaff($id)
    {
        $dbcon = new config();
        $dbcon->connect();
        $stf = mysqli_fetch_object(mysqli_query($dbcon->con,"select * from staff where id = '$id'"));
        mysqli_query($dbcon->con, "delete from staff where id = " . $id);
        mysqli_query($dbcon->con, "delete from subas where stfid =" . $id);
        mysqli_query($dbcon->con, "delete from frmmaters where stfid =" . $id);
        $data = "Staff deleted";
        $ut = new utitlity();
        session_start();
        $ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
        $ut->action = "Deleted a staff ($stf->fname $stf->lname )";
        $ut->create_log();
        return $data;
    }
    //=================================================================================================
    public function updatestaff()
    {
        $dbcon = new config();
        $dbcon->connect();
        if (!($this->fname && $this->lname && $this->gender && $this->contact)) {
            $data = "Blank field(s) detected, please complete your entry";
        } else {

            mysqli_query($dbcon->con, "update staff set fname='$this->fname',lname='$this->lname',contact='$this->contact',gender='$this->gender',rank = '$this->rank',stfid='$this->stfid',dob='$this->dob',regno='$this->regno',aqual='$this->aqual',pqual='$this->pqual',appdate='$this->appdate',assdate='$this->assdate',bank='$this->bank',accno='$this->acno',snnid='$this->ssnid' where id ='$this->id'");

            $data = "Staff info. updated";
            $ut = new utitlity();
            session_start();
            $ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
            $ut->action = "Edited staff information ($this->fname $this->lname )";
            $ut->create_log();

        }
        return $data;
    }
    //=================================================================================================


}
