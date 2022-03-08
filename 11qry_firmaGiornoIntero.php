	
<?include_once("database/databaseii.php");

    $ID_mae_ora = intval($_POST['ID_mae_ora']);
    $giornodafirmare = intval($_POST['giornodafirmare']);
    $datalunedi = $_POST['datalunedi'];
    //trova la data che corrisponde a giornodafirmare
	$dataDaFirmare = date('Y-m-d',strtotime("+".($giornodafirmare-1)." day", strtotime($datalunedi)));


	//per ciascun ID trovato chiama una funzione da costruire che passi il seguente postData a un file da costruire che aggiorni quel singolo ID_ora con quel maestro come firmato senza compiti (sempre che già non ce ne fossero di inseriti, in quel caso lascio lo status firma_mae_ora come sta)

    //trova gli ID delle ore da firmare nel giorno in questione
	$sql = "SELECT ID_ora, firma_mae_ora FROM tab_orario WHERE data_ora = ? AND ID_mae_ora = ? ORDER BY ora_ora";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "si", $dataDaFirmare, $ID_mae_ora);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ora, $firma_mae_ora);
	while (mysqli_stmt_fetch($stmt)) {
        if ($firma_mae_ora == 0) { //devo firmare solo le ore che non sono già firmate
            $sql2 = "UPDATE tab_orario SET firma_mae_ora  = 2 WHERE ID_ora = ?";
            $stmt2 = mysqli_prepare($mysqli, $sql2);
            //mysqli_stmt_bind_param($stmt2, "i", intval($ID_ora));	
            mysqli_stmt_bind_param($stmt2, "i", $ID_ora);	
            mysqli_stmt_execute($stmt2);
        }
    }
    
    $return['test'] = "ID_mae_ora: ".$ID_mae_ora." - giornodafirmare: ".$giornodafirmare." - datalunedi: ".$datalunedi." - dataDaFirmare: ".$dataDaFirmare;
    $return['test2'] = "sql: ".$sql;


    echo json_encode($return);
?>
