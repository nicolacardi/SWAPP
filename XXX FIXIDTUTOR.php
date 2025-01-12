<!-- questa routine sistema gli ID delle lezioni tutorate: -->
<!-- accade che la 07qy_PropagaEpocaSett fa un errore: crea le lezioni TUTORATE -->
<!-- con un IDfirmatutor_ora SBAGLIATO, in quanto se deve duplicare ad esempio un record che ha IDfirmatutor_ora 20000 -->
<!-- mette sulla copia lo stesso IDfirmatutor_ora = 20000, che non va bene -->
<!-- Quindi in questa routine prendo ciascuna lezione che abbia un IDfirmatutor_ora diverso da 0 -->
<!-- e vado a verificare se la lezione che ha codice TUX e stessa classe_ora data_ora  -->

<?  include_once("database/databaseii.php");

$filename = "reportsistemaIDlezionitutorate.txt";

    $handle = fopen($filename, "w");
    fwrite($handle, "\n INIZIA \n");


$sql = "SELECT ID_ora, data_ora, ora_ora, classe_ora, IDfirmatutor_ora FROM tab_orario WHERE IDfirmatutor_ora != 0 AND data_ora > '2023-09-01'";

$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_ora_tutored, $data_ora, $ora_ora, $classe_ora, $IDfirmatutor_ora_tutored);
mysqli_stmt_store_result($stmt);
$n = 0;
$sql3count = 0;
$datedisallineate = 0;
while (mysqli_stmt_fetch($stmt)) {
    $n++;
    //adesso estraggo l'ID del tutor CHE DOVREBBE ESSERCI: uso stessa data, stessa ora, stessa classe e codmat_ora = TUX
    $sql5 = "SELECT ID_ora  FROM tab_orario WHERE data_ora= '".$data_ora."' AND ora_ora= ".$ora_ora." AND classe_ora = '".$classe_ora."' AND codmat_ora = 'TUX'";
    $stmt5 = mysqli_prepare($mysqli, $sql5);
    mysqli_stmt_execute($stmt5);
    mysqli_stmt_bind_result($stmt5, $ID_ora_tutor_should);
    mysqli_stmt_store_result($stmt5);
    while (mysqli_stmt_fetch($stmt5)) {}
    

    if ($IDfirmatutor_ora_tutored == $ID_ora_tutor_should) {

    } else {
        //fwrite($handle, $n." ------------------------------------------------------"."\n");
        fwrite($handle, "\nLEZIONE: data:".$data_ora." ora:".$ora_ora." classe:".$classe_ora."\n");
        fwrite($handle, "in questa lezione dovrebbe esserci:".$ID_ora_tutor_should."\n");
        fwrite($handle, "invece c'è: -->" .$IDfirmatutor_ora_tutored."\n");
        fwrite($handle, "sql5: -->" .$sql5."\n");
        $datedisallineate++;

        //quindi preparo l'azione correttiva
        $sql3 = "UPDATE tab_orario SET IDfirmatutor_ora = ".$ID_ora_tutor_should." WHERE ID_ora= ".$ID_ora_tutored.";";
        $stmt3 = mysqli_prepare($mysqli, $sql3);
        mysqli_stmt_execute($stmt3);
        $sql3count++;
        fwrite($handle, "sql3count: --> ".$sql3count."\n");
        fwrite($handle, "################################## sql3: --> ".$sql3."\n");


    }



    fwrite($handle, $n."------------------------------------------------------"."\n");

}

fwrite($handle, "------------------------------------------------------"."\n");
fwrite($handle, "------------------------------------------------------"."\n");
fwrite($handle, "------------------------------------------------------"."\n");


fwrite($handle, "DATE DISALLINEATE ".$datedisallineate."\n");
fwrite($handle, "AGITE ".$sql3count." AZIONI CORRETTIVE\n");

fclose($handle);
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$filename.'"');
readfile($filename);
?>
