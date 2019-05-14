<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/report7/admin/objts/temppic'; // Relative to the root

//$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
    $targetFile = rtrim($targetPath, '/') . '/' . $_FILES['file']['name'];

    // Validate the file type
    $fileTypes = array('JPG', 'jpg', 'jpeg', 'gif', 'png', 'PNG', 'JPEG', 'GIF'); // File extensions
    $fileParts = pathinfo($_FILES['file']['name']);

    if (in_array($fileParts['extension'], $fileTypes)) {
        move_uploaded_file($tempFile, $targetFile);
        echo $targetFile;
    } else {
        echo 'Invalid file type.';
    }
}
