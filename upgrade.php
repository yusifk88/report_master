<?php
include_once("admin/objts/config.php");
$cf = new config();
$cf->connect();
mysqli_query($cf->con,"CREATE TABLE `user_log` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `uid` int(11) NOT NULL,
 `action` text NOT NULL,
 `datetime_entry` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=latin1");

mysqli_query($cf->con,"CREATE TABLE `exiat` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `stid` int(11) NOT NULL,
 `stfid` int(11) NOT NULL,
 `date_signed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `return_date` datetime NOT NULL,
 `reason` text NOT NULL,
 `ex_type` varchar(20) NOT NULL DEFAULT 'ex',
 `returned` tinyint(1) NOT NULL DEFAULT '0',
 `returned_time` datetime NOT NULL,
 `remark` text NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1");

?>
<h4>UPGRADE WAS SUCCESSFUL</h4>
<h1>WELCOME TO REPORT MASTER 7.0(REBIRTH)</h1>
<strong>Note: do not visit this page again</strong> <br>
<a href="/report7">Go to app</a>
