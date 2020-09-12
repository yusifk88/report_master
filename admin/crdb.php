<?php

$con = mysqli_connect("localhost", "root", "");
$chk = mysqli_select_db($con, "reportdb");
if (!$chk) {

    mysqli_query($con, "create database reportdb");
    mysqli_select_db($con, "reportdb");

    mysqli_query($con, "
            CREATE TABLE classes (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classname` varchar(100) NOT NULL,
  `dpid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1
             ");


    mysqli_query($con, " CREATE TABLE `dept` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `depname` varchar(120) NOT NULL,
  `dentry` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
");


    mysqli_query($con, " CREATE TABLE `houses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `des` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

 ");

    mysqli_query($con, "CREATE TABLE `records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stid` int(11) NOT NULL,
  `acyear` varchar(20) NOT NULL,
  `term` varchar(5) NOT NULL,
  `cls` int(11) NOT NULL,
  `subjt` int(11) NOT NULL,
  `ta1` double DEFAULT NULL,
  `ta2` double DEFAULT NULL,
  `ta3` double DEFAULT NULL,
  `ta4` double DEFAULT NULL,
  `hw1` double DEFAULT NULL,
  `hw2` double DEFAULT NULL,
  `hw3` double DEFAULT NULL,
  `hw4` double DEFAULT NULL,
  `pw1` double DEFAULT NULL,
  `pw2` double DEFAULT NULL,
  `subtotl` double NOT NULL,
  `cvsubtotl` double NOT NULL,
  `exam` double DEFAULT NULL,
  `cvexam` double NOT NULL,
  `totlscore` double NOT NULL,
  `grd` varchar(5) NOT NULL,
  `remark` varchar(25) NOT NULL,
  `post` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=latin1;
 ");

    mysqli_query($con, "CREATE TABLE staff (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `rank` varchar(150) NOT NULL,
  `stfid` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `regno` varchar(80) NOT NULL,
  `aqual` varchar(150) NOT NULL,
  `pqual` varchar(180) NOT NULL,
  `appdate` date NOT NULL,
  `assdate` date NOT NULL,
  `bank` varchar(200) NOT NULL,
  `accno` varchar(180) NOT NULL,
  `snnid` varchar(20) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `upass` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL
)
");


    mysqli_query($con, " CREATE TABLE `stuinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stindex` varchar(20) NOT NULL,
  `ayear` varchar(20) NOT NULL,
  `class` int(11) NOT NULL,
  `dept` int(11) NOT NULL,
  `form` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `dor` date NOT NULL,
  `ffname` varchar(120) NOT NULL,
  `fhometown` varchar(200) NOT NULL,
  `fname` varchar(120) NOT NULL,
  `lname` varchar(120) NOT NULL,
  `oname` varchar(120) NOT NULL DEFAULT 'N/A',
  `ftel` varchar(12) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `house` int(11) NOT NULL,
  `lschool` varchar(120) NOT NULL,
  `mfname` varchar(200) NOT NULL,
  `mhometown` varchar(200) NOT NULL,
  `mtel` varchar(12) NOT NULL,
  `photo` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
)");

    mysqli_query($con, " CREATE TABLE `subas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subid` int(11) NOT NULL,
  `stfid` int(11) NOT NULL,
  `clid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
 ");

    mysqli_query($con, " CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subjdesc` varchar(20) NOT NULL,
  `type` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
");

    mysqli_query($con, " CREATE TABLE `totls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stid` int(11) NOT NULL,
  `cls` int(11) NOT NULL,
  `term` varchar(5) NOT NULL,
  `ayear` varchar(15) NOT NULL,
  `totlscore` double NOT NULL,
  `post` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=latin1;
 ");
    $pass = md5("032102726042");
    mysqli_query($con, "insert into staff(fname,lname,gender,contact,uname,upass,user_type,status) values('Wide','Empire','Male','0207796042','muyudu','$pass','admin','active')");


    mysqli_query($con, "CREATE TABLE IF NOT EXISTS `deadline` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `status` varchar(10) NOT NULL,
  `ddate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1");


    mysqli_query($con, "CREATE TABLE IF NOT EXISTS `ginfo` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `stid` int(11) NOT NULL,
  `term` varchar(4) NOT NULL,
  `ayear` varchar(15) NOT NULL,
  `coment` text NOT NULL,
  `dentry` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1");


    mysqli_query($con, "CREATE TABLE IF NOT EXISTS `frmass` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `stid` int(11) NOT NULL,
  `cls` int(11) NOT NULL,
  `term` varchar(5) NOT NULL,
  `ayear` varchar(20) NOT NULL,
  `attdance` int(11) NOT NULL,
  `attnded` int(11) NOT NULL,
  `cnduct` varchar(200) NOT NULL,
  `attitude` varchar(200) NOT NULL,
  `interest` varchar(200) NOT NULL,
  `remark` varchar(200) NOT NULL
)  ENGINE=InnoDB DEFAULT CHARSET=latin1");


    mysqli_query($con, "CREATE TABLE IF NOT EXISTS `frmmaters` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT ,
  `stfid` int(11) NOT NULL,
  `clid` int(11) NOT NULL
) DEFAULT CHARSET=latin1");


    mysqli_query($con, "CREATE TABLE IF NOT EXISTS `withdraw` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `stid` int(11) NOT NULL,
  `wdate` date NOT NULL
)");


    $nw = date("Y-m-d");

    mysqli_query($con, "insert into deadline(status,ddate) values('OFF','$nw')");


}