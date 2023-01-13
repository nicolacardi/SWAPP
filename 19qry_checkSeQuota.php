<?include_once("database/databaseii.php");
    //questa routine cerca se le quote concordate annuali di tutti i figli della famiglia ID_fam_alu sono <> 0
    //restituisce true se un figlio almeno ha quota annuale zero per l'anno selezionato
    //false se tutti i figli hanno quote concordate annuali <> 0 per l'anno selezionato
    $ID_fam = $_POST['ID_fam_alu'];
    $annoscolastico = $_POST['annoscolastico'];

    $almenounaquotaannuazero = false;

    //seleziono fratello per fratello di ID_fam_alu dell'anno corrente
    $sql = "SELECT ID_alu_cla FROM tab_classialunni JOIN tab_anagraficaalunni ON ID_alu_cla = ID_alu WHERE ID_fam_alu = ? AND annoscolastico_cla = ? AND listaattesa_cla = 0";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "is", $ID_fam, $annoscolastico);
	mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $ID_alu_cla );
    mysqli_stmt_store_result($stmt);
    $n=0;
	while (mysqli_stmt_fetch($stmt)) {
        $n++;
        $quotafratello[$n] = 0;
        $sql2 = "SELECT concordato_ret FROM tab_mensilirette WHERE ID_alu_ret = ? AND annoscolastico_ret = ?";
        $stmt2 = mysqli_prepare($mysqli, $sql2);
        mysqli_stmt_bind_param($stmt2, "is", $ID_alu_cla, $annoscolastico);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_bind_result($stmt2, $concordato_ret );
        while (mysqli_stmt_fetch($stmt2)) {
            $quotafratello[$n] =  $quotafratello[$n] + $concordato_ret;
        }
    }
    
    for ($x = 1; $x <=$n; $x++) {
        if ( $quotafratello[$x] == 0 ) $almenounaquotaannuazero = true;
    }
    

	$return['almenounaquotaannuazero'] = $almenounaquotaannuazero;
	$return['test'] = $sql;
    $return['test2'] = $ID_fam;
    $return['test3'] = $annoscolastico;

	
	echo json_encode($return);
?>

