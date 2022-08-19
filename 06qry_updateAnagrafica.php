<?include_once("database/databaseii.php");

	//campi di tab_anagraficaalunni
	$ID_alu =  $_POST['ID_alu'];
	$nome_alu = $_POST['nome_alu'];
	$cognome_alu = $_POST['cognome_alu'];
	$mf_alu = $_POST['mf_alu'];
	$indirizzo_alu = $_POST['indirizzo_alu'];
	$citta_alu = $_POST['citta_alu'];
	$CAP_alu = $_POST['CAP_alu'];
	$prov_alu = strtoupper($_POST['prov_alu']);
	$paese_alu = strtoupper($_POST['paese_alu']);
	$cf_alu = strtoupper($_POST['cf_alu']);
	$datanascita_alu = $_POST['datanascita_alu'];
	$datanascita_alu = date('Y-m-d', strtotime(str_replace('/','-', $datanascita_alu)));
	$comunenascita_alu = $_POST['comunenascita_alu'];
	$provnascita_alu = strtoupper($_POST['provnascita_alu']);
	$paesenascita_alu = strtoupper($_POST['paesenascita_alu']);
	$cittadinanza_alu = $_POST['cittadinanza_alu'];
	$scuolaprimaprovenienza_alu= $_POST['scuolaprimaprovenienza_alu'];
	$indirizzoscprimaproven_alu= $_POST['indirizzoscprimaproven_alu'];
	$scuolaprovenienza_alu= $_POST['scuolaprovenienza_alu'];
	$indirizzoscproven_alu= $_POST['indirizzoscproven_alu'];
	$ckautfoto_alu= $_POST['ckautfoto_alu'];
	$ckautmateriale_alu= $_POST['ckautmateriale_alu'];
	$ckautuscite_alu= $_POST['ckautuscite_alu'];
	$ckautuscitaautonoma_alu= $_POST['ckautuscitaautonoma_alu'];
	$ckdoposcuola_alu= $_POST['ckdoposcuola_alu'];

	$cktrasportopubblico_alu= $_POST['cktrasportopubblico_alu'];
	$ckmensa_alu= $_POST['ckmensa_alu'];
	$ckreligione_alu= $_POST['ckreligione_alu'];
	$altreligione_alu= $_POST['altreligione_alu'];

	$note_alu = $_POST['note_alu'];
	$img_alu = $_POST['img_alu'];
	$disabilita_alu= $_POST['disabilita_alu'];
	$dettaglidisabilita_alu= $_POST['dettaglidisabilita_alu'];
	$DSA_alu= $_POST['DSA_alu'];
	$autfoto_alu = $_POST['autfoto_alu'];



	

	$sql = "UPDATE tab_anagraficaalunni SET ".
	" nome_alu = ? ,".
	" cognome_alu = ? ,".
	" mf_alu = ? ,".
	" indirizzo_alu = ? ,".
	" citta_alu = ? ,".
	" CAP_alu = ? ,".
	" prov_alu = ? ,".
	" paese_alu = ? ,".
	" cf_alu = ? ,".
	" datanascita_alu = ? ,".
	" comunenascita_alu = ? ,".
	" provnascita_alu = ? ,".
	" paesenascita_alu = ? ,".
	" cittadinanza_alu = ? ,".
	" note_alu = ? ,".
	" img_alu = ? ,".
	" disabilita_alu = ? ,".
	" dettaglidisabilita_alu = ? ,".
	" DSA_alu = ? ,".
	" autfoto_alu = ? ,".
	" scuolaprimaprovenienza_alu = ? ,".
	" indirizzoscprimaproven_alu = ? ,".
	" scuolaprovenienza_alu = ? ,".
	" indirizzoscproven_alu = ? ,".
	" ckautfoto_alu = ? ,".
	" ckautmateriale_alu = ? ,".
	" ckautuscite_alu = ? ,".


	" cktrasportopubblico_alu = ? ,".
	" ckmensa_alu = ? ,".
	" ckreligione_alu = ? ,".
	" altreligione_alu = ? ,".

	" ckautuscitaautonoma_alu = ? ,".
	" ckdoposcuola_alu = ? ".
	" WHERE ID_alu = ? ;";	

	//$sql = "UPDATE tab_anagraficaalunni SET ".
	//" nome_alu = '".$nome_alu."' ,".
	//" cognome_alu =  '".$cognome_alu."' ,".
	//" mf_alu = '".$mf_alu."' ,".
	//" indirizzo_alu = '".$indirizzo_alu."' ,".
	//" citta_alu = '".$citta_alu."' ,".
	//" CAP_alu = '".$CAP_alu."' ,".
	//" prov_alu = '".$prov_alu."' ,".
	//" paese_alu = '".$paese_alu."' ,".
	//" cf_alu = '".$cf_alu."' ,".
	//" datanascita_alu = '".$datanascita_alu."' ,".
	//" comunenascita_alu = '".$comunenascita_alu."' ,".
	//" provnascita_alu = '".$provnascita_alu."' ,".
	//" paesenascita_alu = '".$paesenascita_alu."' ,".
	//" note_alu = '".$note_alu."' ,".
	//" img_alu = '".$img_alu."' ,".
	//" autfoto_alu = ".$autfoto_alu.",".
	//" scuolaprovenienza_alu = '".$scuolaprovenienza_alu."' ,".
	//" indirizzoscproven_alu = '".$indirizzoscproven_alu."' ,".
	//" ckautfoto_alu = ".$ckautfoto_alu." ,".
	//" ckautmateriale_alu = ".$ckautmateriale_alu." ,".
	//" ckautuscite_alu = ".$ckautuscite_alu." ".
	//" WHERE ID_alu = ? ;";
	
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssssssssssssssssisiissssiiiiiiiiii", $nome_alu, $cognome_alu, $mf_alu, $indirizzo_alu, $citta_alu, $CAP_alu, $prov_alu, $paese_alu, $cf_alu, $datanascita_alu, $comunenascita_alu, $provnascita_alu, $paesenascita_alu, $cittadinanza_alu, $note_alu, $img_alu, $disabilita_alu, $dettaglidisabilita_alu, $DSA_alu, $autfoto_alu, $scuolaprimaprovenienza_alu, $indirizzoscprimaproven_alu, $scuolaprovenienza_alu, $indirizzoscproven_alu, $ckautfoto_alu, $ckautmateriale_alu, $ckautuscite_alu, $cktrasportopubblico_alu , $ckmensa_alu, $ckreligione_alu ,$altreligione_alu, $ckautuscitaautonoma_alu, $ckdoposcuola_alu, $ID_alu);
	//mysqli_stmt_bind_param($stmt, "i", $ID_alu);
	mysqli_stmt_execute($stmt);

	//campi di tab_famiglie
	$intestazionefatt_fam = $_POST['intestazionefatt_fam'];

	$nomemadre_fam = $_POST['nomemadre_fam'];
	$cognomemadre_fam = $_POST['cognomemadre_fam'];
	$telefonomadre_fam = $_POST['telefonomadre_fam'];
	$altrotelmadre_fam = $_POST['altrotelmadre_fam'];
	$emailmadre_fam = strtolower($_POST['emailmadre_fam']);
	$sociomadre_fam = $_POST['sociomadre'];
	$nomepadre_fam = $_POST['nomepadre_fam'];
	$cognomepadre_fam = $_POST['cognomepadre_fam'];
	$telefonopadre_fam = $_POST['telefonopadre_fam'];
	$altrotelpadre_fam = $_POST['altrotelpadre_fam'];
	$emailpadre_fam = strtolower($_POST['emailpadre_fam']);
	$sociopadre_fam = $_POST['sociopadre'];

	$datanascitapadre_fam= $_POST['datanascitapadre_fam'];
	if ($datanascitapadre_fam != "") {
		$datanascitapadre_fam = date('Y-m-d', strtotime(str_replace('/','-', $datanascitapadre_fam)));
	} else {
		$datanascitapadre_fam = '1900-01-01';
	}
	
	//gli addslahses servono nelle SQL del tipo "SET campo = '".$valore."'"
	//mentre non vanno inseriti nelle SQL del tipo "SET campo = ?"
	//ucwords mette la prima Capital di ogni parola
	//strtolower e strtoupper fanno minuscolo e maiuscolo ogni lettera
	
	$comunenascitapadre_fam= $_POST['comunenascitapadre_fam'];
	$provnascitapadre_fam=  strtoupper($_POST['provnascitapadre_fam']);
	$paesenascitapadre_fam= strtoupper($_POST['paesenascitapadre_fam']);
	$cfpadre_fam = strtoupper($_POST['cfpadre_fam']);
	$indirizzopadre_fam= $_POST['indirizzopadre_fam'];
	
	$comunepadre_fam= $_POST['comunepadre_fam'];
	$provpadre_fam= strtoupper($_POST['provpadre_fam']);
	$paesepadre_fam= strtoupper($_POST['paesepadre_fam']);
	$CAPpadre_fam= $_POST['CAPpadre_fam'];
	$titolopadre_fam= $_POST['titolopadre_fam'];
	$profpadre_fam= $_POST['profpadre_fam'];

	$datanascitamadre_fam= $_POST['datanascitamadre_fam'];
	if ($datanascitamadre_fam != "") {
		$datanascitamadre_fam = date('Y-m-d', strtotime(str_replace('/','-', $datanascitamadre_fam)));
	} else {
		$datanascitamadre_fam = '1900-01-01';
	}
	$comunenascitamadre_fam= $_POST['comunenascitamadre_fam'];
	$provnascitamadre_fam=  strtoupper($_POST['provnascitamadre_fam']);
	$paesenascitamadre_fam= strtoupper($_POST['paesenascitamadre_fam']);
	$cfmadre_fam = strtoupper($_POST['cfmadre_fam']);
	$indirizzomadre_fam= $_POST['indirizzomadre_fam'];
	$comunemadre_fam= $_POST['comunemadre_fam'];
	$provmadre_fam= strtoupper($_POST['provmadre_fam']);
	$paesemadre_fam= strtoupper($_POST['paesemadre_fam']);
	$CAPmadre_fam= $_POST['CAPmadre_fam'];
	$titolomadre_fam= $_POST['titolomadre_fam'];
	$profmadre_fam= $_POST['profmadre_fam'];
	
	$imgpadre_fam = $_POST['imgpadre_fam'];
	$imgmadre_fam = $_POST['imgmadre_fam'];

	$notemadre_fam = $_POST['notemadre_fam'];
	$notepadre_fam = $_POST['notepadre_fam'];

	$ibanmadre_fam = strtoupper($_POST['ibanmadre_fam']);
	$ibanpadre_fam = strtoupper($_POST['ibanpadre_fam']);

	$rapprmadre_fam = $_POST['rapprmadre_fam'];
	$rapprpadre_fam = $_POST['rapprpadre_fam'];

	//ora aggiorno i campi di tab_famiglie
	$sql2 = "SELECT ID_fam_alu FROM tab_anagraficaalunni WHERE ID_alu = ? ;";
	$stmt2 = mysqli_prepare($mysqli, $sql2);
	mysqli_stmt_bind_param($stmt2, "i", $ID_alu);
	mysqli_stmt_execute($stmt2);
	mysqli_stmt_bind_result($stmt2, $ID_fam_alu);
	while (mysqli_stmt_fetch($stmt2)) {
	}
	
	$sql3 = "UPDATE tab_famiglie SET ".
	"nomemadre_fam = ? , ".
	"cognomemadre_fam = ? , ".
	"telefonomadre_fam = ? , ".
	"altrotelmadre_fam = ? , ".
	"emailmadre_fam = ? , ".
	"sociomadre_fam = ? , ".
	"nomepadre_fam = ? , ".
	"cognomepadre_fam = ? , ".
	"cognome_fam = ? , ".
	"telefonopadre_fam = ? , ".
	"altrotelpadre_fam = ? , ".
	"emailpadre_fam = ? , ".
	"sociopadre_fam = ? , ".
	"datanascitapadre_fam = ? , ".
	"comunenascitapadre_fam = ? , ".
	"provnascitapadre_fam = ? , ".
	"paesenascitapadre_fam = ? , ".
	"cfpadre_fam = ? , ".
	"indirizzopadre_fam = ? , ".
	"comunepadre_fam = ? , ".
	"provpadre_fam = ? , ".
	"paesepadre_fam = ? , ".
	"CAPpadre_fam = ? , ".
	"titolopadre_fam = ? , ".
	"profpadre_fam = ? , ".
	"datanascitamadre_fam = ? , ".
	"comunenascitamadre_fam = ? , ".
	"provnascitamadre_fam = ? , ".
	"paesenascitamadre_fam = ? , ".
	"cfmadre_fam = ? , ".
	"indirizzomadre_fam = ? , ".
	"comunemadre_fam = ? , ".
	"provmadre_fam = ? , ".
	"paesemadre_fam = ? , ".
	"CAPmadre_fam = ? , ".
	"titolomadre_fam = ? , ".
	"profmadre_fam = ? ,".
	"imgmadre_fam = ? ,".
	"imgpadre_fam = ? ,".
	"notemadre_fam = ? ,".
	"notepadre_fam = ? ,".
	"intestazionefatt_fam = ?,".
	"ibanmadre_fam = ? ,".
	"ibanpadre_fam = ? ,".
	"rapprmadre_fam = ? ,".
	"rapprpadre_fam = ? ".

	"WHERE ID_fam  = ? ;";
	
	// $sql3 = "UPDATE tab_famiglie SET ".
	// "nomemadre_fam = '".$nomemadre_fam."' , ".
	// "cognomemadre_fam = '".$cognomemadre_fam."'  , ".
	// "telefonomadre_fam = '".$telefonomadre_fam."'  , ".
	// "altrotelmadre_fam = '".$altrotelmadre_fam."'  , ".
	// "emailmadre_fam = '".$emailmadre_fam."'  , ".
	// "sociomadre_fam = ".$sociomadre_fam."  , ".
	// "nomepadre_fam = '".$nomepadre_fam."' , ".
	// "cognomepadre_fam = '".$cognomepadre_fam."'  , ".
	// "telefonopadre_fam = '".$telefonopadre_fam."'  , ".
	// "altrotelpadre_fam = '".$altrotelpadre_fam."'  , ".
	// "emailpadre_fam = '".$emailpadre_fam."'  , ".
	// "sociopadre_fam = ".$sociopadre_fam."  , ".
	// "datanascitapadre_fam = '".$datanascitapadre_fam."'  , ".
	// "comunenascitapadre_fam = '".$comunenascitapadre_fam."'  , ".
	// "provnascitapadre_fam = '".$provnascitapadre_fam."'  , ".
	// "paesenascitapadre_fam = '".$paesenascitapadre_fam."'  , ".
	// "cfpadre_fam = '".$cfpadre_fam."'  , ".
	// "indirizzopadre_fam = '".$indirizzopadre_fam."'  , ".
	// "comunepadre_fam = '".$comunepadre_fam."'  , ".
	// "provpadre_fam = '".$provpadre_fam."'  , ".
	// "paesepadre_fam = '".$paesepadre_fam."'  , ".
	// "CAPpadre_fam = '".$CAPpadre_fam."'  , ".
	// "titolopadre_fam = '".$titolopadre_fam."'  , ".
	// "profpadre_fam = '".$profpadre_fam."'  , ".
	// "datanascitamadre_fam = '".$datanascitamadre_fam."'  , ".
	// "comunenascitamadre_fam = '".$comunenascitamadre_fam."'  , ".
	// "provnascitamadre_fam = '".$provnascitamadre_fam."'  , ".
	// "paesenascitamadre_fam = '".$paesenascitamadre_fam."'  , ".
	// "cfmadre_fam = '".$cfmadre_fam."'  , ".
	// "indirizzomadre_fam = '".$indirizzomadre_fam."'  , ".
	// "comunemadre_fam = '".$comunemadre_fam."'  , ".
	// "provmadre_fam = '".$provmadre_fam."'  , ".
	// "paesemadre_fam = '".$paesemadre_fam."'  , ".
	// "CAPmadre_fam = '".$CAPmadre_fam."'  , ".
	// "titolomadre_fam = '".$titolomadre_fam."'  , ".
	// "profmadre_fam = '".$profmadre_fam."'  ".
	// "WHERE ID_fam  = ".$ID_fam_alu." ;";
	
	$stmt3 = mysqli_prepare($mysqli, $sql3);
	mysqli_stmt_bind_param($stmt3, "sssssissssssisssssssssssssssssssssssssssssssiii", $nomemadre_fam,	$cognomemadre_fam,	$telefonomadre_fam, $altrotelmadre_fam, $emailmadre_fam, $sociomadre_fam, $nomepadre_fam, $cognomepadre_fam, $cognomepadre_fam,$telefonopadre_fam, $altrotelpadre_fam, $emailpadre_fam, $sociopadre_fam, $datanascitapadre_fam, $comunenascitapadre_fam, $provnascitapadre_fam, $paesenascitapadre_fam, $cfpadre_fam, $indirizzopadre_fam, $comunepadre_fam, $provpadre_fam, $paesepadre_fam, $CAPpadre_fam, $titolopadre_fam, $profpadre_fam, $datanascitamadre_fam, $comunenascitamadre_fam, $provnascitamadre_fam, $paesenascitamadre_fam, $cfmadre_fam, $indirizzomadre_fam, $comunemadre_fam, $provmadre_fam, $paesemadre_fam, $CAPmadre_fam, $titolomadre_fam, $profmadre_fam, $imgmadre_fam, $imgpadre_fam, $notemadre_fam, $notepadre_fam, $intestazionefatt_fam, $ibanmadre_fam, $ibanpadre_fam, $rapprmadre_fam, $rapprpadre_fam, $ID_fam_alu);
	//mysqli_stmt_bind_param($stmt3, "i", $ID_fam_alu);
	mysqli_stmt_execute($stmt3);
	$return['msg'] = "Dati dell'alunno/a ". $nome_alu . " " . $cognome_alu ." aggiornati";
	$return['test'] = $sql3;
	echo json_encode($return);
?>
