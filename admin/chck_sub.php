<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\school;

$sch = new school();
if($sch->sub_expired()){

    echo '<h3 class="text-danger">Sorry, you cannot have access to this component at the moment, your portal subscription is over</h3>';
    exit(0);

}