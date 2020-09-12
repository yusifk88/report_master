<?php

unlink("backup/backup.zip");
foreach (scandir("backup/tempbackup") as $file) {


    unlink("backup/tempbackup/" . $file);


}
rmdir("backup/tempbackup");