<?php

ini_set('memory_limit','1024M');
ini_set('max_execution_time','-1');
ini_set('upload_max_filesize','20000M');

$targetFolder = '/report/admin/temprest';
if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
    $targetFile = rtrim($targetPath,'/') . '/' . $_FILES['file']['name'];
    $fileTypes = array('ZIP','zip');
    $fileParts = pathinfo($_FILES['file']['name']);
    if (in_array($fileParts['extension'],$fileTypes)) {
        move_uploaded_file($tempFile,$targetFile);
        echo $targetFile;
    } else {
        echo 'Invalid file type.';
    }
}
