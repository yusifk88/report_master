<?php
include_once './objts/config.php';
$cf = new config();
$cf->connect();
mysqli_query($cf->con,"alter table staff ADD dob DATE");
mysqli_query($cf->con,"alter table staff ADD regno VARCHAR(150)");
mysqli_query($cf->con,"alter table staff ADD aqual VARCHAR(150)");
mysqli_query($cf->con,"alter table staff ADD pqual VARCHAR(150)");
mysqli_query($cf->con,"alter table staff ADD snnid VARCHAR(150)");
mysqli_query($cf->con,"alter table staff ADD stfid VARCHAR(80)");
mysqli_query($cf->con,"alter table staff ADD appdate DATE");
mysqli_query($cf->con,"alter table staff ADD assdate DATE");
mysqli_query($cf->con,"alter table staff ADD bank VARCHAR(150)");
mysqli_query($cf->con,"alter table staff ADD accno VARCHAR(150)");
mysqli_query($cf->con,"alter table staff ADD rank INTEGER");
mysqli_query($cf->con,"alter table staff ADD photo TEXT");
mysqli_query($cf->con,"alter table stuinfo ADD jhsno VARCHAR(50)");
mysqli_query($cf->con,"alter table stuinfo ADD shsno VARCHAR(50)");
mysqli_query($cf->con,"create table waec(id INTEGER PRIMARY KEY AUTO_INCREMENT,subid INTEGER,stid INTEGER,grade VARCHAR(10),grade_val INTEGER)");
?>

<center>

<h3>Your database have been patched successfully and is now compactible with report master 6.0 calm bee</h3>
<h3>PLEASE NOTE THAT YOU ARE ADVISED NOT TO RESTORE ANY BACKUP DATA FROM THE PREVIOUS VERSIONS AFTER APPLYING THIS PATCH</h3>
<h2>THANK YOU AND ENJOY THE MAGIC... </h2>
</center>
