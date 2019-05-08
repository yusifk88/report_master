<?php
include_once './objts/config.php';
$cfg = new config();
$cfg->connect();
session_start();
$id = $_SESSION['id'];
$targetFolder = '/report/admin/objts/pass';
if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
    $rnd = md5(time());
    $targetFile = rtrim($targetPath,'/') . '/' .$rnd.$_FILES['file']['name'];
    // Validate the file type
    $fileTypes = array('JPG','jpg','jpeg','gif','png','PNG','JPEG','GIF');
    $fileParts = pathinfo($_FILES['file']['name']);
    if (in_array($fileParts['extension'],$fileTypes)) {
        move_uploaded_file($tempFile,$targetFile);
        $filepath = str_replace($_SERVER['DOCUMENT_ROOT']."/report","..",$targetFile);
        mysqli_query($cfg->con,"update staff set photo = '$filepath' where id = '$id'");
        echo $targetFile;
    } else {
        echo 'Invalid file type.';
    }
}
