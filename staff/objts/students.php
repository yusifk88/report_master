<?php

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

    function __construct()
    {

    }

    //================================================================================================

    public function createstudent()
    {
        $dbconf = new config();
        $dbconf->connect();
        if ($this->studinfoexist($this->index)) {
            echo "index-fales";
            exit();
        }
        if (!$this->index || !$this->ayear || !$this->clas || !$this->dept || !$this->dob || !$this->dor || !$this->ffname || !$this->fhometown || !$this->fname || !$this->ftel || !$this->gender || !$this->house || !$this->lname || !$this->lschool || !$this->mfname || !$this->form || !$this->photo) {
            $data = "blank-true";

        } else {
            $exten = substr($this->photo, -4);

            if (copy('objts/' . $this->photo, 'objts/pass/' . $this->index . $exten)) {

                $newpic = 'objts/pass/' . $this->index . $exten;

                $this->photo != "dpic/photo.jpg" ? unlink('objts/' . $this->photo) : "";
                $this->photo = $newpic;
            } else {
                echo 'pass-false' . $this->photo;
                exit();
            }

            mysqli_query($dbconf->con, "insert into stuinfo(stindex,ayear,class,dept,dob,dor,ffname,fhometown,fname,ftel,gender,house,lname,lschool,mfname,mhometown,mtel,photo,form,oname,jhsno,shsno) values('$this->index','$this->ayear','$this->clas','$this->dept','$this->dob','$this->dor','$this->ffname','$this->fhometown','$this->fname','$this->ftel','$this->gender','$this->house','$this->lname','$this->lschool','$this->mfname','$this->mhometown','$this->mtel','$this->photo','$this->form','$this->oname','$this->jhsno','$this->shsno')");
            $data = "saved";


        }

        return $data;


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

