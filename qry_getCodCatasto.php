<?

//PURTROPPO NON RIESCO A FAR ANDARE QUESTA: QUESTA PESCHEREBBE NELLA TABELLA TAB_CAP INVECE CHE FAR TROVARE IL CODICE CATASTO IN UN ARRAY DI VALORI
//MA PER RAGIONI DI SINCRONIA IL VALORE ESTRATTO QUI NON ARRIVA IN TEMPO ALLA FUNZIONE CHE LA CHIAMA (trovaComune)

include_once("database/databaseii.php");
include_once("assets/functions/functions.php");

	$pattern_comune = $_POST['pattern_comune'];
	$sql = "SELECT codicecatasto FROM tab_CAP WHERE comune_cap = ? ; ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "s", $pattern_comune);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $codcatasto);
	while (mysqli_stmt_fetch($stmt)) {
	}
	
	$return['codcatasto'] = $codcatasto;
	
	echo json_encode($return);
?>
