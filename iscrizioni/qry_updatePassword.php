<? 
	include_once("../database/databaseii.php");
	$ID_usr = $_SESSION['ID_usr'];
	$ct_oldPassword = $_POST['ct_oldPassword'];
	$ct_newPassword = $_POST['ct_newPassword'];
	$ct_newPassword_again = $_POST['ct_newPassword_again'];
    if(!empty($ct_oldPassword)  &&
	   !empty($ct_newPassword)  &&
	   !empty($ct_newPassword_again)
	   ) {
		//$ct_password_hash = md5 ($ct_oldPassword);
		$ct_password_hash = password_hash ($ct_oldPassword, PASSWORD_BCRYPT);
		//prepara la clausola $pswlastchangestr
		$sql = "SELECT `password_usr` FROM ".$_SESSION['databaseB'].".`tab_users` WHERE `ID_usr` = ? ";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "i", $ID_usr);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $password_usrTMP);
		while (mysqli_stmt_fetch($stmt)) {
			//inserisce la password estratta dal db in $pswvalue
			$pswvalue = $password_usrTMP;
		}
		if (password_verify ($ct_oldPassword, $pswvalue)) {
			//la password vecchia è corretta
				if ($ct_newPassword==$ct_newPassword_again){
					//la password vecchia è corretta E le due password nuove coincidono
					if (!(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $ct_newPassword))){
						//la password vecchia è corretta E le due psw nuove coincidono E non contengono caratteri speciali
						if ($ct_newPassword!=$ct_oldPassword) {
							//la password vecchia è corretta E le due psw nuove coincidono E non contengono caratteri speciali E non è uguale alla psw nuova
							if(strlen(trim($ct_newPassword))>6){//posso procedere con l'update
								//la password vecchia è corretta E le due psw nuove coincidono E non contengono caratteri speciali E non è uguale alla psw nuova E sono più lunghe del minimo
								//$ct_newPassword_hash = md5 ($ct_newPassword);
								$ct_newPassword_hash = password_hash ($ct_newPassword, PASSWORD_BCRYPT);
								$sql = "UPDATE ".$_SESSION['databaseB'].".`tab_users` SET `password_usr` = ?, `pwdlastchange_usr` = now() WHERE `ID_usr` = ? ";
								$stmt = mysqli_prepare($mysqli, $sql);
								mysqli_stmt_bind_param($stmt, "si", $ct_newPassword_hash, $ID_usr);
								if (mysqli_stmt_execute($stmt)) {
									$return ['debug'] = 'ID_usr='.$ID_usr.' oldpsw='.$ct_oldPassword.' newpsw='.$ct_newPassword.' newpsw2='.$ct_newPassword_again.' sql='.$sql;
									$return['status'] = "success";
									$return['message'] = "OK";
								} else {
									$return ['debug'] = 'ID_usr='.$ID_usr.' oldpswdbhash='.$pswvalue.' oldpsw='.$ct_oldPassword.' newpsw='.$ct_newPassword.' newpswhash='.$ct_newPassword_hash.' sql='.$sql;
									$return['status'] = "fail";
									$return['message'] = "query di update non a buon fine";
								}
							} else {
								// psw più corta del minimo
								$return['status'] = "fail";
								$return['message'] = "La password deve essere più lunga di 6 caratteri";
							}
						} else{
							// psw più corta del minimo
							$return['status'] = "fail";
							$return['message'] = "La password nuova deve essere diversa da quella precedente";
						}
					} else {
						// trovati caratteri speciali nella stringa, non va bene
						$return['status'] = "fail";
						$return['message'] = "La password non deve contenere caratteri speciali, ma solo lettere e numeri";
					}
				} else {
					//la password nuova e la passwordagain non coincidono
					$return['status'] = "fail";
					$return['message'] = "La password nuova e la sua ripetizione non coincidono";
				}
		} else {
			//la password vecchia non è quella corretta
			$return['status'] = "fail";
			$return['message'] = "La password attuale non è corretta";
		}
        
    } else {
		$return['status'] = "fail";
		//uno dei tre campi non è stato compilato, come mando un messaggio di errore?
        echo "Inserire la password corrente e poi quella nuova due volte!";
    }
	echo json_encode($return);
?>