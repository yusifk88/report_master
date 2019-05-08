<?php
$file=$_GET['backup'];
$zipmng = new ZipArchive();
$zipmng->open("temprest/".$file);
mkdir("temprest/temp", 0777);
$zipmng->extractTo("temprest/temp");
copy("temprest/temp/tempbackup/data.sql", "backup/backup.sql");
   
foreach (scandir("temprest/temp/tempbackup") as $bkfile){  
    
    copy("temprest/temp/tempbackup/".$bkfile, "objts/pass/".$bkfile);
    
}
foreach (scandir("temprest/temp/tempbackup") as $bkf){  
    
    unlink("temprest/temp/tempbackup/".$bkf);
    
}
rmdir("temprest/temp/tempbackup");
rmdir("temprest/temp");