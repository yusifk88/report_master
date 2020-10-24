<?php

include_once("../objts/config.php");
$cf = new config();
$cf->connect();

backup_tables($cf->host, $cf->user, $cf->password, $cf->db);


/* backup the db OR just a table */

function backup_tables($host, $user, $pass, $name, $tables = '*')
{

    $link = mysqli_connect($host, $user, $pass);
    mysqli_select_db($link, $name);

    //get all of the tables
    if ($tables == '*') {
        $tables = array();
        $result = mysqli_query($link, 'SHOW TABLES');
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }

    } else {
        $tables = is_array($tables) ? $tables : explode(',', $tables);
    }
    $return = '';
    //cycle through
    foreach ($tables as $table) {
        $result = mysqli_query($link, 'SELECT * FROM ' . $table);
        $num_fields = mysqli_num_fields($result);

        $return .= 'DROP TABLE ' . $table . ';';
        $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE ' . $table));
        $return .= "\n\n" . $row2[1] . ";\n\n";

        for ($i = 0; $i < $num_fields; $i++) {
            while ($row = mysqli_fetch_row($result)) {
                $return .= 'INSERT INTO ' . $table . ' VALUES(';
                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = mb_ereg_replace("\n", "\\n", $row[$j]);
                    if (isset($row[$j])) {
                        $return .= '"' . $row[$j] . '"';
                    } else {
                        $return .= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return .= ',';
                    }
                }
                $return .= ");\n";
            }
        }
        $return .= "\n\n\n";
    }

    //save file

    $handle = fopen('backup.sql', 'w+');
    fwrite($handle, $return);
    fclose($handle);

    if (!dir("tempbackup")) {

        mkdir("tempbackup", 0777);

    }


//       if(file("../objts/pass/data.sql")){
//           unlink("../objts/pass/data.sql");
//           
//       }
    foreach (scandir("../objts/pass/") as $pic) {
        copy("../objts/pass/" . $pic, "tempbackup/" . $pic);
    }
    copy("backup.sql", "tempbackup/data.sql");

    $zipmng = new ZipArchive();
    $zipmng->open("Backup.zip", ZipArchive::CREATE | ZipArchive::OVERWRITE);
    foreach (glob("tempbackup/*.*") as $file) {
        $zipmng->addFile($file);
    }

    $zipmng->close();


}


