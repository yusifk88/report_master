<?php
$filename = 'backup.sql';
include_once("../objts/config.php");
$cf = new config();

$mysql_host = $cf->host;
$mysql_username = $cf->user;
$mysql_password = $cf->password;
$mysql_database = $cf->db;

// Connect to MySQL server
$link = mysqli_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
// Select database
mysqli_select_db($link, $mysql_database) or die('Error selecting MySQL database: ' . mysql_error());
mysqli_query($link, "SET NAMES 'utf8'");
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line) {
    if (substr($line, 0, 2) == '--' || $line == '')
        continue;

    $templine .= $line;
    if (substr(trim($line), -1, 1) == ';') {
        mysqli_query($link, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
        // Reset temp variable to empty
        $templine = '';
    }
}