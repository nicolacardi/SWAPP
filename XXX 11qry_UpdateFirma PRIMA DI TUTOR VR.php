<?include_once("database/databaseii.php");
	$ID_ora = $_POST['ID_ora'];
	$ID_mae_ora = $_POST['ID_mae_ora'];
	$firma_mae_ora = $_POST['firma_mae_ora'];
	$compitiassegnati_ora = str_replace("'", "`", $_POST['compitiassegnati_ora']);
	$argomento_ora = str_replace("'", "`", $_POST['argomento_ora']);
	$assente_ora = intval($_POST['assente_ora']);
	$supplente_ora = intval($_POST['supplente_ora']);

	if ($assente_ora == 1){
		$maestroreale_ora = $supplente_ora;
	} else {
		$maestroreale_ora = $ID_mae_ora;
	}
	if ($assente_ora == 0) { $supplente_ora = 0;}

	$sql = "UPDATE tab_orario SET firma_mae_ora = ? , assente_ora = ? , supplente_ora = ? , maestroreale_ora = ?, datafirma_ora= now(), argomento_ora= ?, compitiassegnati_ora= ? WHERE ID_ora = ? ; ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "iiiissi", $firma_mae_ora, $assente_ora, $supplente_ora, $maestroreale_ora, $argomento_ora, $compitiassegnati_ora, $ID_ora);
	mysqli_stmt_execute($stmt);
	


	//FINORA LA SEMPLICE FIRMA. ORA BISOGNA CONSIDERARE ALCUNI CASI PARTICOLARI


				//CASO TUTORED

				//Se l'insegnante è tutorato allora quello che lui scrive in argomento e compiti assegnati va copiato e scritto ANCHE 
				//nella lezione del tutor, infatti il registro che fa fede è quello del tutor

				//trovo quindi anzitutto se si tratta di un tutorato

				$sql = "SELECT IDfirmatutor_ora FROM tab_orario WHERE ID_ora = ? ; ";
				$stmt = mysqli_prepare($mysqli, $sql);
				mysqli_stmt_bind_param($stmt, "i", $ID_ora);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $IDfirmatutor_ora);
				while (mysqli_stmt_fetch($stmt)) {
				}

				$return['IDfirmatutor_ora'] = $IDfirmatutor_ora;
				if ($IDfirmatutor_ora!= 0) {
					//se IDfirmaturor_ora !=0 allora si tratta di un insegnante tutorato, 
					//devo fare l'update ANCHE del record del tutor, ma SOLO se non è già compilato: vado quindi a vedere se è già compilato
					$sql2 = "SELECT ID_ora, argomento_ora, compitiassegnati_ora  FROM tab_orario WHERE ID_ora  = ?";
					$stmt2 = mysqli_prepare($mysqli, $sql2);
					mysqli_stmt_bind_param($stmt2, "i", $IDfirmatutor_ora);
					mysqli_stmt_execute($stmt2);
					mysqli_stmt_bind_result($stmt2, $ID_ora_tutor, $argomento_ora_tutor, $compitiassegnati_ora_tutor);
					mysqli_stmt_store_result($stmt2);
					while (mysqli_stmt_fetch($stmt2)) {
					}
					$return['argomento_ora_tutor'] = $argomento_ora_tutor;

					if ($argomento_ora_tutor == NULL && $argomento_ora != NULL)
					{
							// $sql3 = "UPDATE tab_orario SET argomento_ora = '".$argomento_ora."', firma_mae_ora =".$firma_mae_ora." WHERE ID_ora= ".$ID_ora_tutor.";";
							$sql3 = "UPDATE tab_orario SET argomento_ora = '".$argomento_ora."' WHERE ID_ora= ".$ID_ora_tutor.";";

							$stmt = mysqli_prepare($mysqli, $sql3);
							mysqli_stmt_execute($stmt);

							$return['test2'] = 'fatto UPDATE argomento tutor con sql3:'.$sql3;

					}
					if ($compitiassegnati_ora_tutor == NULL && $compitiassegnati_ora != NULL)
					{
							// $sql4 = "UPDATE tab_orario SET compitiassegnati_ora = '".$compitiassegnati_ora."', firma_mae_ora =".$firma_mae_ora."  WHERE ID_ora= ".$ID_ora_tutor.";";
							$sql4 = "UPDATE tab_orario SET compitiassegnati_ora = '".$compitiassegnati_ora."'  WHERE ID_ora= ".$ID_ora_tutor.";";

							$stmt = mysqli_prepare($mysqli, $sql4);
							mysqli_stmt_execute($stmt);

							$return['test3'] = 'fatto UPDATE compitiassegnati tutor con sql4'.$sql4;
					}
				

				}



				//CASO PLURICLASSE: UN INSEGNANTE STA INSEGNANDO IN PIU' CLASSI

				//Se è così la firma deve essere messa anche nelle altre ID_ora!
				//trovo quindi l'ora e la data corrispondente a ID_ora (quella per cui si sta firmando)
				$sql = "SELECT data_ora, ora_ora FROM tab_orario WHERE ID_ora = ? ; ";
				$stmt = mysqli_prepare($mysqli, $sql);
				mysqli_stmt_bind_param($stmt, "i", $ID_ora);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $data_ora, $ora_ora);
				while (mysqli_stmt_fetch($stmt)) {
				}

					
				//ora trovo le eventuali altre lezioni dello stesso maestro in altre classi

				$sql = "SELECT ID_ora FROM tab_orario WHERE ID_mae_ora = ? AND ora_ora = ? AND data_ora = ? AND ID_ora <> ?; ";
					$return['test'] =$ID_mae_ora." ".$ora_ora." ".$data_ora." ".$ID_ora." ".$sql;
				$stmt = mysqli_prepare($mysqli, $sql);
				mysqli_stmt_bind_param($stmt, "iisi", $ID_mae_ora, $ora_ora, $data_ora, $ID_ora);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $ID_ora);
				mysqli_stmt_store_result($stmt);
				$return['altrelezionitrovate'] = "nessun'altra lezione nella stessa ora dello stesso maestro";
				while (mysqli_stmt_fetch($stmt)) {
					$return['altrelezionitrovate'] = "ATTENZIONE: TROVATE ALTRE LEZIONI NELLA STESSA ORA DELLO STESSO MAESTRO";
					
					$sql1 = "UPDATE tab_orario SET firma_mae_ora = ? , assente_ora = ? , supplente_ora = ? , maestroreale_ora = ?, datafirma_ora= now(), argomento_ora= ?, compitiassegnati_ora= ? WHERE ID_ora = ? ; ";
					$stmt1 = mysqli_prepare($mysqli, $sql1);
					mysqli_stmt_bind_param($stmt1, "iiiissi", $firma_mae_ora, $assente_ora, $supplente_ora, $maestroreale_ora, $argomento_ora, $compitiassegnati_ora, $ID_ora);
					mysqli_stmt_execute($stmt1);

					//MANCHEREBBE IL CASO DI UNA PLURICLASSE DI UN TUTORATO
				}
				
	
	
	$return['sql'] = $sql;
	echo json_encode($return);
?>
