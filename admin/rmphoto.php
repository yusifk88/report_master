<?php
/**
 * Created by PhpStorm.
 * User: Godson
 * Date: 7/28/2017
 * Time: 2:01 AM
 */


$file = $_GET['file'];

unlink("objts/temppic/" . $file);