<?php

/**
 * Created by PhpStorm.
 * User: Godson
 * Date: 2/8/2018
 * Time: 9:01 PM
 */

        include_once("../objts/config.php");
        $cf = new config();
        $cf->connect();
        $stlist = array();
        $cls = $_GET['cls'];
        $house = $_GET['house'];
        $prog = $_GET['prog'];
        $ayear = $_GET['ayear'];
        $gender = $_GET['gender'];
        $stds = mysqli_query($cf->con,"select stuinfo.*,classes.classname,dept.depname,houses.name,houses.des from stuinfo,classes,dept,houses where stuinfo.class = classes.id and stuinfo.dept = dept.id and stuinfo.house = houses.id and stuinfo.class like'%$cls%' and stuinfo.house like'%$house%' and stuinfo.dept like '%$prog%' and stuinfo.ayear like'%$ayear%' and stuinfo.gender LIKE'$gender%' ORDER by stuinfo.fname asc");
        while($row = mysqli_fetch_object($stds)){
        $stlist[]=$row;
        }

        header("content-type:application/json");
        header('Access-Control-Allow-Origin: *');
        header("access-control-allow-credetials:true");

        echo(json_encode($stlist));



