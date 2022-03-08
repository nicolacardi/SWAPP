<? 	class Famiglia {
		public $ID_fam;
		public $cognomepadre_fam;
		public $cognomemadre_fam;
	}

	function GetArrayCognomiFamiglie () {
		global $mysqli;
		$RetArray = array();
		$sql = "SELECT ID_fam, cognomepadre_fam, cognomemadre_fam FROM tab_famiglie ORDER BY cognomepadre_fam";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $ID_fam, $cognomepadre_fam, $cognomemadre_fam);

		while (mysqli_stmt_fetch($stmt)) {
			$MyFam = new  Famiglia();
			$MyFam->ID_fam = $ID_fam;
			$MyFam->cognomepadre_fam = $cognomepadre_fam;
			$MyFam->cognomemadre_fam = $cognomemadre_fam;
			array_push ($RetArray, $MyFam);
		}
		return ($RetArray);
	}
	

?>