<!-- questa routine sistema le lezioni tutorate: -->
<!-- cerca per ogni lezione se c'è un ID_firmatutor ...diciamo che nella lezione con ID_ora = 1234 ci sia nel campo ID_firmatutor il valore 1235-->
<!-- se c'è, allora vengono presi l'argomento_ora e i compitiassegnati_ora del record 1234  -->
<!-- SOLO SE nella lezione del tutor con ID_ora = 1234 non ci sono quei due campi compilati -->
<!-- allora la routine va a scriverci quello che il tutored ha scritto  -->
<!-- L'obiettivo è infatti che il tutor abbia sempre compiti e argomenti che il tutored aveva inserito  -->


<?  include_once("database/databaseii.php");

$filename = "reportsistemalezionitutorate.txt";

    $handle = fopen($filename, "w");
    fwrite($handle, "\n INIZIA \n");


$sql = "SELECT data_ora, ora_ora, classe_ora, ID_ora, IDfirmatutor_ora, argomento_ora, compitiassegnati_ora FROM tab_orario WHERE IDfirmatutor_ora != 0 AND data_ora > '2023-09-01'";

$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $data_ora, $ora_ora, $classe_ora, $ID_ora_tutored, $IDfirmatutor_ora_tutored, $argomento_ora_tutored, $compitiassegnati_ora_tutored);
mysqli_stmt_store_result($stmt);
$n = 0;
$sql3count = 0;
$sql4count = 0;
$datedisallineate = 0;
while (mysqli_stmt_fetch($stmt)) {
    $n++;
    fwrite($handle, $n." ------------------------------------------------------"."\n");
    fwrite($handle, "\nLEZIONE: data:".$data_ora." ora:".$ora_ora." classe:".$classe_ora."\n");
    fwrite($handle, "ID_ora_tutored:".$ID_ora_tutored."\n");
    fwrite($handle, "IDfirmatutor_ora_tutored: -->" .$IDfirmatutor_ora_tutored."\n");
    fwrite($handle, "argomento_ora_tutored: --> ".$argomento_ora_tutored."\n");

    //adesso estraggo l'ora del tutor
    $sql2 = "SELECT ID_ora, data_ora, argomento_ora, compitiassegnati_ora  FROM tab_orario WHERE ID_ora  = ".$IDfirmatutor_ora_tutored;
    $stmt2 = mysqli_prepare($mysqli, $sql2);

    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $ID_ora_tutor, $data_ora_tutor, $argomento_ora_tutor, $compitiassegnati_ora_tutor);
    mysqli_stmt_store_result($stmt2);


    while (mysqli_stmt_fetch($stmt2)) {

        // if ($data_ora == $data_ora_tutor) {

        // } else {
        //     fwrite($handle, "*****************************************data_ora_tutored: --> ".$data_ora." data_ora_tutor: -->".$data_ora_tutor."\n");
        //     $datedisallineate++;
        // }
        fwrite($handle, "sql2: --> ".$sql2."\n");
        fwrite($handle, "argomento_ora_tutor: --> ".$argomento_ora_tutor."\n");


        if (($argomento_ora_tutor == NULL || $argomento_ora_tutor='') && ($argomento_ora_tutored != NULL && $argomento_ora_tutored != ''))
        {
                $sql3 = "UPDATE tab_orario SET argomento_ora = '".$argomento_ora_tutored."' WHERE ID_ora= ".$ID_ora_tutor.";";
                $stmt3 = mysqli_prepare($mysqli, $sql3);
                mysqli_stmt_execute($stmt3);
                $sql3count++;
                fwrite($handle, "sql3count: --> ".$sql3count."\n");
                fwrite($handle, "################################## sql3: --> ".$sql3."\n");
        }
        if (($compitiassegnati_ora_tutor == NULL || $compitiassegnati_ora_tutor == '')  && ($compitiassegnati_ora_tutored != NULL && $compitiassegnati_ora_tutored != ''))
        {
                $sql4 = "UPDATE tab_orario SET compitiassegnati_ora = '".$compitiassegnati_ora_tutored."' WHERE ID_ora= ".$ID_ora_tutor.";";
                $stmt4 = mysqli_prepare($mysqli, $sql4);
                mysqli_stmt_execute($stmt4);
                $sql4count++;
                fwrite($handle, "sql4count: --> ".$sql4count."\n");
                fwrite($handle, "################################## sql4 --> ".$sql4."\n");
        }

    }

    fwrite($handle, "------------------------------------------------------"."\n");

}

fwrite($handle, "------------------------------------------------------"."\n");
fwrite($handle, "------------------------------------------------------"."\n");
fwrite($handle, "------------------------------------------------------"."\n");

fwrite($handle, "ESEGUITE ".$sql3count." query sugli argomenti \n");
fwrite($handle, "ESEGUITE ".$sql4count." query sui compiti assegnati \n");
fwrite($handle, "DATE DISALLINEATE ".$datedisallineate."\n");


fclose($handle);
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$filename.'"');
readfile($filename);
?>
