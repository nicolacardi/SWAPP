<?include_once("database/databaseii.php");

$ID_alu = $_POST['ID_alu'];
$annoscolastico_cla = $_POST['annoscolastico_cla'];
$aselme_cla = $_POST['aselme_cla'];
$Doc = $_POST['Doc'];
$quadrimestre = $_POST['quadrimestre'];
if ($Doc == 'CerCom') {$quadrimestre ="";} //nel caso di Certificazione delle competenze non è rilevante il quadrimestre ed anzi disturberebbe a fine routine

//conteggio voti e giudizi pagelle tipo base
$countvot1 = 0;
$countvot2 = 0;
$countgiu1 = 0;
$countgiu2 = 0;

//conteggio voti  giudizi tipo 2
$countvot1_2 = 0;
$countvot2_2 = 0;
$countgiu1_2 = 0;
$countgiu2_2 = 0;

//conteggio giudizi globali
$countgiuquad1 = 0;
$countgiuquad2 = 0;

//conteggio certificazione competenze
$countcercom = 0;


$sql1 = "SELECT votocertcomp_cer FROM tab_certcompetenze WHERE ID_alu_cer = ? AND annoscolastico_cer = ?";
$stmt1 = mysqli_prepare($mysqli, $sql1);
mysqli_stmt_bind_param($stmt1, "is", $ID_alu, $annoscolastico_cla);
mysqli_stmt_execute($stmt1);
mysqli_stmt_bind_result($stmt1, $votocertcomp_cer);
mysqli_stmt_store_result($stmt1);
while (mysqli_stmt_fetch($stmt1)) {
	if (($votocertcomp_cer != "" ) && !(is_null($votocertcomp_cer))) {$countcercom++;}
}


//in tab_classialunni c'è il giudizio globale del primo e del secondo quadrimestre
$sql3 = "SELECT giuquad1_cla, giuquad2_cla FROM tab_classialunni ".
"WHERE ID_alu_cla = ? AND annoscolastico_cla = ?";
$stmt3 = mysqli_prepare($mysqli, $sql3);
mysqli_stmt_bind_param($stmt3, "is", $ID_alu, $annoscolastico_cla);
mysqli_stmt_execute($stmt3);
mysqli_stmt_bind_result($stmt3, $giuquad1_cla, $giuquad2_cla);
mysqli_stmt_store_result($stmt3);
while (mysqli_stmt_fetch($stmt3)) {
	if ($giuquad1_cla != "" ) {$countgiuquad1++;}
	if ($giuquad2_cla != "" ) {$countgiuquad2++;}
}

//in tab_classialunnivoti ci sono i voti delle singole materie ed i giudizi delle singole materie (quelli che compaiono nel documento di valutazione interna)
$sql2 = "SELECT vot1_cla, giu1_cla, vot2_cla, giu2_cla ".
"FROM (tab_materievoti LEFT JOIN  tab_classialunnivoti on codmat_cla = codmat_mat AND tipodoc_mat = 1) WHERE ID_alu_cla = ?  AND annoscolastico_cla = ? ";
$stmt2 = mysqli_prepare($mysqli, $sql2);
mysqli_stmt_bind_param($stmt2, "is", $ID_alu, $annoscolastico_cla);
mysqli_stmt_execute($stmt2);
mysqli_stmt_bind_result($stmt2, $vot1_cla, $giu1_cla, $vot2_cla, $giu2_cla);
mysqli_stmt_store_result($stmt2);
while (mysqli_stmt_fetch($stmt2)) {
	if (($vot1_cla != "" ) && ($vot1_cla != "0" ) && (strlen($vot1_cla) != 0)) {$countvot1++;}
	if (($vot2_cla != "" ) && ($vot2_cla != "0" ) && (strlen($vot2_cla) != 0)) {$countvot2++;}
	if (($giu1_cla != "" ) && (strlen($giu1_cla) != 0)) {$countgiu1++;}
	if (($giu2_cla != "" ) && (strlen($giu2_cla) != 0)) {$countgiu2++;}
}

//in tab_classialunnivoti ci sono i voti delle singole materie ed i giudizi delle singole materie (quelli che compaiono nel documento di valutazione interna)
$sql2 = "SELECT vot1_cla, giu1_cla, vot2_cla, giu2_cla ".
"FROM (tab_materievoti LEFT JOIN  tab_classialunnivoti on codmat_cla = codmat_mat AND tipodoc_mat = 2) WHERE ID_alu_cla = ?  AND annoscolastico_cla = ? ";
$stmt2 = mysqli_prepare($mysqli, $sql2);
mysqli_stmt_bind_param($stmt2, "is", $ID_alu, $annoscolastico_cla);
mysqli_stmt_execute($stmt2);
mysqli_stmt_bind_result($stmt2, $vot1_cla, $giu1_cla, $vot2_cla, $giu2_cla);
mysqli_stmt_store_result($stmt2);
while (mysqli_stmt_fetch($stmt2)) {
	if (($vot1_cla != "" ) && ($vot1_cla != "0" ) && (strlen($vot1_cla) != 0)) {$countvot1_2++;}
	if (($vot2_cla != "" ) && ($vot2_cla != "0" ) && (strlen($vot2_cla) != 0)) {$countvot2_2++;}
	if (($giu1_cla != "" ) && (strlen($giu1_cla) != 0)) {$countgiu1_2++;}
	if (($giu2_cla != "" ) && (strlen($giu2_cla) != 0)) {$countgiu2_2++;}
}


switch ($aselme_cla) {
	case "EL":
		$NVotPagUff = 6;
		$NGiuDocInt = 5;
		$NVotCerCom = 11;
		$NVotGiuPagUff_2 = 27;
		break;
	case "ME":
		$NVotPagUff = 14;
		$NGiuDocInt = 13;
		$NVotCerCom = 11;
		$NVotGiuPagUff_2 = 27;
		break;
	case "SU":
		$NVotPagUff = 14;
		$NGiuDocInt = 13;
		$NVotCerCom = 11;
		$NVotGiuPagUff_2 = 27;
		break;
}


if ($countgiu1<$NGiuDocInt) { $return ['CkDocInt1'] = 'NO'; } else { $return ['CkDocInt1'] = 'OK'; }
if (($countvot1+$countgiuquad1)<$NVotPagUff) { $return ['CkPagUff1'] = 'NO';} else { $return ['CkPagUff1'] = 'OK';}
if ($countgiu2<$NGiuDocInt) { $return ['CkDocInt2'] = 'NO'; } else { $return ['CkDocInt2'] = 'OK'; }
if (($countvot2+$countgiuquad2)<$NVotPagUff) { $return ['CkPagUff2'] = 'NO';} else { $return ['CkPagUff2'] = 'OK';}
if ($countcercom<$NVotCerCom) { $return ['CkCerCom'] = 'NO';} else { $return ['CkCerCom'] = 'OK';}
if ($countvot1_2+$countgiu1_2+$countgiuquad1<$NVotGiuPagUff_2) { $return ['CkPagUff_21'] = 'NO';} else { $return ['CkPagUff_21'] = 'OK';}
if ($countvot2_2+$countgiu2_2+$countgiuquad2<$NVotGiuPagUff_2) { $return ['CkPagUff_22'] = 'NO';} else { $return ['CkPagUff_22'] = 'OK';}
$return ['test']  = $countvot1_2;
$return ['Ck'] = $return['Ck'.$Doc.$quadrimestre];
echo json_encode($return);
 
?>