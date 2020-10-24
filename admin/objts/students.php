<?php
include_once('utitlity.php');

class Students
{
    var $index;
    var $fname;
    var $oname;
    var $lname;
    var $gender;
    var $house;
    var $dept;
    var $clas;
    var $dob;
    var $lschool;
    var $dor;
    var $ayear;
    var $photo;
    var $ffname;
    var $fhometown;
    var $ftel;
    var $mfname;
    var $mhometown;
    var $mtel;
    var $form;
    var $jhsno;
    var $shsno;
    var $ghouse;
    var $resstatus;

    function __construct()
    {

    }

    //================================================================================================

    /**
     * @return string|void
     * @throws Exception
     * create a new student
     */

    public function createstudent()
    {
        try {

        include_once 'school.php';
        $ut = new utitlity();
        $sch = new school();
        $dbconf = new config();
        $dbconf->connect();
        if ($this->studinfoexist($this->index)) {
            $num = mysqli_query($cnfg->con, "select count(id) from stuinfo");
            $n = mysqli_fetch_object(mysqli_query($cnfg->con, "select max(id) as mx from stuinfo"))->mx;
            $testindex = mysqli_query($cnfg->con, "select stindex from stuinfo");
            $code = $sch->code;
            $index = 0;
            if (!$n || $n < 1) {
                $index = $code . "000001";
            } else {
                $n++;
                while ($row = mysqli_fetch_object($testindex)) {

                    if ($n >= 1 && $n <= 9) {

                        $index = $code . "00000" . $n;
                        if ($index == $row->stindex) {
                            $index = $code . "00000" . $n;
                        }
                    } else if ($n >= 10 && $n <= 99) {
                        $index = $code . "0000" . $n;
                        if ($index == $row->stindex) {
                            // $n++;
                            $index = $code . "0000" . $n;
                        }

                    } else if ($n >= 100 && $n <= 999) {


                        $index = $code . "000" . $n;

                        if ($index == $row->stindex) {
                            // $n++;
                            $index = $code . "000" . $n;

                        }
                    } else if ($n >= 1000 && $n <= 9999) {
                        $index = $code . "00" . $n;
                        if ($index == $row->stindex) {
                            /// $n++;
                            $index = $code . "00" . $n;
                        }
                    } else if ($n >= 10000 && $n <= 99999) {
                        $index = $code . "0" . $n;
                        if ($index == $row->stindex) {
                            // $n++;
                            $index = $code . "0" . $n;
                        }

                    } else {

                        $index = $code . $n;
                        if ($index == $row->stindex) {
                            // $n++;
                            $index = $code . $n;
                        }
                    }
                }
            }
            $this->index = $index;


        }


                $this->photo = 'objts/dpic/photo.jpg';
               $student = mysqli_query($dbconf->con, "insert into stuinfo(stindex,ayear,class,dept,dob,dor,ffname,
                fhometown,fname,ftel,gender,house,lname,lschool,mfname,mhometown,mtel,photo,form,oname,jhsno,shsno,
                ghouse,res_status)
                values('$this->index','$this->ayear','$this->clas','$this->dept','$this->dob','$this->dor',
                '$this->ffname','$this->fhometown','$this->fname','$this->ftel','$this->gender','$this->house',
                '$this->lname','$this->lschool','$this->mfname','$this->mhometown','$this->mtel','$this->photo',
                '$this->form','$this->oname','$this->jhsno','$this->shsno','$this->ghouse','$this->resstatus')");

            session_start();
            $ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
            $ut->action = "Registered a new student ($this->fname $this->lname $this->oname)";
            $ut->create_log();

            return $student;
        return $data;
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }

    }

//================================================================================================

    protected function studinfoexist($index)
    {
        $dbcon = new config();
        $dbcon->connect();
        $chk = mysqli_num_rows(mysqli_query($dbcon->con, "select * from stuinfo where stindex ='$index'"));
        if ($chk > 0) {
            $res = TRUE;
        } else {
            $res = FALSE;
        }
        return $res;

    }


    //================================================================================================

    public function getstudents($id = "", $index = "", $fname = "", $lname = "")
    {
        $dbconf = new config();
        $dbconf->connect();
        if (!$id && !$index && !$fname && !$lname) {
            $data = mysqli_query($dbconf->con, "select * from stuinfo");

        } else {
            $data = mysqli_query($dbconf->con, "select * from stuinfo where stindex = '$index' or fname='$fname' or lname='$lname'
            ");

        }

        return $data;

    }

    //---------------------------------------------------------------------------------------------------
    public function delstudentinfo($id)
    {
        $dbconf = new config();
        $dbconf->connect();
        mysqli_query($dbconf->con, "delete from stuinfo where id = $id");
        $data = "Student deleted successfully";
        return $data;

    }

//---------------------------------------------------------------------------------------------------

    public function update_student($id, $ayear, $clas, $dept, $dob, $dor, $ffname, $fhometown, $fname, $ftel, $gender, $house, $lname, $lschool, $mfname, $mhometown, $mtel, $photo)
    {
        $dbcon = new config();
        $dbcon->connect();

        mysqli_query($dbcon->con, "update stuinfo set ayear='$ayear',clas='$clas',dept='$dept',dob='$dob',dor='$dor',ffname='$ffname',fhometown='$fhometown',fname='$fname',ftel='$ftel',gender='$gender',house='$house',lname='$lname',lschool='$lschool',mfname='$mfname',mhometown='$mhometown',mtel='$mtel',photo='$photo' where id ='$id'");

        $data = "Student updated successfully";
        return $data;
    }

}

