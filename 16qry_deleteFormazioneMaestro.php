<?include_once("database/databaseii.php");
	$ID_tit = $_POST['ID_tit'];
	
	//verifico se ci sono altri corsi uguali per lo stesso maestro perchè se ce ne sono devo EVENTUALMENTE ripristinare showscad_tit = 0 del più recente
	
	//trovo ID_mae_tit e nome_tit del corso che sto cancellando
	$sql1= "SELECT ID_mae_tit, nome_tit FROM tab_titolimaestri WHERE ID_tit = ? ";
	$stmt1 = mysqli_prepare($mysqli, $sql1);
	mysqli_stmt_bind_param($stmt1, "i", $ID_tit);
	mysqli_stmt_execute($stmt1);
	mysqli_stmt_bind_result($stmt1, $ID_mae_tit, $nome_tit);
	while (mysqli_stmt_fetch($stmt1)) {
	}
	
	//trovo se ci sono ALTRI (<>$ID_tit) corsi dello stesso maestro con lo stesso titolo e mi metto "da parte" l'ID e la scadenza di quello che ha la data più nuova/meno vecchia
	$sql2= "SELECT ID_tit, scad_tit FROM tab_titolimaestri WHERE ID_mae_tit = ? AND nome_tit = ? AND ID_tit <> ?";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "isi", $ID_mae_tit, $nome_tit, $ID_tit);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $ID_tit_altro, $scad_tit_altro);
	$ID_tit_riferimento = 0;
	$scad_riferimento = '1970-01-01';
	while (mysqli_stmt_fetch($stmt2)) {
		if ($scad_tit_altro > $scad_riferimento) {
			$scad_riferimento = $scad_tit_altro;
			$ID_tit_riferimento = $ID_tit_altro;
		}
	}
	
	//se ne ho trovati allora devo ripristinare showscad_tit = 0 per quello di riferimento (il più recente) cioè per quello che ho trovato
	if ($ID_tit_riferimento != 0) {
		$sql3= "UPDATE tab_titolimaestri SET showscad_tit = 0 WHERE ID_tit = ?";
		$stmt3 = mysqli_prepare($mysqli, $sql3);
		mysqli_stmt_bind_param($stmt3, "i", $ID_tit_riferimento);
		mysqli_stmt_execute($stmt3);
	}
	
	
	
	
	
	
	//cancello da tab_titolimaestri
	$sql4 = "DELETE FROM tab_titolimaestri ".
	" WHERE ID_tit = ? ;";	
	$stmt4 = mysqli_prepare($mysqli, $sql4);
	mysqli_stmt_bind_param($stmt4, "i", $ID_tit);	
	mysqli_stmt_execute($stmt4);
	$return['sql'] = $sql;
	$return['ID_tit'] = $ID_tit;
	echo json_encode($return);
?>
