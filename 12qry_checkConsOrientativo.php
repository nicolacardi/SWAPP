<?include_once("database/databaseii.php");

$ID_alu_cor = $_POST['ID_alu'];
$annoscolastico_cor = $_POST['annoscolastico'];
$ottava = $_POST['ottava'];



$sql = "SELECT metodo_cor, interesse_cor, ";
for ($i = 1; $i<=10; ++$i) {
	$sql = $sql."area".$i."_cor, ";
}
for ($i = 1; $i<=4; ++$i) {
	$sql = $sql."scuola".$i."_cor, ";
}
for ($i = 1; $i<=4; ++$i) {
	$sql = $sql."tiposcuola".$i."_cor, ";
}
$sql = $sql ." attitudini_cor, nome_alu, cognome_alu FROM tab_consorientativo LEFT JOIN tab_anagraficaalunni ON ID_alu_cor = ID_alu ".
"WHERE ID_alu_cor = ? AND annoscolastico_cor = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "is", $ID_alu_cor, $annoscolastico_cor);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $metodo_cor, $interesse_cor, $area1_cor, $area2_cor, $area3_cor, $area4_cor, $area5_cor, $area6_cor, $area7_cor, $area8_cor, $area9_cor, $area10_cor, $scuola1_cor, $scuola2_cor, $scuola3_cor, $scuola4_cor, $tiposcuola1_cor, $tiposcuola2_cor, $tiposcuola3_cor, $tiposcuola4_cor, $attitudini_cor, $nome_alu, $cognome_alu);
$k = 0;
while (mysqli_stmt_fetch($stmt)) {
	$k = 1;
}
	
	
	
if ($ottava == 1) {
	if ($k == 1) {
		if (($metodo_cor == '') || ($interesse_cor == '') || ( $area1_cor == 0 && $area2_cor == 0 && $area3_cor ==0 && $area4_cor ==0 && $area5_cor ==0 && $area6_cor ==0 && $area7_cor ==0 && $area8_cor ==0 && $area9_cor ==0 && $area10_cor ==0) || ($scuola1_cor ==0 && $scuola2_cor==0 && $scuola3_cor==0 && $scuola4_cor==0) || ($attitudini_cor =='')) {
			$return ['stopgo'] = 'STOP';
			$return['result_alert'] = "Manca qualche informazione<br>devono essere inseriti nel modulo:<br>il metodo, il tipo d'interesse, un'area di preferenza almeno,<br>l'attitudine ed una scuola almeno.<br><br>ASSICURARSI DI SALVARE PRIMA DI STAMPARE";
		} else {
			$return ['stopgo'] = 'GO';
			//$return['result_alert'] = "Tutto OK";
		}
	} else {
		$return ['stopgo'] = 'STOP';
		$return['result_alert'] = "Il Consiglio orientativo non è stato compilato per l'alunno/a selezionato/a";
	}
} else {
	$return ['stopgo'] = 'STOP';
	$return['result_alert'] = 'Il Consiglio orientativo viene emesso solamente per alunni in uscita dalla classe Ottava';
}

echo json_encode($return);
 
?>