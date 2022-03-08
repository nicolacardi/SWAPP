<?include_once("database/databaseii.php");
	$ID_fam = $_POST['ID_fam_alu'];
	//dapprima si estrae il cognome_fam che servirà per comporre la userid
	$sql = "SELECT cognome_fam FROM tab_famiglie WHERE ID_fam = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $cognome_fam);
	$k =  0;
	while (mysqli_stmt_fetch($stmt)) {
		$k++;
	}
	//Il cognome va pulito da accenti, spazi e caratteri strani, servirà questa funzione, che sostituisce le lettere accentate
	function removeAccents($str) {
	  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
	  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
	  return str_replace($a, $b, $str);
	}
	if ($k !=0) {
		//verifico se già c'è lo user: NON FUNZIONA SE GIA' C'E' PERCHE' ID_usr_fam = 0 quando faccio la DELET + INSERT INTO di nuovo, 
		//quindi il risultato di questa SELECT sarà sempre 0
		//vado a modificare la SELECT INTO scrivendo la ID_usr_fam che c'era prima di cancellare quel record della tab_famiglie
		$sql1 = "SELECT ID_usr_fam, login_usr FROM ".$_SESSION['databaseB'].".tab_famiglie JOIN ".$_SESSION['databaseB'].".tab_users ON ID_usr =  ID_usr_fam WHERE ID_fam = ?";
		$stmt1 = mysqli_prepare($mysqli, $sql1);
		mysqli_stmt_bind_param($stmt1, "i", $ID_fam);
		mysqli_stmt_execute($stmt1);
		mysqli_stmt_bind_result($stmt1, $ID_usr_fam, $login);
		
		$i =  0;
		while (mysqli_stmt_fetch($stmt1)) {
			$i++;
		}
		
		//Poichè la password non si può ripescare....quella va comunque rigenerata (caso $i != 0)
		if ($i==0) {
			$login = preg_replace('/\s+/', '', $cognome_fam); 	//toglie gli spazi (tipo Dal Zio)
			$login = preg_replace("/'/", '', $login); 			//toglie gli apostrofi (tipo Dell'Orto)
			$login = removeAccents($login); 					//toglie le lettere accentate (tipo Corrà)
			$login = strtolower ($login); 						//trasforma DalZio in dalzio	
			$login = $login. rand(1000,9999);					//aggiunge 4 numeri casuali dalzio->dalzio6674
			$password = rand(1000000,9999999);
			$ct_newPassword_hash = password_hash ($password, PASSWORD_BCRYPT);
			$sql = "INSERT INTO ".$_SESSION['databaseB'].".tab_users (login_usr, password_usr, role_usr, pwdlastchange_usr) VALUES ('".$login."','".$ct_newPassword_hash."', 9, now())";
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_execute($stmt);
			
			//trovo ultimo ID_user inserito
			$sql = "SELECT ID_usr FROM ".$_SESSION['databaseB'].".tab_users WHERE login_usr = '".$login."'";
			//QUERY PARAMETRICA DA FARE
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $ID_usr);
			$k =  0;
			while (mysqli_stmt_fetch($stmt)) {
				$k++;
			}
			
			//aggiorno il campo di collegamento ID_usr_fam di tab_famiglie con l'ID_usr appena inserito
			$sql = "UPDATE ".$_SESSION['databaseB'].".tab_famiglie SET ID_usr_fam = ".$ID_usr." WHERE ID_fam = ".$ID_fam;
			//QUERY PARAMETRICA DA FARE
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_execute($stmt);
		} else {
			//esiste già tutto, (è già stato inviato tutto in precedenza) ma la password non si può recuperare-> ne rigenero un'altra...
			$password = rand(1000000,9999999);
			$ct_newPassword_hash = password_hash ($password, PASSWORD_BCRYPT);
			$sql = "UPDATE ".$_SESSION['databaseB'].".tab_users  SET password_usr = ? WHERE ID_usr = ? ";
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_bind_param($stmt, "si", $ct_newPassword_hash, $ID_usr_fam);
			mysqli_stmt_execute($stmt);

		}
	}
	
	$return['login'] = $login;
	$return['psw'] = $password;
	$return['test']= $sql;
    echo json_encode($return);
	
?>
	
	
	