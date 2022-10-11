<?
//ob_start(); //per usare il redirect alla index page quando uno si logga incorrectly
//session_start();


	function loggedin(){
		if (isset($_SESSION['ID_usr']) && !empty ($_SESSION['ID_usr'])){
			return true;
		} else{
			return false;
		}
	}

	function setSessionPar ($parametro) {
		global $mysqli;
		$sql = "SELECT val_par FROM tab_parametri WHERE parname_par = ? ";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "s", $parametro);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $val_par);			
		while (mysqli_stmt_fetch($stmt)) {
		}
		
		$_SESSION[$parametro] = $val_par;
	}


	function getPar ($parametro) {
		global $mysqli;
		$sql = "SELECT val_par FROM tab_parametri WHERE parname_par = ? ";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "s", $parametro);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $val_par);			
		while (mysqli_stmt_fetch($stmt)) {
		}
		return $val_par;
	}

	function timestamp_to_ggmmaaaa($date){
		if (($date == "0000-00-00") || ($date == "1900-01-01") || ($date == NULL)){
			return "";
		} else {
			list($year, $month, $day) = explode('-',$date);      
			return $day . '/' . $month . '/' . $year;	
		}
	}

	function timestamp_to_ggmmaa($date){
		if (($date == "0000-00-00") || ($date == "1900-01-01") || ($date == NULL)){
			return "";
		} else {
			list($year, $month, $day) = explode('-',$date);
			$yr = substr($year, -2);
			return $day . '/' . $month . '/' . $yr;	
		}
	}




	function getAnnoScolastico ($data) {
		// //estraggo l'anno scolastico di cui fa parte la data
		// $sql3 = "SELECT annoscolastico_asc FROM tab_anniscolastici WHERE datainizio_asc <= ? AND datafine_asc > ?";
		// //attenzione: d'estate questa query non darà risultati! ci vorrebbe anche una datafineanno diversa da datafine_asc!
		// $stmt3 = mysqli_prepare($mysqli, $sql3);
		// mysqli_stmt_bind_param($stmt3,  "ss", $data, $data);
		// mysqli_stmt_execute($stmt3);
		// mysqli_stmt_bind_result($stmt3, $annoscolastico_asc);
		// while (mysqli_stmt_fetch($stmt3)) {
		// }

		//ecco invece un modo che dà risultato sempre:
		$annoj = substr($data,0,4);
		$mesej = substr($data,5,2);
		if (intval($mesej) < 9) {$annoj = intval($annoj) -1;} //fino al 31/08 è anno - 1
		$annojsucc=$annoj+1;
		$annojsucc = strval($annojsucc);
		$annojsucc = substr($annojsucc, -2);
		$annoscolastico = $annoj."-".$annojsucc;
		return $annoscolastico;
	}

	function getASELME ($classe) {
		global $mysqli;
		$sql = "SELECT aselme_cls FROM tab_classi WHERE classe_cls = ? ";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "s", $classe);	
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $aselme);
		while (mysqli_stmt_fetch($stmt))
		{}
		return $aselme; 
	}

	function getTipoPagella1 ($annoscolastico, $aselme) {
		global $mysqli;
		$sql = "SELECT val_paa FROM tab_parametrixanno WHERE annoscolastico_paa = ? AND parname_paa = 'tipopagella_" .$aselme."';";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "s", $annoscolastico);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $tipopagella1);
		while (mysqli_stmt_fetch($stmt)) 
		{}
		return $tipopagella1;
	}
?>