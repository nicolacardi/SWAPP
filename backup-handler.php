<?php
ob_start(); // Inizia il buffer di output
session_start();
$cod = $_GET['cod'] ?? null;
$scuola = $_GET['scuola'] ?? null;
$BB = $_GET['BB'] ?? null;
$configDir = './database/';

$BB=='A'?$BB='':$BB='B';
$file = $configDir . "database".$BB."ii_web_$scuola.php";


if (file_exists($file)) {
    include_once ($file);

    $tables = array();
    $sql = "SHOW TABLES";
    $result = mysqli_query($mysqli, $sql);

    while ($row = mysqli_fetch_row($result)) {
        $tables[] = $row[0];
    }

    $sqlScript = "";
    foreach ($tables as $table) {
        $query = "SHOW CREATE TABLE $table";
        $result = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_row($result);
        $sqlScript = $sqlScript."\n\n" . $row[1] . ";\n\n";

        $query = "SELECT * FROM $table";
        $result = mysqli_query($mysqli, $query);
        $columnCount = mysqli_num_fields($result);

        for ($i = 0; $i < $columnCount; $i ++) {
            while ($row = mysqli_fetch_row($result)) {
                $sqlScript .= "INSERT INTO $table VALUES(";
                for ($j = 0; $j < $columnCount; $j ++) {
                    $row[$j] = $row[$j];
                    if (isset($row[$j])) {
                        $sqlScript .= "'". addslashes($row[$j]) . "'";
                    } else {
                        $sqlScript .= "''";
                    }
                    if ($j < ($columnCount - 1)) {
                        $sqlScript .= ',';
                    }
                }
                $sqlScript .= ");\n";
            }
        }
        $sqlScript .= "\n"; 
    }

    if(!empty($sqlScript))
    {
        // Save the SQL script to a backup file
        //$backup_file_name = date('Ymd_h.i.s').'_ExportBackupdb_'.$database.'.sql';
        $backup_file_name = date('Ymd').'_'.$cod.'_'.$database.'.sql';

        $return['backup_file_name'] = $backup_file_name;

        $fileHandler = fopen($backup_file_name, 'w+');
        $number_of_lines = fwrite($fileHandler, $sqlScript);
        fclose($fileHandler); 
        $return['headerssent'] = "headers not sent";
        $return['obendtoclean'] = "no";
        $return['filereadable'] = "yes";
        //$backup_file_name ="../../../Bitcoineblockchain.docx";

        if (file_exists($backup_file_name)) {
            ob_end_clean();
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');

            header('Content-Length: ' . filesize($backup_file_name));
            ob_clean();
            flush();
            $return["testx"] = $fileSize;

            readfile($backup_file_name);
        
            exec('rm ' . $backup_file_name); 
            
        } else {
            die("File non trovato.");
        }
    }   
     if (isset($mysqli)) {mysqli_close($mysqli);}   //chiudo mysqli
}

    echo json_encode($return);

?>