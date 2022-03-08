<?include_once("database/databaseii.php");
	$nome_mae_new = $_POST['nome_mae_new'];
	$cognome_mae_new = $_POST['cognome_mae_new'];
	if ($_POST['datanascita_mae_new'] == "") {
		$datanascita_mae_new= "1900-01-01";
	} else {
		$datanascita_mae_new = date('Y-m-d', strtotime(str_replace('/','-', $_POST['datanascita_mae_new']))); ;
	}
	$comunenascita_mae_new = $_POST['comunenascita_mae_new'];
	$provnascita_mae_new = $_POST['provnascita_mae_new'];
	$paesenascita_mae_new = $_POST['paesenascita_mae_new'];
	$cf_mae_new = $_POST['cf_mae_new'];
	$mf_mae_new = $_POST['mf_mae_new'];
	$indirizzo_mae_new = $_POST['indirizzo_mae_new'];
	$citta_mae_new = $_POST['citta_mae_new'];
	$prov_mae_new = $_POST['prov_mae_new'];
	$paese_mae_new = $_POST['paese_mae_new'];
	$CAP_mae_new = $_POST['CAP_mae_new'];
	if ($CAP_mae_new == "") {$CAP_mae_new = 0 ;}
	$titolo_mae_new = $_POST['titolo_mae_new'];
	$telefono_mae_new = $_POST['telefono_mae_new'];
	$email_mae_new = $_POST['email_mae_new'];
	$note_mae_new = $_POST['note_mae_new'];
	$selectlogin = $_POST['selectlogin'];
	$selecttipo = $_POST['selecttipo'];
	//Inizialmente inserivo un utente ogni volta che inserivo un maestro:
	//ora invece PRIMA va inserito un utente e poi va pescato un utente tra quelli non ancora associati, per associarlo a un maestro nuovo che si sta inserendo
	//quindi quanto segue non serve più
	//$passwordbase = '$2y$10$iqyrDkUiAvWOvXkt9FGW5uifZ3weh6mxqR7YttMQj8DeoCvn3TMeq';
	//inserisco prima in tabella utenti un nuovo utente, che sarà un maestro e quindi ne estraggo la ID_usr
	//$sql = "INSERT INTO tab_users (login_usr, password_usr, role_usr, pwdlastchange_usr) VALUES ('".$login_usr_new."', '".$passwordbase."', 2, ".time().");";
	//$stmt = mysqli_prepare($mysqli, $sql);
	//mysqli_stmt_execute($stmt);
	//estraggo la ID dell'ultimo
	//$sql2 = "SELECT ID_usr FROM tab_users WHERE login_usr = ?;";
	//$stmt2 = mysqli_prepare($mysqli, $sql2);
	//mysqli_stmt_bind_param($stmt, "s", $login_usr_new);
	//mysqli_stmt_execute($stmt2);
	//mysqli_stmt_bind_result($stmt2, $ID_usr_mae);
	//while (mysqli_stmt_fetch($stmt2)) {
	//}
	$sql3 = "INSERT INTO tab_anagraficamaestri (ID_usr_mae, tipo_per, nome_mae, cognome_mae, indirizzo_mae, citta_mae, CAP_mae, prov_mae, paese_mae, mf_mae, cf_mae, datanascita_mae, comunenascita_mae, provnascita_mae, paesenascita_mae, titolo_mae, telefono_mae, email_mae, note_mae ) ".
	" VALUES (".$selectlogin.", ".$selecttipo.", '".$nome_mae_new."', '".$cognome_mae_new."', '".$indirizzo_mae_new."', '".$citta_mae_new."', ".$CAP_mae_new.", '".$prov_mae_new."', '".$paese_mae_new."', '".$mf_mae_new."', '".$cf_mae_new."', '".$datanascita_mae_new."', '".$comunenascita_mae_new."', '".$provnascita_mae_new."', '".$paesenascita_mae_new."', '".$titolo_mae_new."', '".$telefono_mae_new."', '".$email_mae_new."', '".$note_mae_new."' )";
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_execute($stmt3);
	$return['msg'] = "Inserimento Anagrafica maestro andato a buon fine";
	$return['ID_usr_mae'] = $ID_usr_mae;
	$return['nome_mae_new'] = $nome_mae_new;
	$return['sql'] = $sql;
	$return['sql2'] = $sql2;
	$return['sql3'] = $sql3;
	$return['test'] = $datanascita_mae_new;
	echo json_encode($return);
?>
