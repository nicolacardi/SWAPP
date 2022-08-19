<?
include_once("../database/databaseBii.php");

$annoiscrizioni = 					$_SESSION['anno_iscrizioni'];
$ISC_include_SDD = 					$_SESSION['ISC_include_SDD'];
$ISC_mostra_sociovolontario=		$_SESSION['ISC_mostra_sociovolontario'];
$ISC_mostra_sceltareligione=		$_SESSION['ISC_mostra_sceltareligione'];
$ISC_mostra_regolpediatrico=		$_SESSION['ISC_mostra_regolpediatrico'];
$ISC_mostra_regolinterno=			$_SESSION['ISC_mostra_regolinterno'];
$ISC_mostra_dietespeciali=			$_SESSION['ISC_mostra_dietespeciali'];
$ISC_mostra_trasportopubblico=		$_SESSION['ISC_mostra_trasportopubblico'];
$ISC_mostra_mensa=					$_SESSION['ISC_mostra_mensa'];
$ISC_mostra_firmaunica=				$_SESSION['ISC_mostra_firmaunica'];
$ISC_mostra_intestazionefatt = 		$_SESSION['ISC_mostra_intestazionefatt'];
$ISC_mostra_carpooling = 			$_SESSION['ISC_mostra_carpooling'];
$ISC_mostra_tipopag =	 			$_SESSION['ISC_mostra_tipopag'];
$ISC_mostra_soci =					$_SESSION['ISC_mostra_soci'];
$ISC_mostra_quotaiscrizione =		$_SESSION['ISC_mostra_quotaiscrizione'];
$ISC_mostracinquepermille =			$_SESSION['ISC_mostracinquepermille'];
$ISC_mostra_premesso_che_lo_stato =	$_SESSION['ISC_mostra_premesso_che_lo_stato'];


//ISC_mostra_uscitaautonoma viene settato più avanti quando si conosce anche il valore di classe_cla

include_once("diciture.php");
include_once("settings_fpdf_Classi.php");
include_once("settings_fpdf_Base.php");

$pdf->SetStyleWriteTag("h1",    "TitilliumWeb-SemiBold",    "N",    $fontsizedefault,   0, 0);
$pdf->SetStyleWriteTag("n",     $fontdefault,               "N",    $fontsizedefault,   0, 0);
$pdf->SetStyleWriteTag("bu",     "TitilliumWeb-SemiBold",   "U",    $fontsizedefault,   0);
$pdf->SetStyleWriteTag("b",     "TitilliumWeb-SemiBold",    "N",    $fontsizedefault,   0);
$pdf->SetStyleWriteTag("a",     $fontdefault,               "BU",   $fontsizedefault,   "0,0,255");
$pdf->SetStyleWriteTag("bul",   $fontdefault,               "N",    $fontsizedefault,   0, 3, chr(149));

$annoscolastico = $_POST['annoscolastico'];


$anno1 = substr($_POST['annoscolastico'], 0, 4);
$anno2 = "20".substr($_POST['annoscolastico'], 5, 2);

//nel caso in cui si vogliano stampare tutti i moduli dell'anno (azione da parte della segereteria) si deve ciclare su tutti gli ID_fam
//in quel caso ID_fam è stato passato == 0

$ID_fam = $_POST['ID_fam'];
//$ID_fam = 12345678;    
if ($ID_fam == 0) {
	$ID_famA = unserialize($_POST['ID_famA']);
} else {
	$ID_famA[0] =$ID_fam;
}
//a questo punto si può ciclare, che si tratti di un solo elemento o di n

foreach ($ID_famA as $ID_fam) {

	$sql = "SELECT cognome_fam, sociopadre_fam, sociomadre_fam, cognomepadre_fam, nomepadre_fam, datanascitapadre_fam, comunenascitapadre_fam, provnascitapadre_fam, paesenascitapadre_fam, cfpadre_fam, indirizzopadre_fam, comunepadre_fam, CAPpadre_fam, provpadre_fam, paesepadre_fam, telefonopadre_fam, altrotelpadre_fam, emailpadre_fam, titolopadre_fam, profpadre_fam, sociomadre_fam, cognomemadre_fam, nomemadre_fam, datanascitamadre_fam, comunenascitamadre_fam, provnascitamadre_fam, paesenascitamadre_fam, cfmadre_fam, indirizzomadre_fam, comunemadre_fam, CAPmadre_fam, provmadre_fam, paesemadre_fam, telefonomadre_fam, altrotelmadre_fam, emailmadre_fam, titolomadre_fam, profmadre_fam, ckcarpoolingpadre_fam, ckcarpoolingmadre_fam, ckmadreesclusadanucleo_fam, ckpadreesclusodanucleo_fam 
	FROM tab_famiglie WHERE ID_fam= ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $cognome_fam, $sociopadre_fam, $sociomadre_fam, $cognomepadre_fam, $nomepadre_fam, $datanascitapadre_fam, $comunenascitapadre_fam, $provnascitapadre_fam, $paesenascitapadre_fam, $cfpadre_fam, $indirizzopadre_fam, $comunepadre_fam, $CAPpadre_fam, $provpadre_fam, $paesepadre_fam, $telefonopadre_fam, $altrotelpadre_fam, $emailpadre_fam, $titolopadre_fam, $profpadre_fam, $sociomadre_fam, $cognomemadre_fam, $nomemadre_fam, $datanascitamadre_fam, $comunenascitamadre_fam, $provnascitamadre_fam, $paesenascitamadre_fam, $cfmadre_fam, $indirizzomadre_fam, $comunemadre_fam, $CAPmadre_fam, $provmadre_fam, $paesemadre_fam, $telefonomadre_fam, $altrotelmadre_fam, $emailmadre_fam, $titolomadre_fam, $profmadre_fam, $ckcarpoolingpadre_fam, $ckcarpoolingmadre_fam, $ckmadreesclusadanucleo_fam, $ckpadreesclusodanucleo_fam);
	$n = 0;
	$blank = false;
	while (mysqli_stmt_fetch($stmt)) {
		$n++;
	
	}
	if ($n == 0) {$blank = true;} 


	$imgsquare = '../assets/img/square.png';
	$imgsquaremini = '../assets/img/squaremini.png';
	$imgsquarecrossed = '../assets/img/squarecrossed.png';
	$imgsquarecrossedmini = '../assets/img/squarecrossedmini.png';

	$pdf->AddPage();


	
	$pdf->SetFont('TitilliumWeb-SemiBold','',18);

	// $pdf->Cell(0,10,"annoiscrizioni:".$annoiscrizioni, 0,1, 'C');
	// $pdf->Cell(0,10,"ISC_include_SDD:".$ISC_include_SDD, 0,1, 'C');
	// $pdf->Cell(0,10,"ISC_mostra_sociovolontario:".$ISC_mostra_sociovolontario, 0,1, 'C');
	// $pdf->Cell(0,10,"ISC_mostra_sceltareligione:".$ISC_mostra_sceltareligione, 0,1, 'C');
	// $pdf->Cell(0,10,"ISC_mostra_trasportopubblico:".$ISC_mostra_trasportopubblico, 0,1, 'C');
	// $pdf->Cell(0,10,"ISC_mostra_mensa:".$ISC_mostra_mensa, 0,1, 'C');
	// $pdf->Cell(0,10,"ISC_mostra_firmaunica:".$ISC_mostra_firmaunica, 0,1, 'C');
	// $pdf->Cell(0,10,"ISC_mostra_intestazionefatt:".$ISC_mostra_intestazionefatt, 0,1, 'C');


	$pdf->Cell(0,8,"DOMANDA DI ISCRIZIONE", 0,1, 'C');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(0,7,"alla ".$nomecittascuola, 0,1, 'C');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(0,7,"Anno Scolastico ".$annoscolastico, 0,1, 'C');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(0,10,"I sottoscritti", 0,1, 'L');

	$pdf->SetFont($fontdefault,'',10);

$h1 = 6;

//DATI PADRE**********************************************************************************************************
	$pdf->SetFont('TitilliumWeb-SemiBold','',12);
	$pdf->Cell(70,$h1,"DATI ANAGRAFICI DEL PADRE",1,0,'L');
	$pdf->SetFont($fontdefault,'',10);


	if ($sociopadre_fam == 1) {
		if ($ISC_mostra_soci == 0) {
			$testo = "";
		} else {
			$testo = "Socio della ".$formagiuridica."     ".$pdf->Image($imgsquarecrossed,$pdf->GetX()+50, $pdf->GetY()+1,5);
		}
		$pdf->Cell(60,$h1,$testo,1,0,'L');
		$pdf->Cell(60,$h1,"",1,1,'L');
	}
	if ($sociopadre_fam == null) {
		if ($ISC_mostra_soci == 1) {
			$pdf->Cell(60,$h1,"Socio della ".$formagiuridica."     ".$pdf->Image($imgsquare,$pdf->GetX()+50, $pdf->GetY()+1,5),1,0,'L');
		} else {
			$pdf->Cell(60,$h1,"",1,0,'L');
		}
		if ($ISC_mostra_sociovolontario == 1) {
			$pdf->Cell(60,$h1,"Socio volontario     ".$pdf->Image($imgsquarecrossed,$pdf->GetX()+50, $pdf->GetY()+1,5),1,1,'L');
		} else {
			$pdf->Cell(60,$h1,"",1,1,'L');
		}
	}


	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Cognome",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,strtoupper($cognomepadre_fam),1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Nome",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,strtoupper($nomepadre_fam),1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Luogo di nascita",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,$comunenascitapadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Data di nascita",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	if($datanascitapadre_fam!='0000-00-00' && $datanascitapadre_fam!='1900-01-01' && $datanascitapadre_fam!= NULL) {
		$datanascitapadre_fam = date('d/m/Y', strtotime(str_replace('-','/', $datanascitapadre_fam)));
	} 
	else{
		$datanascitapadre_fam = "";
	}

	$pdf->Cell(150,$h1,$datanascitapadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Paese di nascita",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,$paesenascitapadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Codice Fiscale",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,$cfpadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Residenza",'LTR',0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,utf8_decode($indirizzopadre_fam),1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,$h1,"",'LBR',0,'L');
	$pdf->Cell(30,$h1,$CAPpadre_fam,1,0,'L');
	$pdf->Cell(90,$h1,$comunepadre_fam,1,0,'L');
	$pdf->Cell(30,$h1,$provpadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Recapiti telefonici",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(75,$h1,$telefonopadre_fam,1,0,'L');
	$pdf->Cell(75,$h1,$altrotelpadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Indirizzo e-mail",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,$emailpadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Titolo di Studio",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,$titolopadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Professione",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,$profpadre_fam,1,1,'L');
	$pdf->Ln(2);

//Firma per CarPooling ***********************************************************************************************
	if ($ISC_mostra_carpooling == 1 && $ckcarpoolingpadre_fam == 1) {

		$pdf->SetFont($fontdefault,'',8);
		$pdf->Cell(115,4,"PROGETTO CAR-POOLING","LTR",0, 'L');
		$pdf->Cell(75,4,"Firma del Padre/Tutore","LTR",1, 'C');
		$pdf->Cell(115,4,"Autorizzo espressamente la Scuola a fornire ad altri genitori che abbiano aderito come me","LR",0,'L');
		$pdf->Cell(75,4,"","LR",1, 'L');
		$pdf->Cell(115,4,"indirizzo, numero telefonico e email del Padre","LBR",0,'L');
		$pdf->Cell(75,4,"","LBR",1, 'L');
		$pdf->Image('../assets/img/Icone/frecciafirmablack.png', 120, $pdf->GetY()-18, 20);
	}

	$pdf->SetY(165);
//DATI MADRE**********************************************************************************************************
	$pdf->SetFont('TitilliumWeb-SemiBold','',12);
	$pdf->Cell(70,$h1,"DATI ANAGRAFICI DELLA MADRE",1,0,'L');

	$pdf->SetFont($fontdefault,'',12);
	if ($sociomadre_fam == 1) {
		if ($ISC_mostra_soci == 0) {
			$testo = "Socia della ".$formagiuridica."     ".$pdf->Image($imgsquarecrossed,$pdf->GetX()+52, $pdf->GetY()+1,5);
		} else {
			$testo = "";
		}
		$pdf->Cell(60,$h1,$testo,1,0,'L');
		$pdf->Cell(60,$h1,"",1,1,'L');
	}

	if ($sociomadre_fam == null) {
		if ($ISC_mostra_soci == 1) {
			$pdf->Cell(60,$h1,"Socia della ".$formagiuridica."     ".$pdf->Image($imgsquare,$pdf->GetX()+52, $pdf->GetY()+1,5),1,0,'L');
		}else {
			$pdf->Cell(60,$h1,"",1,0,'L');
		}

		if ($ISC_mostra_sociovolontario == 1) {
			$pdf->Cell(60,$h1,"Socia volontaria     ".$pdf->Image($imgsquare,$pdf->GetX()+50, $pdf->GetY()+1,5),1,1,'L');
		} else {
			$pdf->Cell(60,$h1,"",1,1,'L');
		}
	}

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Cognome",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,strtoupper($cognomemadre_fam),1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Nome",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,strtoupper($nomemadre_fam),1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Luogo di nascita",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,$comunenascitamadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Data di nascita",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	if($datanascitamadre_fam!='0000-00-00' && $datanascitamadre_fam!='1900-01-01' && $datanascitamadre_fam!= NULL) {$datanascitamadre_fam = date('d/m/Y', strtotime(str_replace('-','/', $datanascitamadre_fam)));} else {$datanascitamadre_fam = "";}
	$pdf->Cell(150,$h1,$datanascitamadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Paese di nascita",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,$paesenascitamadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Codice Fiscale",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,$cfmadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Residenza",'LTR',0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,utf8_decode($indirizzomadre_fam),1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,$h1,"",'LBR',0,'L');
	$pdf->Cell(30,$h1,$CAPmadre_fam,1,0,'L');
	$pdf->Cell(90,$h1,$comunemadre_fam,1,0,'L');
	$pdf->Cell(30,$h1,$provmadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Recapiti telefonici",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(75,$h1,$telefonomadre_fam,1,0,'L');
	$pdf->Cell(75,$h1,$altrotelmadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Indirizzo e-mail",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,$emailmadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Titolo di Studio",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,$titolomadre_fam,1,1,'L');

	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(40,$h1,"Professione",1,0,'L');
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(150,$h1,$profmadre_fam,1,1,'L');
	
	$pdf->Ln(2);

//Firma per CarPooling ***********************************************************************************************
	if ($ISC_mostra_carpooling == 1 && $ckcarpoolingmadre_fam == 1) {

		$pdf->SetFont($fontdefault,'',8);
		$pdf->Cell(115,4,"PROGETTO CAR-POOLING","LTR",0, 'L');
		$pdf->Cell(75,4,"Firma della Madre/Tutore","LTR",1, 'C');
		$pdf->Cell(115,4,"Autorizzo espressamente la Scuola a fornire ad altri genitori che abbiano aderito come me","LR",0,'L');
		$pdf->Cell(75,4,"","LR",1, 'L');
		$pdf->Cell(115,4,"indirizzo, numero telefonico e email della Madre","LBR",0,'L');
		$pdf->Cell(75,4,"","LBR",1, 'L');
		$pdf->Image('../assets/img/Icone/frecciafirmablack.png', 120, $pdf->GetY()-18, 20);
	}

//DATI E CALL PAGINA/E ALUNNI ****************************************************************************************
	$sql = "SELECT ID_alu, mf_alu, nome_alu, cognome_alu, datanascita_alu, comunenascita_alu, provnascita_alu, paesenascita_alu, cittadinanza_alu, cf_alu, indirizzo_alu, citta_alu, CAP_alu, prov_alu, paese_alu, disabilita_alu, DSA_alu, ckprivacy1_alu, ckprivacy2_alu, ckprivacy3_alu, ckautfoto_alu, ckautmateriale_alu, ckautuscite_alu, ckautuscitaautonoma_alu, ckdoposcuola_alu, ckreligione_alu, altreligione_alu, ckmensa_alu, cktrasportopubblico_alu, scuolaprovenienza_alu, indirizzoscproven_alu, classe_cla FROM (tab_famiglie JOIN tab_anagraficaalunni ON ID_fam_alu = ID_fam) JOIN tab_classialunni ON ID_alu = ID_alu_cla WHERE ID_fam= ? AND noniscritto_alu = 0 ORDER BY datanascita_alu ASC";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu, $mf_alu, $nome_alu, $cognome_alu, $datanascita_alu, $comunenascita_alu, $provnascita_alu, $paesenascita_alu, $cittadinanza_alu, $cf_alu, $indirizzo_alu, $citta_alu, $CAP_alu, $prov_alu, $paese_alu, $disabilita_alu, $DSA_alu, $ckprivacy1_alu, $ckprivacy2_alu, $ckprivacy3_alu, $ckautfoto_alu, $ckautmateriale_alu, $ckautuscite_alu, $ckautuscitaautonoma_alu, $ckdoposcuola_alu, $ckreligione_alu, $altreligione_alu, $ckmensa_alu, $cktrasportopubblico_alu, $scuolaprovenienza_alu, $indirizzoscproven_alu, $classe_cla );
	$nn = 0;
	$classi = array("ASILO"=>"la SCUOLA MATERNA", "I"=>"la classe PRIMA ELEMENTARE", "II"=>"la classe SECONDA ELEMENTARE", "III"=>"la classe TERZA ELEMENTARE", "IV"=>"la classe QUARTA ELEMENTARE", "V"=>"la classe QUINTA ELEMENTARE", "VI"=>"la classe PRIMA MEDIA (VI)", "VII"=>"la classe SECONDA MEDIA (VII)", "VIII"=>"la classe TERZA MEDIA (VIII)", "NIDO"=>"l' ASILO NIDO", "IX"=>" programma di supporto alla didattica per la classe PRIMA SUPERIORE", "X"=>" programma di supporto alla didattica per la classe SECONDA superiore", "XI"=>"programma di supporto alla didattica per la classe TERZA superiore", "XII"=>"programma di supporto alla didattica per la classe QUARTA superiore", "XIII"=>"programma di supporto alla didattica per la classe QUINTA superiore");
	$classiV = array("ASILO"=>"<5", "I"=>"<5", "II"=>"<5", "III"=>"<5", "IV"=>"<5", "V"=>">5", "VI"=>">5", "VII"=>">5", "VIII"=>">5", "IX"=>">5", "X"=>">5","XI"=>">5","XII"=>">5","XIII"=>">5","NIDO"=>"<5");
	$classiI_IV = array("ASILO"=>"0", "I"=>"1", "II"=>"1", "III"=>"1", "IV"=>"1", "V"=>"0", "VI"=>"0", "VII"=>"0", "VIII"=>"0", "IX"=>"0", "X"=>"0", "XI"=>"0", "XII"=>"0", "XIII"=>"0", "NIDO"=>"0");


	while (mysqli_stmt_fetch($stmt)) {



		if ($classiV[$classe_cla] == "<5") {
			$ISC_mostra_uscitaautonoma = 0; }
		else {
			$ISC_mostra_uscitaautonoma = $_SESSION['ISC_mostra_uscitaautonoma'];
		}

		if ($classiI_IV[$classe_cla] == "0") {
			$ISC_mostra_doposcuola = 0; }
		else {
			$ISC_mostra_doposcuola = $_SESSION['ISC_mostra_doposcuola'];
		}


		//$nn parte da 0
		//se $nn è pari oppure se ci sono altre cose da mostrare allora devo aggiungere una pagina
		if (!($nn & 1 == 1)  || $ISC_mostra_sceltareligione == 1 || $ISC_mostra_trasportopubblico == 1 || $ISC_mostra_mensa == 1 || $ISC_mostra_uscitaautonoma == 1 || $ISC_mostra_doposcuola) {  
			$pdf->AddPage();
			//aggiungo subito le firme in basso, 
			$pdf->SetXY(10,255);
			include("firmepadremadreluogo.php");
			$pdf->SetXY(10,30);

			include("inc_alunnoModuloIscrizione.php");

		} else { //$se $nn è dispari allora non aggiungo la pagina
			include("inc_alunnoModuloIscrizione.php");
		}
		
		$nn++;
		$precdisabilita_alu = $disabilita_alu;
	}

	if ($blank) { //caso modulo BLANK
		$pdf->AddPage();
	
		for ($i = 1; $i <= 2; $i++) 
			{
				include("inc_alunnoModuloIscrizione.php");
			}
	}



//PRE-CONTRATTO - parte comune ***************************************************************************************
	//Il c.d. 'Contratto' è molto diverso tra le scuole, pertanto questa parte viene del tutto personalizzata sulla singola scuola
	
	//Array vari
	$Nfiglio = array("1"=>"Prim", "2"=>"Second", "3"=>"Terz", "4"=>"Quart", "5"=>"Quint");
	$MF = array("M"=>"o figlio", "F"=>"a figlia");
	$tipiquota = array("0"=>"Completa", "1"=>"Ridotta", "2"=>"Minima"); //usato solo da "CI"
	$modalitapag = array("0"=>$modalitaPagSDD, "1"=>$modalitaPagBonifico, "2"=>"in contanti.", "3"=>"con modalità da concordare con l'amministrazione");  //usato solo da "CI"
	$classi = array("ASILO"=>"MATERNA", "I"=>"PRIMA ELEMENTARE", "II"=>"SECONDA ELEMENTARE", "III"=>"TERZA ELEMENTARE", "IV"=>"QUARTA ELEMENTARE", "V"=>"QUINTA ELEMENTARE", "VI"=>"PRIMA MEDIA (VI)", "VII"=>"SECONDA MEDIA (VII)", "VIII"=>"TERZA MEDIA (VIII)", "IX"=>"I Sup.", "X"=>"II Sup.", "XI"=>"III Sup.", "XII"=>"IV Sup.", "XIII"=>"V Sup.", "NIDO"=>"ASILO NIDO");			

	//preparo l'elenco di nomi e cognomi dei figli, onde costruire la variabile $nomi
	$sql = "SELECT nome_alu, cognome_alu, classe_cla FROM (tab_anagraficaalunni JOIN tab_classialunni ON ID_alu = ID_alu_cla) JOIN tab_famiglie ON ID_fam_alu = ID_fam WHERE ID_fam_alu= ? AND noniscritto_alu = 0 ORDER BY datanascita_alu ASC";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $nome_alu, $cognome_alu, $classe_cla);
	$n = 0;
	$nomi = "";
	$nomiA = array();
	while (mysqli_stmt_fetch($stmt)) {
		$n++;
		$nomiA[$n] = $nome_alu." ".$cognome_alu;
	}

	
	if ($n == 1) {
		$nomi = $nomiA[1];
	} else {
		for ($x = 1; $x <= $n; $x++) {
		
			if ($x == $n)	{
				$nomi = $nomi." e ".$nomiA[$x];
			} else {
				$nomi = $nomi.", ".$nomiA[$x];
			}
	
		}
		$nomi = substr ($nomi, 2); //tolgo i primi 2 caratteri perchè ci ho messo ", " all'inizio
	}
	//fine preparazione di $nomi


	//preparazione dell'stmt che verrà usato per la tabellina all'interno di ciascun contratto
	$sql = "SELECT ID_alu, mf_alu, nome_alu, cognome_alu, classe_cla, quotapromessa_alu, quotaconcordata_alu, tipoquota_alu, ratepromesse_fam, quotacontraggiuntivo_fam, ratecontraggiuntivo_fam, pulizie_fam, richcolloquio_fam, intestazionefatt_fam, modalitapag_fam FROM (tab_anagraficaalunni JOIN tab_classialunni ON ID_alu = ID_alu_cla) JOIN tab_famiglie ON ID_fam_alu = ID_fam WHERE ID_fam_alu= ? AND noniscritto_alu = 0 ORDER BY datanascita_alu ASC";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu, $mf_alu, $nome_alu, $cognome_alu, $classe_cla, $quotapromessa_alu, $quotaconcordata_alu, $tipoquota_alu, $ratepromesse_fam, $quotacontraggiuntivo_fam, $ratecontraggiuntivo_fam, $pulizie_fam, $richcolloquio_fam, $intestazionefatt_fam, $modalitapag_fam);
	//fine preparazione stmt

//PAGINE CONTRATTO ARCA ********************************************************************************************

if ($codscuola =='AR') {
	$pdf->AddPage();


	//I sottoscritti...
	$pdf->SetFont('TitilliumWeb-SemiBold','',16);
	$pdf->Cell(0,10,$titolocontratto, 0,1, 'C');
	$pdf->SetFont($fontdefault,'',11);

	$pdf->Ln(2);
	$testo="Con la presente scrittura privata, tra le parti:";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

	$pdf->Ln(2);
	$testo="- <b>Societa' Cooperativa Sociale ARCA Educazione</b>, con sede in Padova, via T. Aspetti 248, di seguito 'ARCA Educazione' e";
	$testo = utf8_decode($testo);
	$pdf->WriteHTML($testo);

	$pdf->Ln(8);
	$testo="- Il Sig. <b>".strtoupper($cognomepadre_fam). " ".strtoupper($nomepadre_fam)."</b>, codice fiscale ". $cfpadre_fam ." nato il ". $datanascitapadre_fam." a ".$comunenascitapadre_fam." (".$provnascitapadre_fam."), residente a ". $comunepadre_fam." (".$provpadre_fam.")- ".$indirizzopadre_fam."<br>e la Sig.ra <b>".strtoupper($cognomemadre_fam). " ".strtoupper($nomemadre_fam). "</b>, codice fiscale ". $cfmadre_fam." nata il ". $datanascitamadre_fam." a ".$comunenascitamadre_fam." (".$provnascitamadre_fam."), residente a ". $comunemadre_fam." (".$provmadre_fam.") - ".$indirizzomadre_fam.", <br>genitori/esercenti la responsabilita' genitoriale di:".$nomi.".";  //utilizzo di $nomi

	if ($blank) {
		$testo="- Il Sig. __________________________, codice fiscale ____________________ nato il ___________ a __________________________ (___), residente a ________________________________ (___) Via/piazza_____________________________________________________________________<br> - e la Sig.ra ______________________, codice fiscale ____________________ nata il ___________ a __________________________ (___), residente a ________________________________ (___) Via/piazza_____________________________________________________________________ <br><b>genitori/esercenti la responsabilità genitoriale di<b>: ___________________________________________<br>";  //utilizzo di $nomi
	}
	$testo = utf8_decode($testo);
	$pdf->WriteHTML($testo);

	//$pdf->WriteHTML($testo);

	//PREMESSO CHE...
	$pdf->Ln(4);
	$pdf->SetFont('TitilliumWeb-SemiBold','',12);
	$pdf->Cell(0,8,"PREMESSO CHE", 0,1, 'C');
	$pdf->SetFont($fontdefault,'',11);

	$pdf->Ln(4);
	$testo="-	ARCA Educazione gestisce un programma di supporto alla didattica per ragazzi delle Scuole Superiori in istruzione parentale;";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

	$pdf->Ln(4);
	$testo="-	ARCA Educazione si finanzia in massima parte con contributi e donazioni delle famiglie; la puntualita' e regolarita' nei pagamenti sono necessari per la copertura delle spese del personale e per il buon funzionamento del progetto;";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

	$pdf->Ln(4);
	$testo="-	nell'economia di ARCA Educazione la solidarietà della comunità dei genitori rappresenta un presupposto irrinunciabile;";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

	$pdf->Ln(4);
	$testo="-	si è presa visione e si condividono i principi che regolano il Percorso pedagogico (<a href='downloadAllegato.php?nomeallegato=A_".$codscuola."'>Allegato A</a>) ed il ".$POF_PTOF_PSDext." (disponibili in segreteria o scaricabili dal sito www.arcascuola.it);<br>";
	$testo = utf8_decode($testo);
	$pdf->WriteHTML($testo);
	if ($ISC_mostra_regolinterno ==1) {
		$pdf->Ln(4);
		$testo="-	si è presa visione e si condivide il Regolamento Interno (<a href='downloadAllegato.php?nomeallegato=B_".$codscuola."'>Allegato B</a>);<br>";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
	}
	if ($ISC_mostra_regolpediatrico ==1) {
		$pdf->Ln(4);
		$testo="-	si è presa visione e si condivide il Regolamento Pediatrico (<a href='downloadAllegato.php?nomeallegato=C_AR'>Allegato C</a>);<br>";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
	}
	$pdf->Ln(4);
	$testo="-	l'ammissione al progetto è subordinato al parere del Collegio Docenti e del Consiglio di Amministrazione;";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

	$pdf->Ln(4);
	$testo="-	si dichiara di aver presentato domanda di iscrizione per l'anno scolastico ".$annoscolastico." obbligandosi, in caso di accettazione della medesima domanda da parte di ARCA Educazioe, a sottoscrivere il presente contratto;
	";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

	//TUTTO CIO'PREMESSO...
	$pdf->SetFont('TitilliumWeb-SemiBold','',12);
	$pdf->Cell(0,8,"TUTTO CIO' PREMESSO SI CONVIENE E SI STIPULA QUANTO SEGUE", 0,1, 'C');
	$pdf->SetFont($fontdefault,'',11);

	$pdf->Ln(4);
	$testo="art.1)	Le premesse e gli allegati richiamati sono parte integrante e sostanziale del presente atto;";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

	$pdf->Ln(4);
	$testo="art.2)	ARCA Educazione si obbliga nei confronti dell'altra parte contraente a fornire le prestazioni formative previste dal Programma di supporto alla didattica;";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

	$pdf->Ln(4);
	$testo="art.3)	I genitori/tutori/esercenti la responsabilità genitoriale sono consapevoli delle conseguenze amministrative per chi rilasci dichiarazioni non corrispondenti a verità, ai sensi del D.P.R. 245/2000, anche in osservanza delle disposizioni sulla responsabilità genitoriale di cui agli artt. 316, 337 ter e 337 quater del codice civile che richiedono il consenso di entrambi i genitori;";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

	//-------

	$pdf->AddPage();

	$testo= "art.4)	I genitori/tutori/esercenti la responsabilità genitoriale si obbligano in solido a corrispondere ad ARCA Educazione per l'anno scolastico ".$annoscolastico.", una quota annua a titolo di  CONTRIBUTO MINIMO così definito (vedi <a href='downloadAllegato.php?nomeallegato=D_".$codscuola."'>Allegato D</a>):
	";
	$testo = utf8_decode($testo);
	$pdf->WriteHTML($testo);


	$pdf->Ln(10);
	$pdf->SetFont($fontdefault,'',11);
	$n = 0;
	$totquotapromessa = 0;

	//TABELLINA********
	$pdf->Cell(75,5,"NOME e COGNOME","LTR",0,'C');
	$pdf->Cell(40,5,"# figlio","LTR",0,'C');
	$pdf->Cell(45,5,"Iscrizione alla classe","LTR",0,'C');
	$pdf->Cell(30,5,"Quota annua","LTR",1,'C');
	$pdf->Cell(75,5,"","LBR",0,'L');
	$pdf->Cell(40,5,"","LBR",0,'L');
	$pdf->Cell(45,5,"","LBR",0,'L');
	$pdf->Cell(30,5,"(euro)","LBR",1,'C');
	while (mysqli_stmt_fetch($stmt)) {
		$totquotapromessa = $totquotapromessa + intval($quotapromessa_alu);
		$n++;
		$pdf->Cell(75,8,$nome_alu." ".$cognome_alu,1,0,'L');
		$pdf->Cell(40,8,$Nfiglio[$n].$MF[$mf_alu],1,0,'L');
		$pdf->Cell(45,8,$classi[$classe_cla],1,0,'L');
		$pdf->Cell(30,8,$quotapromessa_alu,1,1,'C');
	}
	if ($blank) { //caso modulo BLANK
		for ($i = 1; $i <= 4; $i++) 
			{
				$n++;
				$pdf->Cell(75,8,"",1,0,'L');
				$pdf->Cell(40,8,"",1,0,'L');
				$pdf->Cell(45,8,"",1,0,'L');
				$pdf->Cell(30,8,"",1,1,'C');
			}
	}
	$pdf->SetFont('TitilliumWeb-SemiBold','',12);
	$pdf->Cell(160,10,"Totale contributo annuo",1,0,'L');
	if ($totquotapromessa !=0) {
		$pdf->Cell(30,10,$totquotapromessa,1,1,'C');
	} else {
		$pdf->Cell(30,10,"",1,1,'C');
	}


	/*if ($quotaconcordata_alu == 1) {
		$testo12= "(la quota espressa è soggetta ad approvazione da parte del Cons. di Amministrazione e potrà quindi subire variazioni, da concordare con la famiglia)";
		$testo12 = utf8_decode($testo12);
		$pdf->SetFont($fontdefault,'',9);
		$pdf->Cell(0,5,$testo12,0,1,"L");	
	}*/

	$testo12= "il versamento di tale quota annua avverrà in soluzione:";
	$testo12 = utf8_decode($testo12);
	$pdf->SetFont($fontdefault,'',11);
	$pdf->Cell(0,10,$testo12,0,1,"L");

	$unicasoluzione = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+1,5)."      unica entro il 05/09/".$anno1;
	if ($ratepromesse_fam == 1) {
		$unicasoluzione = $pdf->Image($imgsquarecrossed,$pdf->GetX(), $pdf->GetY()+1,5)."      unica entro il 05/09/".$anno1;
	}
	$pdf->Cell(0,8,$unicasoluzione,0,1,'L');

	if ($ratepromesse_fam == 2) {
		$duerate = $pdf->Image($imgsquarecrossed,$pdf->GetX(), $pdf->GetY()+1,5).utf8_decode("      due rate (entro il ".$scadrata1duerate.$anno1." e entro il".$scadrata2duerate.$anno2.")");
	}
	$pdf->Cell(0,8,$duerate,0,1,'L');

	$diecirate = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+1,5).utf8_decode("      DILAZIONATA entro il giorno 5 di ciascun mese in 10 mensilità (da settembre a giugno)");
	if ($ratepromesse_fam == 10) {
		$diecirate = $pdf->Image($imgsquarecrossed,$pdf->GetX(), $pdf->GetY()+1,5).utf8_decode("      DILAZIONATA entro il giorno 5 di ciascun mese in 10 mensilità (da settembre a giugno)");
	}
	$pdf->Cell(0,8,$diecirate,0,1,'L');

	//$dodicirate = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+1,5).utf8_decode("     DILAZIONATA entro il giorno 5 di ciascun mese in 12 mensilità (da settembre a agosto)");
	if ($ratepromesse_fam == 12) {
		$dodicirate = $pdf->Image($imgsquarecrossed,$pdf->GetX(), $pdf->GetY()+1,5).utf8_decode("     DILAZIONATA entro il giorno 5 di ciascun mese in 12 mensilità (da settembre a agosto)");
		$pdf->Cell(0,8,$dodicirate,0,1,'L');
	}


	$pdf->Ln(4);
	$testo="art.5)	I genitori/tutori/esercenti la responsabilità genitoriale si impegnano a versare a consuntivo entro il 15/06/".$anno2." l'eventuale conguaglio per le spese didattiche anticipate dalla Società Cooperativa.";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

	$pdf->Ln(4);
	if($quotacontraggiuntivo_fam!=0) {$frasequotacontraggiuntivo_fam = $quotacontraggiuntivo_fam;} else {$frasequotacontraggiuntivo_fam = ".....................";}
	if($ratecontraggiuntivo_fam!=0) {$fraseratecontraggiuntivo_fam = $ratecontraggiuntivo_fam;} else {$fraseratecontraggiuntivo_fam = ".....";};
	$testo ="I sottoscritti intendono inoltre versare un CONTRIBUTO AGGIUNTIVO di euro  ".$frasequotacontraggiuntivo_fam." versato in ".$fraseratecontraggiuntivo_fam." rate.";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);
	$pdf->Ln(4);

	if ($ISC_mostra_intestazionefatt ==1) {

		switch ($intestazionefatt_fam) {
			case "altro":
				$testointestazione ="a : ....................................................................................";
			break;
			case "padre":
				$testointestazione ="al padre.";
			break;
			case "madre":
				$testointestazione ="alla madre.";
			break;
			case null:
				$testointestazione ="a : ....................................................................................";
			}
		$testo= "I sottoscritti chiedono che le fatture vengano intestate <b>".$testointestazione."<b>";
		$pdf->SetFont($fontdefault,'',11);
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
	}
	$pdf->Ln(8);
	$testo = "I contributi vanno versati entro il 5 di ogni mese sul conto";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo, 0, 'C');

	$testo = "YYYYYYYYYY IBAN: ITXXXXXXXXXXXXXXXXXXXX 
	Il contributo annuo è dovuto anche in caso di prolungata assenza o ritiro anticipato del discente.";

	$testo = utf8_decode($testo);
	$pdf->SetFont('TitilliumWeb-SemiBold','',12);
	$pdf->MultiCell(0,5,$testo, 0, 'C');
	$pdf->SetFont($fontdefault,'',11);

	$pdf->Ln(4);
	$testo= "Art.6) E' riconosciuto ad ARCA Educazione il diritto di richiedere il rispetto dei tempi dei versamenti. Si precisa che il contributo non potrà essere mensilmente suddiviso tra entrambi i genitori, ma dovrà essere necessariamente versato interamente da uno dei due.";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

	$pdf->Ln(4);
	$testo="Art.7) Nel caso di astensione prolungata dal programma per cause non imputabili ad ARCA Educazione (malattia, impegni sportivi, studio all'estero, etc.) è fatto obbligo ai genitori di continuare a versare le quote dovute secondo quanto stabilito.";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

	$pdf->Ln(4);
	$testo="In caso di risoluzione del contratto e di ritiro del discente per cause non imputabili alla Soc. Cooperativa, prima dell'inizio dell'anno scolastico, si riconosce ad ARCA Educazione la facoltà di avvalersi del diritto di non restituire nessun importo già versato alla Soc. Cooperativa, e i Genitori/Tutori/esercenti la responsabilità genitoriale si obbligano a versare ad ARCA Educazione le quote relative a tre mensilità.";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

	$pdf->Ln(4);
	$testo="In caso di ritiro durante l'anno scolastico è prevista una riduzione della quota annuale (CONTRIBUTO MINIMO) del 50% qualora questo avvenga prima del 31 dicembre, mentre la quota annuale è interamente dovuta in caso di ritiro successivo.";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);
	
	$pdf->Ln(4);
	$testo="Art.8) In applicazione di quanto previsto dall'art. 1456 c.c., in caso di violazione da parte dei Genitori/Tutori/esercenti la responsabilità genitoriale degli impegni contenuti nel presente contratto, ARCA Educazione potrà risolvere di diritto il presente contratto comunicando ai Genitori/Tutori/esercenti la responsabilità genitoriale l'intenzione di avvalersi della presente clausola risolutiva.";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

	$pdf->Ln(4);
	$testo="Art.9) Per quanto non previsto nel presente contratto, le cui clausole si intendono tutte essenziali ed inderogabili, si rinvia alle norme di legge in materia.";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

	$pdf->Ln(4);
	$testo="Art.10) Ogni controversia inerente l'applicazione e /o l'interpretazione del presente contratto che non richieda l'intervento obbligatorio del Pubblico Ministero sarà prima sottoposta al Collegio dei Probiviri di ARCA EDUCAZIONE Cooperativa Sociale e, qualora non risolta, sarà fatta oggetto di un tentativo preliminare di mediazione presso l'organismo della Camera di Commercio di Padova. Foro competente è il foro di Padova.";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);
	

	//FIRMA PADRE FIRMA MADRE DATA E LUOGO AFFIANCATI
	$pdf->Ln(8);
	include("firmepadremadreluogo.php");

	$pdf->Ln(10);
	$pdf->Cell(60,5,"Per la Soc. Coop Sociale Arca Educazione",0,1,'C');
	$pdf->Cell(60,5,"(Il rappresentante legale)",0,1,'C');
	$pdf->Ln(4);
	$pdf->Cell(60,5,"","B",1);
}


//PAGINE CONTRATTO PADOVA ********************************************************************************************

	if ($codscuola =='PD') {
		$pdf->AddPage();
	

		//I sottoscritti...
		$pdf->SetFont('TitilliumWeb-SemiBold','',16);
		$pdf->Cell(0,10,$titolocontratto, 0,1, 'C');
		$pdf->SetFont($fontdefault,'',11);

		$pdf->Ln(2);
		$testo="Con la presente scrittura privata, tra le parti:";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(2);
		$testo="- <b>Societa' Cooperativa Steiner Waldorf Padova</b>, con sede in Padova, via Retrone 20, di seguito 'Ente Gestore' e";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);

		$pdf->Ln(8);
		$testo="- Il Sig. <b>".strtoupper($cognomepadre_fam). " ".strtoupper($nomepadre_fam)."</b>, codice fiscale ". $cfpadre_fam ." nato il ". $datanascitapadre_fam." a ".$comunenascitapadre_fam." (".$provnascitapadre_fam."), residente a ". $comunepadre_fam." (".$provpadre_fam.")- ".$indirizzopadre_fam."<br>e la Sig.ra <b>".strtoupper($cognomemadre_fam). " ".strtoupper($nomemadre_fam). "</b>, codice fiscale ". $cfmadre_fam." nata il ". $datanascitamadre_fam." a ".$comunenascitamadre_fam." (".$provnascitamadre_fam."), residente a ". $comunemadre_fam." (".$provmadre_fam.") - ".$indirizzomadre_fam.", <br>genitori/esercenti la responsabilita' genitoriale di:".$nomi.".";  //utilizzo di $nomi

		if ($blank) {
			$testo="- Il Sig. __________________________, codice fiscale ____________________ nato il ___________ a __________________________ (___), residente a ________________________________ (___) Via/piazza_____________________________________________________________________<br> - e la Sig.ra ______________________, codice fiscale ____________________ nata il ___________ a __________________________ (___), residente a ________________________________ (___) Via/piazza_____________________________________________________________________ <br><b>genitori/esercenti la responsabilità genitoriale di<b>: ___________________________________________<br>";  //utilizzo di $nomi
		}
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);

		//$pdf->WriteHTML($testo);

		//PREMESSO CHE...
		$pdf->Ln(4);
		$pdf->SetFont('TitilliumWeb-SemiBold','',12);
		$pdf->Cell(0,8,"PREMESSO CHE", 0,1, 'C');
		$pdf->SetFont($fontdefault,'',11);

		$pdf->Ln(4);
		$testo="-	L'Ente Gestore gestisce una istituzione scolastica pubblica non statale paritaria per materna e primaria, non paritaria per secondaria di primo grado;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="-	il suddetto Ente Gestore si finanzia in massima parte con contributi e donazioni delle famiglie; la puntualita' e regolarita' nei pagamenti sono necessari per la copertura delle spese del personale e per il buon funzionamento della Scuola;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="-	nell'economia dell'Ente Gestore la solidarietà della comunità scolastica rappresenta un presupposto irrinunciabile;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="-	si è presa visione e si condividono i principi che regolano il Percorso pedagogico (<a href='downloadAllegato.php?nomeallegato=A_".$codscuola."'>Allegato A</a>) ed il ".$POF_PTOF_PSD." e PEI della scuola (disponibili in segreteria o scaricabili dal sito www.waldorfpadova.it);<br>";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
		if ($ISC_mostra_regolinterno ==1) {
			$pdf->Ln(4);
			$testo="-	si è presa visione e si condivide il Regolamento Interno (<a href='downloadAllegato.php?nomeallegato=B_".$codscuola."'>Allegato B</a>);<br>";
			$testo = utf8_decode($testo);
			$pdf->WriteHTML($testo);
		}
		if ($ISC_mostra_regolpediatrico ==1) {
			$pdf->Ln(4);
			$testo="-	si è presa visione e si condivide il Regolamento Pediatrico (<a href='downloadAllegato.php?nomeallegato=C_PD'>Allegato C</a>);<br>";
			$testo = utf8_decode($testo);
			$pdf->WriteHTML($testo);
		}
		$pdf->Ln(4);
		$testo="-	l'ammissione alla Scuola è subordinata al parere del Collegio degli Insegnanti e del Consiglio di Amministrazione;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="-	si dichiara di aver presentato domanda di iscrizione per l'anno scolastico ".$annoscolastico." obbligandosi, in caso di accettazione della medesima domanda da parte dell'Ente Gestore, a sottoscrivere il presente contratto di prestazione scolastica;
		";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		//TUTTO CIO'PREMESSO...
		$pdf->SetFont('TitilliumWeb-SemiBold','',12);
		$pdf->Cell(0,8,"TUTTO CIO' PREMESSO SI CONVIENE E SI STIPULA QUANTO SEGUE", 0,1, 'C');
		$pdf->SetFont($fontdefault,'',11);

		$pdf->Ln(4);
		$testo="art.1)	Le premesse e gli allegati richiamati sono parte integrante e sostanziale del presente atto;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="art.2)	l'Ente Gestore suindicato si obbliga nei confronti dell'altra parte contraente a fornire le prestazioni scolastiche previste dal ".$POF_PTOF_PSD." della Scuola;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="art.3)	I genitori/tutori/esercenti la responsabilità genitoriale sono consapevoli delle conseguenze amministrative per chi rilasci dichiarazioni non corrispondenti a verità, ai sensi del D.P.R. 245/2000, anche in osservanza delle disposizioni sulla responsabilità genitoriale di cui agli artt. 316, 337 ter e 337 quater del codice civile che richiedono il consenso di entrambi i genitori;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		//-------

		$pdf->AddPage();
	

		$testo= "art.4)	I genitori/tutori/esercenti la responsabilità genitoriale si obbligano in solido a corrispondere all'Ente Gestore per l'anno scolastico ".$annoscolastico.", una quota annua a titolo di  CONTRIBUTO SCOLASTICO MINIMO così definito (vedi <a href='downloadAllegato.php?nomeallegato=D_".$codscuola."'>Allegato D</a>):
		";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);


		$pdf->Ln(10);
		$pdf->SetFont($fontdefault,'',11);
		$n = 0;
		$totquotapromessa = 0;

		//TABELLINA********
		$pdf->Cell(75,5,"NOME e COGNOME","LTR",0,'C');
		$pdf->Cell(40,5,"# figlio","LTR",0,'C');
		$pdf->Cell(45,5,"Iscrizione alla classe","LTR",0,'C');
		$pdf->Cell(30,5,"Quota annua","LTR",1,'C');
		$pdf->Cell(75,5,"","LBR",0,'L');
		$pdf->Cell(40,5,"","LBR",0,'L');
		$pdf->Cell(45,5,"","LBR",0,'L');
		$pdf->Cell(30,5,"(euro)","LBR",1,'C');
		while (mysqli_stmt_fetch($stmt)) {
			$totquotapromessa = $totquotapromessa + intval($quotapromessa_alu);
			$n++;
			$pdf->Cell(75,8,$nome_alu." ".$cognome_alu,1,0,'L');
			$pdf->Cell(40,8,$Nfiglio[$n].$MF[$mf_alu],1,0,'L');
			$pdf->Cell(45,8,$classi[$classe_cla],1,0,'L');
			$pdf->Cell(30,8,$quotapromessa_alu,1,1,'C');
		}
		if ($blank) { //caso modulo BLANK
			for ($i = 1; $i <= 4; $i++) 
				{
					$n++;
					$pdf->Cell(75,8,"",1,0,'L');
					$pdf->Cell(40,8,"",1,0,'L');
					$pdf->Cell(45,8,"",1,0,'L');
					$pdf->Cell(30,8,"",1,1,'C');
				}
		}
		$pdf->SetFont('TitilliumWeb-SemiBold','',12);
		$pdf->Cell(160,10,"Totale contributo annuo",1,0,'L');
		if ($totquotapromessa !=0) {
			$pdf->Cell(30,10,$totquotapromessa,1,1,'C');
		} else {
			$pdf->Cell(30,10,"",1,1,'C');
		}


		/*if ($quotaconcordata_alu == 1) {
			$testo12= "(la quota espressa è soggetta ad approvazione da parte del Cons. di Amministrazione e potrà quindi subire variazioni, da concordare con la famiglia)";
			$testo12 = utf8_decode($testo12);
			$pdf->SetFont($fontdefault,'',9);
			$pdf->Cell(0,5,$testo12,0,1,"L");	
		}*/

		$testo12= "il versamento di tale quota annua avverrà in soluzione:";
		$testo12 = utf8_decode($testo12);
		$pdf->SetFont($fontdefault,'',11);
		$pdf->Cell(0,10,$testo12,0,1,"L");

		$unicasoluzione = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+1,5)."      unica entro il 05/09/".$anno1;
		if ($ratepromesse_fam == 1) {
			$unicasoluzione = $pdf->Image($imgsquarecrossed,$pdf->GetX(), $pdf->GetY()+1,5)."      unica entro il 05/09/".$anno1;
		}
		$pdf->Cell(0,8,$unicasoluzione,0,1,'L');

		$diecirate = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+1,5).utf8_decode("      DILAZIONATA entro il giorno 5 di ciascun mese in 10 mensilità (da settembre a giugno)");
		if ($ratepromesse_fam == 10) {
			$diecirate = $pdf->Image($imgsquarecrossed,$pdf->GetX(), $pdf->GetY()+1,5).utf8_decode("      DILAZIONATA entro il giorno 5 di ciascun mese in 10 mensilità (da settembre a giugno)");
		}
		$pdf->Cell(0,8,$diecirate,0,1,'L');

		//$dodicirate = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+1,5).utf8_decode("     DILAZIONATA entro il giorno 5 di ciascun mese in 12 mensilità (da settembre a agosto)");
		if ($ratepromesse_fam == 12) {
			$dodicirate = $pdf->Image($imgsquarecrossed,$pdf->GetX(), $pdf->GetY()+1,5).utf8_decode("     DILAZIONATA entro il giorno 5 di ciascun mese in 12 mensilità (da settembre a agosto)");
			$pdf->Cell(0,8,$dodicirate,0,1,'L');
		}


		$pdf->Ln(5);
		$pdf->SetFont($fontdefault,'',11);
		$testo= "art.5)	I genitori/tutori/esercenti la responsabilità genitoriale che confermino l'iscrizione all'anno successivo si impegnano a versare la quota di iscrizione per l'anno successivo pari a euro ".$quotaiscrizione." entro il ".$scadiscrizionelett.$anno2."; la quota di iscrizione è di euro 160 per iscrizioni oltre tale data";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="art.6)	I genitori/tutori/esercenti la responsabilità genitoriale si impegnano a versare a consuntivo entro il 15/06/".$anno2." l'eventuale conguaglio per le spese didattiche anticipate dalla Scuola.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		if($quotacontraggiuntivo_fam!=0) {$frasequotacontraggiuntivo_fam = $quotacontraggiuntivo_fam;} else {$frasequotacontraggiuntivo_fam = ".....................";}
		if($ratecontraggiuntivo_fam!=0) {$fraseratecontraggiuntivo_fam = $ratecontraggiuntivo_fam;} else {$fraseratecontraggiuntivo_fam = ".....";};
		$testo ="I sottoscritti intendono inoltre versare un CONTRIBUTO AGGIUNTIVO di euro  ".$frasequotacontraggiuntivo_fam." versato in ".$fraseratecontraggiuntivo_fam." rate.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
		$pdf->Ln(4);

		if ($ISC_mostra_intestazionefatt ==1) {

			switch ($intestazionefatt_fam) {
				case "altro":
					$testointestazione ="a : ....................................................................................";
				break;
				case "padre":
					$testointestazione ="al padre.";
				break;
				case "madre":
					$testointestazione ="alla madre.";
				break;
				case null:
					$testointestazione ="a : ....................................................................................";
				}
			$testo= "I sottoscritti chiedono che le fatture vengano intestate <b>".$testointestazione."<b>";
			$pdf->SetFont($fontdefault,'',11);
			$testo = utf8_decode($testo);
			$pdf->WriteHTML($testo);
		}
		$pdf->Ln(8);
		$testo = "I contributi vanno versati entro il 5 di ogni mese sul conto";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo, 0, 'C');

		$testo = "Banca Etica IBAN: IT92 C050 1812 1010 000 1142 6830 
		Il contributo annuo è dovuto anche in caso di prolungata assenza o ritiro anticipato dell'alunno.";

		$testo = utf8_decode($testo);
		$pdf->SetFont('TitilliumWeb-SemiBold','',12);
		$pdf->MultiCell(0,5,$testo, 0, 'C');
		$pdf->SetFont($fontdefault,'',11);

		$pdf->Ln(4);
		$testo= "Art.7) E' riconosciuto all'Ente Gestore il diritto di richiedere il rispetto dei tempi dei versamenti. Si precisa che il contributo non potrà essere mensilmente suddiviso tra entrambi i genitori, ma dovrà essere necessariamente versato interamente da uno dei due.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="Art.8) Nel caso di astensione prolungata dalle lezioni per cause non imputabili alla scuola (malattia, impegni sportivi, studio all'estero, etc.) è fatto obbligo ai genitori di continuare a versare le quote dovute secondo quanto stabilito.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="Art.9) In caso di ritiro /disdetta dell'iscrizione oltre il 30 marzo ".$anno1.", l'Ente Gestore si avvale del diritto di trattenere interamente la quota di iscrizione.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="In caso di risoluzione del contratto e di ritiro dell'alunno per cause non imputabili alla scuola, prima dell'inizio dell'anno scolastico, si riconosce all'Ente Gestore la facoltà di avvalersi del diritto di non restituire nessun importo già versato alla scuola, e i Genitori/Tutori/esercenti la responsabilità genitoriale si obbligano a versare all'Ente Gestore le quote relative a tre mensilità.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="In caso di ritiro durante l'anno scolastico è prevista una riduzione della quota annuale (CONTRIBUTO SCOLASTICO MINIMO) del 50% qualora questo avvenga prima del 31 dicembre, mentre la quota annuale è interamente dovuta in caso di ritiro successivo.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
		
		$pdf->Ln(4);
		$testo="Art.10) In applicazione di quanto previsto dall'art. 1456 c.c., in caso di violazione da parte dei Genitori/Tutori/esercenti la responsabilità genitoriale degli impegni contenuti nel presente contratto, l'Ente Gestore potrà risolvere di diritto il presente contratto comunicando ai Genitori/Tutori/esercenti la responsabilità genitoriale l'intenzione di avvalersi della presente clausola risolutiva.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="Art.11) Per quanto non previsto nel presente contratto, le cui clausole si intendono tutte essenziali ed inderogabili, si rinvia alle norme di legge in materia.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="Art.12) Ogni controversia inerente l'applicazione e /o l'interpretazione del presente contratto che non richieda l'intervento obbligatorio del Pubblico Ministero sarà fatta oggetto di un tentativo preliminare di mediazione presso l'organismo della Camera di Commercio di Padova. Foro competente è il foro di Padova.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
		

		//FIRMA PADRE FIRMA MADRE DATA E LUOGO AFFIANCATI
		$pdf->Ln(8);
		include("firmepadremadreluogo.php");

		$pdf->Ln(10);
		$pdf->Cell(60,5,"Per la Soc. Coop Steiner Waldorf Padova",0,1,'C');
		$pdf->Cell(60,5,"(Il rappresentante legale)",0,1,'C');
		$pdf->Ln(4);
		$pdf->Cell(60,5,"","B",1);
	}


//PAGINE CONTRATTO CITTADELLA ****************************************************************************************
	if ($codscuola =='CI') {
		$pdf->AddPage();
	

		$pdf->SetFont('TitilliumWeb-SemiBold','',16);
		$pdf->Cell(0,10,$titolocontratto, 0,1, 'C');
		$pdf->SetFont($fontdefault,'',11);
		$pdf->Ln(5);

		$testo= "I suindicati genitori/tutori/esercenti la responsabilità genitoriale:";
		$testo = utf8_decode($testo);
		$pdf->Cell(0,10,$testo, 0,1, 'L');
		

		$testo="- si impegnano in solido a corrispondere all'Ente Gestore per l'anno scolastico ".$annoscolastico.", una quota annua a titolo di  CONTRIBUTO DI GESTIONE così definita (v. <a href='downloadAllegato.php?nomeallegato=D_".$codscuola."'>Allegato D</a>): ";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
		$pdf->Ln(7);

		
		$pdf->SetFont($fontdefault,'',11);
		$n = 0;
		$totquotapromessa = 0;

		//TABELLINA********
		$pdf->Cell(50,8,"NOME e COGNOME","LTR",0,'C');
		$pdf->Cell(25,8,"# figlio","LTR",0,'C');
		$pdf->Cell(50,8,"Iscrizione alla classe","LTR",0,'C');
		$pdf->Cell(30,8,"Tipo di Quota","LTR",0,'C');
		$pdf->Cell(35,8,"Quota annua euro","LTR",1,'C');
		while (mysqli_stmt_fetch($stmt)) {
			$totquotapromessa = $totquotapromessa + intval($quotapromessa_alu);
			$n++;
			$pdf->Cell(50,8,$nome_alu." ".$cognome_alu,1,0,'L');
			$pdf->Cell(25,8,$Nfiglio[$n].$MF[$mf_alu],1,0,'C');
			$pdf->Cell(50,8,$classi[$classe_cla],1,0,'C');
			$pdf->Cell(30,8,$tipiquota[$tipoquota_alu],1,0,'C');
			$pdf->Cell(35,8,$quotapromessa_alu,1,1,'C');



		}

		if ($blank) { //caso modulo BLANK
			for ($i = 1; $i <= 4; $i++) 
				{
					$n++;
					$pdf->Cell(55,8,"",1,0,'L');
					$pdf->Cell(30,8,"",1,0,'L');
					$pdf->Cell(40,8,"",1,0,'L');
					$pdf->Cell(30,8,"",1,0,'C');
					$pdf->Cell(35,8,"",1,1,'C');
				}
		}

		$pdf->SetFont('TitilliumWeb-SemiBold','',12);
		$pdf->Cell(155,10,"Totale annuo contributo di gestione",1,0,'L');
		$pdf->Cell(35,10,$totquotapromessa,1,1,'C');

		$pdf->Ln(2);
		
		$dilazione= array(1=>"una sola rata entro il 5/09/".$anno1, 3=>"3 rate con scadenza 10 Ottobre, 10 Gennaio e 10 Aprile", 10=>"10 mensilità pagate ".$scadpagamenti." da settembre a giugno", 12=>"12 mensilità pagate ".$scadpagamenti." da settembre a agosto");

		if ($ratepromesse_fam != 99) {
			$testo= "- tale quota verrà versata in <b>".$dilazione[$ratepromesse_fam]."</b>";
			$pdf->SetFont($fontdefault,'',11);
			$testo = utf8_decode($testo);
			$pdf->WriteHTML($testo);
			$pdf->Ln(7);
		} else {
			$testo= "- tale quota verrà versata secondo le scadenze sotto indicate";
			$pdf->SetFont($fontdefault,'',11);
			$testo = utf8_decode($testo);
			$pdf->WriteHTML($testo);
			$pdf->Ln(6);
			$pdf->Cell(0,15,"",1,1,'C');
			$pdf->Ln(2);
		}
		
		
		$testo= "- si impegnano al versamento della quota di iscrizione, pari ad euro ".$quotaiscrizione.", entro il ".$scadiscrizione.$anno1." o al momento dell'iscrizione.";
		$pdf->SetFont($fontdefault,'',11);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(2);
		if ($pulizie_fam == 0) {
			if ($n == 1) { $orepulizie = 14 ;} else { $orepulizie = 16 ;}
			$testo= "- scelgono di svolgere le pulizie per ".$orepulizie." ore durante l'anno";
		} else {
			if ($n == 1) { $quotapulizie = 180 ;} else { $quotapulizie = 210 ;}
			$testo= "- scelgono di <u>non</u> svolgere le pulizie e quindi di versare la somma di euro ".$quotapulizie.".";
		}
		$pdf->SetFont($fontdefault,'',11);
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
		
		$pdf->Ln(7);
		if ($richcolloquio_fam == 1) {
			$testo= "- chiedono un colloquio per accedere al 'Fondo di Solidarietà per le Famiglie'.";
			$pdf->SetFont($fontdefault,'',11);
			$testo = utf8_decode($testo);
			$pdf->MultiCell(0,5,$testo);
		}

		$pdf->Ln(4);
		$testo= "Solo per la prima iscrizione alla scuola Aurora: versano la cauzione per alunno nuovo iscritto di euro 300";
		$pdf->SetFont($fontdefault,'',10);
		$testo = utf8_decode($testo);
		$pdf->Cell(0,7,$testo,"T",1,"C");
		$pdf->SetFont($fontdefault,'',9);
		$pdf->Cell(60,7,"in soluzione unica".$pdf->Image($imgsquare,$pdf->GetX()+45, $pdf->GetY()+1,5),"B",0,"C");
		$pdf->Cell(130,7,"in 3 rate (1/3 all'iscrizione-1/3 settembre-saldo ottobre ".$anno1.")".$pdf->Image($imgsquare,$pdf->GetX()+110, $pdf->GetY()+1,5),"B",0,"C"); 
		
		$pdf->Ln(12);
		if ($ISC_mostra_intestazionefatt ==1) {
			switch ($intestazionefatt_fam) {
				case "altro":
					$testointestazione ="a : <u>                                                                                                                               <u>";
				break;
				case "padre":
					$testointestazione ="al padre.";
				break;
				case "madre":
					$testointestazione ="alla madre.";
				break;
				}
			// $testo= "- chiedono che le fatture vengano intestate ".$testointestazione;
			// $pdf->SetFont($fontdefault,'',11);
			// $testo = utf8_decode($testo);
			// $pdf->Cell(0,7,$testo,"T",1,"L");

			$testo= "- chiedono che le fatture vengano intestate <b>".$testointestazione."</b>";
			$pdf->SetFont($fontdefault,'',11);
			$testo = utf8_decode($testo);
			$pdf->WriteHTML($testo);
		}

		if ($ISC_mostra_tipopag == 1) {
			$pdf->Ln(7);
			$testo= "- scelgono di pagare <b>".$modalitapag[$modalitapag_fam]."</b>";
			$pdf->SetFont($fontdefault,'',11);
			$testo = utf8_decode($testo);
			$pdf->WriteHTML($testo);
		}

		$pdf->Ln(7);
		$testo= "I sottoscritti dichiarano di essere consapevoli che la scuola può utilizzare i dati contenuti nel presente modulo di iscrizione esclusivamente nell'ambito e per i fini istituzionali propri della Pubblica Amministrazione.";
		$pdf->SetFont($fontdefault,'',11);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->SetXY(10,220);
		//FIRMA PADRE FIRMA MADRE DATA E LUOGO AFFIANCATI
		$pdf->Ln(8);
		include("firmepadremadreluogo.php");

		//RISERVATO ALLA SEGRETERIA
		$pdf->SetXY(10,250);
		$testo= "RISERVATO ALLA SEGRETERIA";
		$pdf->SetFont($fontdefault,'',11);
		$testo = utf8_decode($testo);
		$pdf->Cell(0,7,$testo,"T",1,"C");


		$testo= "Si ricevono euro ___________ quale quota di iscrizione, ed euro ___________ a titolo di cauzione: Totale ___________";
		$pdf->SetFont($fontdefault,'',9);
		$pdf->Cell(23,7,"Si ricevono euro",0,0);
		$pdf->Cell(20,7,"",1,0);
		$pdf->Cell(45,7,"quale quota di iscrizione, ed euro",0,0);
		$pdf->Cell(20,7,"",1,0);
		$pdf->Cell(62,7,"a titolo di cauzione:                                    Totale",0,0,"L");
		$pdf->Cell(20,7,"",1,1);
		$pdf->Ln(3);
		$pdf->Cell(170,5,"Data",0,0,'R');
		$pdf->Cell(20,5,"","B",1);

	}

//PAGINE CONTRATTO TRENTO ********************************************************************************************

	if ($codscuola =='TN') {
		$pdf->AddPage();
	

		$pdf->SetFont('TitilliumWeb-SemiBold','',16);
		$pdf->Cell(0,10,$titolocontratto, 0,1, 'C');
		$pdf->SetFont($fontdefault,'',11);
		$pdf->Ln(5);

		$testo= "I suindicati genitori/tutori/esercenti la responsabilità genitoriale:";
		$testo = utf8_decode($testo);
		$pdf->Cell(0,10,$testo, 0,1, 'L');
		

		$testo="- si impegnano in solido a corrispondere all'Ente Gestore per l'anno scolastico ".$annoscolastico.", una quota annua a titolo di  QUOTA DI FREQUENZA così definita (v. <a href='downloadAllegato.php?nomeallegato=D_".$codscuola."'>Allegato D</a>): ";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
		$pdf->Ln(7);

		
		$pdf->SetFont($fontdefault,'',11);
		$n = 0;
		$totquotapromessa = 0;

		//TABELLINA********
		$pdf->Cell(55,8,"NOME e COGNOME","LTR",0,'C');
		$pdf->Cell(30,8,"# figlio","LTR",0,'C');
		$pdf->Cell(70,8,"Iscrizione alla classe","LTR",0,'C');
		//$pdf->Cell(30,8,"Tipo di Quota","LTR",0,'C');
		$pdf->Cell(35,8,"Quota annua euro","LTR",1,'C');
		while (mysqli_stmt_fetch($stmt)) {
			$totquotapromessa = $totquotapromessa + intval($quotapromessa_alu);
			$n++;
			$pdf->Cell(55,8,$nome_alu." ".$cognome_alu,1,0,'L');
			$pdf->Cell(30,8,$Nfiglio[$n].$MF[$mf_alu],1,0,'L');
			$pdf->Cell(70,8,$classi[$classe_cla],1,0,'L');
			//$pdf->Cell(30,8,$tipiquota[$tipoquota_alu],1,0,'C');
			$pdf->Cell(35,8,$quotapromessa_alu,1,1,'C');
		}
		$pdf->SetFont('TitilliumWeb-SemiBold','',12);
		$pdf->Cell(155,10,"Totale annuo quota di frequenza",1,0,'L');
		$pdf->Cell(35,10,$totquotapromessa,1,1,'C');

		$pdf->Ln(2);
		
		$dilazione= array(1=>"una sola rata entro il 15/12/".$anno1, 3=>"3 rate con scadenza 15 Settembre, 15 Gennaio e 15 Aprile", 10=>"10 mensilità pagate ".$scadpagamenti." da settembre a giugno", 12=>"12 mensilità pagate ".$scadpagamenti." da settembre a agosto");

		if ($ratepromesse_fam != 99) {
			$testo= "- tale quota verrà versata in <b>".$dilazione[$ratepromesse_fam]."</b>";
			$pdf->SetFont($fontdefault,'',11);
			$testo = utf8_decode($testo);
			$pdf->WriteHTML($testo);
			$pdf->Ln(7);
		} else {
			$testo= "- tale quota verrà versata secondo le scadenze sotto indicate";
			$pdf->SetFont($fontdefault,'',11);
			$testo = utf8_decode($testo);
			$pdf->WriteHTML($testo);
			$pdf->Ln(6);
			$pdf->Cell(0,15,"",1,1,'C');
			$pdf->Ln(2);
		}
		
		
		$testo= "- si impegnano al versamento della quota di iscrizione, pari ad euro ".$quotaiscrizione.", entro il ".$scadiscrizionelett.$anno1." o al momento dell'iscrizione.";
		$pdf->SetFont($fontdefault,'',11);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		
		if ($ISC_mostra_intestazionefatt ==1) {
			$pdf->Ln(12);
			$intestazionefattA= array("altro"=>"a", "padre"=>"al padre", "madre"=>"alla madre");
			$testo= "- chiedono che le fatture vengano intestate <b>".$intestazionefattA[$intestazionefatt_fam]."</b>";
			$pdf->SetFont($fontdefault,'',11);
			$testo = utf8_decode($testo);
			$pdf->WriteHTML($testo);
		}

		
		if ($ISC_mostra_tipopag == 1) {
			$pdf->Ln(7);
			$testo= "- scelgono di pagare <b>".$modalitapag[$modalitapag_fam]."</b>";
			$pdf->SetFont($fontdefault,'',11);
			$testo = utf8_decode($testo);
			$pdf->WriteHTML($testo);
		}
		$pdf->Ln(7);

		$testo= "I sottoscritti dichiarano di essere consapevoli che la scuola può utilizzare i dati contenuti nel presente modulo di iscrizione esclusivamente nell'ambito e per i fini istituzionali propri della Pubblica Amministrazione.";
		$pdf->SetFont($fontdefault,'',11);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$testo= "I sottoscritti dichiarano di condividere ed accettare quanto espresso nell'<a href='downloadAllegato.php?nomeallegato=D_".$codscuola."'>Allegato D</a> che è parte integrante del presente accordo.";
		$pdf->SetFont($fontdefault,'',11);
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);

		$pdf->SetXY(10,245);
		//FIRMA PADRE FIRMA MADRE DATA E LUOGO AFFIANCATI
		include("firmepadremadreluogo.php");


	}

//PAGINE CONTRATTO VERONA ********************************************************************************************
	if ($codscuola =='VR') {
		$pdf->AddPage();
	

		//I sottoscritti...
		$pdf->SetFont('TitilliumWeb-SemiBold','',16);
		$pdf->Cell(0,10,$titolocontratto, 0,1, 'C');
		$pdf->SetFont($fontdefault,'',11);

		$pdf->Ln(2);
		$testo="Con la presente scrittura privata, tra le parti:";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(2);
		$testo="- <b>Steiner Waldorf Verona Cooperativa Sociale Onlus</b>, con sede in Via Tione, 25 - 37069 Villafranca di Verona (VR) , di seguito 'Ente Gestore' e";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);

		$pdf->Ln(8);
		$testo="- Il Sig. <b>".strtoupper($cognomepadre_fam). " ".strtoupper($nomepadre_fam)."</b>, codice fiscale ". $cfpadre_fam ." nato il ". $datanascitapadre_fam." a ".$comunenascitapadre_fam." (".$provnascitapadre_fam."), residente a ". $comunepadre_fam." (".$provpadre_fam.")- ".$indirizzopadre_fam."<br>e la Sig.ra <b>".strtoupper($cognomemadre_fam). " ".strtoupper($nomemadre_fam). "</b>, codice fiscale ". $cfmadre_fam." nata il ". $datanascitamadre_fam." a ".$comunenascitamadre_fam." (".$provnascitamadre_fam."), residente a ". $comunemadre_fam." (".$provmadre_fam.") - ".$indirizzomadre_fam.", <br>genitori/esercenti la responsabilita' genitoriale di:".$nomi.".";  //utilizzo di $nomi

		if ($blank) {
			$testo="- Il Sig. __________________________, codice fiscale ____________________ nato il ___________ a __________________________ (___), residente a ________________________________ (___) Via/piazza_____________________________________________________________________<br> - e la Sig.ra ______________________, codice fiscale ____________________ nata il ___________ a __________________________ (___), residente a ________________________________ (___) Via/piazza_____________________________________________________________________ <br><b>genitori/esercenti la responsabilità genitoriale di<b>: ___________________________________________<br>";  //utilizzo di $nomi
		}
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);

		//$pdf->WriteHTML($testo);

		//PREMESSO CHE...
		$pdf->Ln(4);
		$pdf->SetFont('TitilliumWeb-SemiBold','',12);
		$pdf->Cell(0,8,"PREMESSO CHE", 0,1, 'C');
		$pdf->SetFont($fontdefault,'',11);

		$pdf->Ln(4);
		$testo="-	L'Ente Gestore gestisce una istituzione scolastica pubblica non statale primaria paritaria e una materna e secondaria di primo grado non paritarie;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="-	il suddetto Ente Gestore si finanzia in massima parte con contributi e donazioni delle famiglie; la puntualita' e regolarita' nei pagamenti sono necessari per la copertura delle spese del personale e per il buon funzionamento della Scuola;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="-	nell'economia dell'Ente Gestore la solidarietà della comunità scolastica rappresenta un presupposto irrinunciabile;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="-	si è presa visione e si condividono i principi che regolano il Percorso pedagogico (<a href='downloadAllegato.php?nomeallegato=A_".$codscuola."'>Allegato A</a>) ed il ".$POF_PTOF_PSD." e PEI della scuola (disponibili in segreteria o scaricabili dal sito www.scuolawaldorfverona.it);<br>";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
		if ($ISC_mostra_regolinterno ==1) {
			$pdf->Ln(4);
			$testo="-	si è presa visione e si condivide il Regolamento Interno (<a href='downloadAllegato.php?nomeallegato=B_".$codscuola."'>Allegato B</a>);<br>";
			$testo = utf8_decode($testo);
			$pdf->WriteHTML($testo);
		}
		if ($ISC_mostra_regolpediatrico ==1) {
			$pdf->Ln(4);
			$testo="-	si è presa visione e si condivide il Regolamento Pediatrico (<a href='downloadAllegato.php?nomeallegato=C_PD'>Allegato C</a>);<br>";
			$testo = utf8_decode($testo);
			$pdf->WriteHTML($testo);
		}
		$pdf->Ln(4);
		$testo="-	l'ammissione alla Scuola è subordinata al parere del Collegio degli Insegnanti e del Consiglio di Amministrazione;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="-	si dichiara di aver presentato domanda di iscrizione per l'anno scolastico ".$annoscolastico." obbligandosi, in caso di accettazione della medesima domanda da parte dell'Ente Gestore, a sottoscrivere il presente contratto di prestazione scolastica;
		";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		//TUTTO CIO'PREMESSO...
		$pdf->SetFont('TitilliumWeb-SemiBold','',12);
		$pdf->Cell(0,8,"TUTTO CIO' PREMESSO SI CONVIENE E SI STIPULA QUANTO SEGUE", 0,1, 'C');
		$pdf->SetFont($fontdefault,'',11);

		$pdf->Ln(4);
		$testo="art.1)	Le premesse e gli allegati richiamati sono parte integrante e sostanziale del presente atto;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="art.2)	l'Ente Gestore suindicato si obbliga nei confronti dell'altra parte contraente a fornire le prestazioni scolastiche previste dal PTOF della Scuola;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="art.3)	I genitori/tutori/esercenti la responsabilità genitoriale sono consapevoli delle conseguenze amministrative per chi rilasci dichiarazioni non corrispondenti a verità, ai sensi del D.P.R. 245/2000, anche in osservanza delle disposizioni sulla responsabilità genitoriale di cui agli artt. 316, 337 ter e 337 quater del codice civile che richiedono il consenso di entrambi i genitori;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		//-------

		$pdf->AddPage();
	

		$testo= "art.4)	I genitori/tutori/esercenti la responsabilità genitoriale si obbligano in solido a corrispondere all'Ente Gestore per l'anno scolastico ".$annoscolastico.", una quota annua a titolo di  CONTRIBUTO SCOLASTICO così come definito nell' <a href='downloadAllegato.php?nomeallegato=D_".$codscuola."'>Allegato D</a>:
		";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);


		$pdf->Ln(10);
		$pdf->SetFont($fontdefault,'',11);
		$n = 0;
		$totquotapromessa = 0;

		//TABELLINA********
		$pdf->Cell(75,5,"NOME e COGNOME","LTR",0,'C');
		$pdf->Cell(40,5,"# figlio","LTR",0,'C');
		$pdf->Cell(45,5,"Iscrizione alla classe","LTR",0,'C');
		$pdf->Cell(30,5,"Quota annua","LTR",1,'C');
		$pdf->Cell(75,5,"","LBR",0,'L');
		$pdf->Cell(40,5,"","LBR",0,'L');
		$pdf->Cell(45,5,"","LBR",0,'L');
		$pdf->Cell(30,5,"(euro)","LBR",1,'C');
		while (mysqli_stmt_fetch($stmt)) {
			$totquotapromessa = $totquotapromessa + intval($quotapromessa_alu);
			$n++;
			$pdf->Cell(75,8,$nome_alu." ".$cognome_alu,1,0,'L');
			$pdf->Cell(40,8,$Nfiglio[$n].$MF[$mf_alu],1,0,'L');
			$pdf->Cell(45,8,$classi[$classe_cla],1,0,'L');
			$pdf->Cell(30,8,$quotapromessa_alu,1,1,'C');
		}
		if ($blank) { //caso modulo BLANK
			for ($i = 1; $i <= 4; $i++) 
				{
					$n++;
					$pdf->Cell(75,8,"",1,0,'L');
					$pdf->Cell(40,8,"",1,0,'L');
					$pdf->Cell(45,8,"",1,0,'L');
					$pdf->Cell(30,8,"",1,1,'C');
				}
		}
		$pdf->SetFont('TitilliumWeb-SemiBold','',12);
		$pdf->Cell(45,10,"Totale contributo annuo ","LTB",0,'L');
		$pdf->Cell(30,10,"PROVVISORIO","TB",0,'C', True);
		$pdf->Cell(85,10," ad esclusione della quota di iscrizione","RTB",0,'L');
		if ($totquotapromessa !=0) {
			$pdf->Cell(30,10,$totquotapromessa,1,1,'C');
		} else {
			$pdf->Cell(30,10,"",1,1,'C');
		}


		/*if ($quotaconcordata_alu == 1) {
			$testo12= "(la quota espressa è soggetta ad approvazione da parte del Cons. di Amministrazione e potrà quindi subire variazioni, da concordare con la famiglia)";
			$testo12 = utf8_decode($testo12);
			$pdf->SetFont($fontdefault,'',9);
			$pdf->Cell(0,5,$testo12,0,1,"L");	
		}*/

		$testo12= "il versamento di tale quota annua avverrà in soluzione:";
		$testo12 = utf8_decode($testo12);
		$pdf->SetFont($fontdefault,'',11);
		$pdf->Cell(0,10,$testo12,0,1,"L");

		$unicasoluzione = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+1,5)."      unica entro il 05/09/".$anno1;
		if ($ratepromesse_fam == 1) {
			$unicasoluzione = $pdf->Image($imgsquarecrossed,$pdf->GetX(), $pdf->GetY()+1,5)."      unica entro il 05/09/".$anno1;
		}
		$pdf->Cell(0,8,$unicasoluzione,0,1,'L');


		$diecirate = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+1,5).utf8_decode("      DILAZIONATA entro il giorno 5 di ciascun mese in 10 mensilità (da settembre a giugno)");
		if ($ratepromesse_fam == 10) {
			$diecirate = $pdf->Image($imgsquarecrossed,$pdf->GetX(), $pdf->GetY()+1,5).utf8_decode("       DILAZIONATA entro il giorno 5 di ciascun mese in 10 mensilità (da settembre a giugno)");
		}
		if ($_SESSION['ISC_mostra_10rate'] == 1) {$pdf->Cell(0,8,$diecirate,0,1,'L');}

		$dodicirate = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+1,5).utf8_decode("      DILAZIONATA entro il giorno 5 di ciascun mese in 12 mensilità (da settembre a agosto)");
		if ($ratepromesse_fam == 12) {
			$dodicirate = $pdf->Image($imgsquarecrossed,$pdf->GetX(), $pdf->GetY()+1,5).utf8_decode("      DILAZIONATA entro il giorno 5 di ciascun mese in 12 mensilità (da settembre a agosto)");
		}			
		
		if ($_SESSION['ISC_mostra_12rate'] == 1) {$pdf->Cell(0,8,$dodicirate,0,1,'L');}

		if ($ISC_mostra_tipopag == 1) {
			$pdf->Ln(7);
			$testo= "Il pagamento avverrà <b>".$modalitapag[$modalitapag_fam].".</b>";
			$pdf->SetFont($fontdefault,'',11);
			$testo = utf8_decode($testo);
			$pdf->WriteHTML($testo);
		}

		$pdf->Ln(8);
		$pdf->SetFont($fontdefault,'',11);
		$testo= "art.5)	I genitori/tutori/esercenti la responsabilità genitoriale si impegnano a versare la quota di iscrizione pari a euro ".$quotaiscrizione." per l'anno scolastico ".$annoscolastico." entro il ".$scadiscrizionelett.$anno1.";";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);


		$pdf->Ln(4);

		if ($ISC_mostra_intestazionefatt ==1) {

			switch ($intestazionefatt_fam) {
				case "altro":
					$testointestazione ="a : ....................................................................................";
				break;
				case "padre":
					$testointestazione ="al padre, ".$nomepadre_fam." ".$cognomepadre_fam;
				break;
				case "madre":
					$testointestazione ="alla madre, ".$nomemadre_fam." ".$cognomemadre_fam;
				break;
				case null:
					$testointestazione ="a : ....................................................................................";
				}
			$testo= "I sottoscritti chiedono che le fatture vengano intestate <b>".$testointestazione."<b>";
			$pdf->SetFont($fontdefault,'',11);
			$testo = utf8_decode($testo);
			$pdf->WriteHTML($testo);
		}
		$pdf->Ln(8);
		$testo = "Le coordinate bancarie su cui effettuare i bonifici sono";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo, 0, 'C');

		$testo = "Credito Padano Banca di Credito cooperativo IBAN: IT14 O084 5459 9600 000 0011 5149 
		Il contributo annuo è dovuto anche in caso di prolungata assenza o ritiro anticipato dell'alunno.";

		$testo = utf8_decode($testo);
		$pdf->SetFont('TitilliumWeb-SemiBold','',12);
		$pdf->MultiCell(0,5,$testo, 0, 'C');
		$pdf->SetFont($fontdefault,'',11);

		$pdf->Ln(4);
		$testo= "Art.6) E' riconosciuto all'Ente Gestore il diritto di richiedere il rispetto dei tempi dei versamenti.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="Art.7) Nel caso di astensione prolungata dalle lezioni per cause non imputabili alla scuola (malattia, impegni sportivi, studio all'estero, etc.) è fatto obbligo ai genitori di continuare a versare le quote dovute secondo quanto stabilito.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="Art.8) In caso di ritiro /disdetta dell'iscrizione si riconosce all'Ente Gestore la facoltà di avvalersi del diritto di trattenere interamente la quota di iscrizione.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="In caso di risoluzione del contratto e di ritiro dell'alunno per cause non imputabili alla scuola, prima dell'inizio dell'anno scolastico, si riconosce all'Ente Gestore la facoltà di avvalersi del diritto di non restituire nessun importo già versato alla scuola, e i Genitori/Tutori/esercenti la responsabilità genitoriale si obbligano a versare all'Ente Gestore le quote relative a tre mensilità.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="In caso di ritiro durante l'anno scolastico è prevista una riduzione della quota annuale del 50% qualora questo avvenga prima del 31 dicembre, mentre la quota annuale è interamente dovuta in caso di ritiro successivo.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
		
		$pdf->Ln(4);
		$testo="Art.9) In applicazione di quanto previsto dall'art. 1456 c.c., in caso di violazione da parte dei Genitori/Tutori/esercenti la responsabilità genitoriale degli impegni contenuti nel presente contratto, l'Ente Gestore potrà risolvere di diritto il presente contratto comunicando ai Genitori/Tutori/esercenti la responsabilità genitoriale l'intenzione di avvalersi della presente clausola risolutiva.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="Art.10) Per quanto non previsto nel presente contratto, le cui clausole si intendono tutte essenziali ed inderogabili, si rinvia alle norme di legge in materia.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(4);
		$testo="Art.11) Ogni controversia inerente l'applicazione e /o l'interpretazione del presente contratto che non richieda l'intervento obbligatorio del Pubblico Ministero sarà fatta oggetto di un tentativo preliminare di mediazione presso l'organismo della Camera di Commercio di Verona. Foro competente è il foro di Verona.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
		

		//FIRMA PADRE FIRMA MADRE DATA E LUOGO AFFIANCATI
		$pdf->Ln(8);
		include("firmepadremadreluogo.php");

		$pdf->Ln(10);
		$pdf->Cell(60,5,"Per la ".$ragionesocialescuola,0,1,'C');
		$pdf->Cell(60,5,"(Il rappresentante legale)",0,1,'C');
		$pdf->Ln(4);
		$pdf->Cell(60,5,"","B",1);

	}

//PAGINA PRINCIPI CHE REGOLANO/REGOLAMENTO ECONOMICO *****************************************************************
	if ($codscuola =='PD') {
		$pdf->AddPage();
	

		$pdf->SetFont('TitilliumWeb-SemiBold','',16);
		$pdf->Cell(0,10,"PRINCIPI CHE REGOLANO IL PERCORSO PEDAGOGICO", 0,1, 'C');
		$pdf->Ln(8);

		$testo1 = "La ".$ragionesocialescuola." ritiene fondamentale che i genitori degli alunni iscritti siano a conoscenza sia dei principi alla base del percorso pedagogico proposto sia dei principi che regolano il corretto funzionamento dell'organismo sociale in cui si trovano come soci della Cooperativa.

		A tal fine, premesso che:
		a)	''La Cooperativa Sociale non ha scopo di lucro. Essa persegue l'interesse generale della comunità alla promozione umana e all'integrazione sociale dei cittadini...(omissis) (art 3 statuto)''
		b)	''La direzione pedagogica è affidata dal Consiglio di Amministrazione al Collegio degli Insegnanti, i quali adottano l'indirizzo pedagogico steineriano, con assoluta  libertà ed indipendenza delle scelte di carattere pedagogico'' (art 25 statuto).
		Si richiede la comprensione e la condivisione da parte dei genitori degli alunni iscritti, di alcuni aspetti fondamentali:
		a)	del piano di studi e dell'approccio educativo/pedagogico proposto, ispirato al pensiero di Rudolf Steiner
		b)	delle scelte attuate dal Collegio degli Insegnanti in accordo col Medico scolastico, sempre volte a sostenere un sano ed equilibrato sviluppo dell'alunno. Nell'ambito di tali scelte, nel caso fosse ritenuto necessario, potrebbero essere proposti dei percorsi, individuali o in piccoli gruppi, di euritmia, massaggio ritmico, laboratori artistici. Tali attività sono parte integrante della pedagogia steineriana ed è quindi necessario che i genitori supportino e condividano il percorso pedagogico nella sua completezza, sapendo che, in caso contrario, tale percorso sarebbe mancante di un aspetto fondamentale.
		c)	delle valutazioni pedagogiche attuate dal Collegio degli Insegnanti riguardanti sia  l'idoneità alla scolarizzazione (valutazione della maturità scolare dell'alunno/a per l'ingresso alla prima classe) sia l'accoglienza di allievi provenienti da scuole esterne.
		d)	dell'importanza di una continuità didattico-pedagogica dalla I° all'VIII° classe, necessaria per uno sviluppo armonico dell'alunno.
		e)	della possibilità, di ricorrere alla consulenza esterna in ambito pedagogico, per una valutazione psico-cognitiva dell'alunno (da effettuarsi c/o enti preposti). La più stretta collaborazione tra Famiglia, Collegio degli Insegnanti e Medico Scolastico, sono presupposti fondamentali per poter lavorare al meglio ed eventualmente tutelare, anche con una certificazione, l'alunno, al momento dell'esame di licenza media. 
		f)	dell'importanza di avvicinarsi alla conoscenza e alla comprensione dei principi che sono alla base del pensiero di R.Steiner relativamente all'essere umano nella sua triplice attività di Pensare Sentire e Volere come fondamento della struttura della Scuola Waldorf, in modo tale che all'interno della Scuola intesa come organismo, ciascuno possa trovare il proprio ruolo nella chiarezza e nel rispetto dei compiti che Steiner assegna al Collegio degli Insegnanti, al Consiglio di Amministrazione e ai Genitori, per una sana e corretta partecipazione alla vita della comunità scolastica. (Vedi allegato A, da conservare)
		g)	dell'importanza di partecipare, soprattutto nei primi anni, alle conferenze che la Scuola ogni anno propone al fine di comprendere i principi che regolano il percorso pedagogico.";
		$testo2 = "Nella ".$nomescuola." vengono accolte famiglie ed alunni che accettano consapevolmente di convivere rispettando le altrui scelte, siano esse di pensiero, religiose o terapeutiche. Chi chiede di entrare a farne parte è cosciente che questo comporta accogliere responsabilmente posizioni ed orientamenti di segno differenti dai propri, nella reciproca libertà, e si fa carico in ogni circostanza, delle conseguenze di questa presa di responsabilità.";

		$pdf->SetFont($fontdefault,'',10);
		$testo1 = utf8_decode($testo1);
		$pdf->MultiCell(0,5,$testo1);
		$pdf->Ln(3);
		$pdf->SetFont('TitilliumWeb-SemiBold','',10);
		$testo2 = utf8_decode($testo2);
		$pdf->MultiCell(0,5,$testo2);

		$pdf->SetXY(10,230);
		//FIRMA PADRE FIRMA MADRE DATA E LUOGO AFFIANCATI
		$pdf->Ln(8);
		include("firmepadremadreluogo.php");
	}

	if ($codscuola =='CI') {
		$pdf->AddPage();
	

		$pdf->SetFont('TitilliumWeb-SemiBold','',16);
		$pdf->Cell(0,10,"REGOLAMENTO INERENTE L'IMPEGNO ECONOMICO", 0,1, 'C');
		$pdf->Ln(2);

		$fontsizedefault = 10;
		$interlinea = 4.7;
		$dopoparagrafo = 2;

		$testo= "Questo regolamento ha lo scopo di creare una premessa chiara e trasparente nei rapporti economico/finanziari tra genitori e scuola, al fine di favorire un clima di reciproca fiducia e collaborazione.";
		$pdf->SetFont('TitilliumWeb-SemiBold','',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo);
		$pdf->Ln($dopoparagrafo);

		$testo= "1. Il contributo di gestione (retta annuale) rappresenta un impegno responsabile verso le necessità della scuola. Il suo ammontare annuale definito per alunno, viene determinato in fase di bilancio preventivo e successivamente confermato entro l'inizio effettivo dell'anno scolastico dal consiglio di amministrazione responsabile della gestione economica. La famiglia è invitata a scegliere consapevolmente la retta che può sostenere, tra la retta COMPLETA, RIDOTTA, MINIMA o MINIMA CON PIU' FIGLI.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo);
		$pdf->Ln($dopoparagrafo);

		$testo= "2. Le famiglie che non sono in grado di far fronte alla copertura del contributo economico, potranno rivolgersi al ''Fondo di Solidarietà Famiglie'' richiedendo in segreteria al momento dell'iscrizione, l'apposito modulo. La richiesta verrà vagliata attraverso un colloquio con il gruppo di gestione al fine di raccogliere parametri oggettivi utile a stilare una graduatoria di priorità. Al termine del giro di colloqui, il gruppo di gestione, in funzione delle richieste pervenute e del budget disponibile, darà una risposta nei termini fissati. Per queste famiglie il Modulo ''Impegno Economico'' deve essere comunque presentato e l'iscrizione verrà convalidata solo dopo aver raggiunto l'accordo economico.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo);
		$pdf->Ln($dopoparagrafo);

		$testo= "3. I versamenti del contributo di gestione devono avvenire regolarmente entro il giorno 05 del mese, preferibilmente per dieci mensilità (da settembre a giugno compresi), possibilmente con ordine permanente con bonifico bancario o postale.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo);
		$pdf->Ln($dopoparagrafo);

		$testo= "4. Chi lascia la scuola durante l'anno scolastico è tenuto a versare il contributo economico fino alla fine dell'anno in corso compreso di eventuale integrazione";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo);
		$pdf->Ln($dopoparagrafo);

		$testo= "5. Su eventuali contributi arretrati è facoltà dell'amministrazione esigere gli interessi equivalenti alle condizioni di mora previste per legge.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo);
		$pdf->Ln($dopoparagrafo);

		$testo= "6. Nel contributo di gstione non sono compresi i seguenti costi:
		- Quota d'iscrizione e quota accantonamento fondo progetti (vedi modulo di iscrizione ed impegno economico) 
		- Interventi di sostegno didattico, di pedagogia curativa, i percorsi pedagogici individualizzati e gli interventi terapeutici.
		- Materiale scolastico individuale (da versare quando richiesto e comunque entro la fine dell'anno scolastico).
		- Uscite didattiche, viaggi d'istruzione, gite, ecc.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo);
		$pdf->Ln($dopoparagrafo);

		$testo= "7. Al 31 Agosto ".$anno1." si riterranno valide le conferme annuali d'iscrizione alla classe successiva, solo se saranno stati eseguiti integralmente: il pagamento del contributo di gestione dovuto per l'anno in corso ".$anno_corrente.", il saldo delle spese del materiale, il saldo di eventuali contributi straordinari per il pareggio di bilancio.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo);
		$pdf->Ln($dopoparagrafo);

		$testo= "8. Entro il ".$scadiscrizionelett.$anno1." deve essere versata la quota d'iscrizione facendo pervenire in segreteria il ''Modulo di Iscrizione - Impegno Finanziario'', debitamente compilato e firmato.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo);
		$pdf->Ln($dopoparagrafo);

		$testo= "9. Entro il 30/09 dovranno essere versati: la quota associativa (euro 10 a socio) l'eventuale quota per le pulizie";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo);
		$pdf->Ln($dopoparagrafo);

		$testo= "10. Entro il 31/10 dovrà essere versata la quota a fondo progetti di euro 100 a famiglia, in base alla scelta effettuata.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo);
		$pdf->Ln($dopoparagrafo);

		$testo= "11. Per ogni alunno iscritto per la prima volta (materne o ciclo 1a - 8a) è richiesta una cauzione, a garanzia dei vari contributi di gestione. L'importo deve essere versato alla prima iscrizione dell'alunno presso la scuola Aurora. Di questi importi verrà rilasciata dalla scuola regolare ricevuta di avvenuto versamento. Al momento dell'uscita dei figli dalla scuola la cauzione verrà restituita, previa verifica di eventuali sospesi economici, o potrà essere liberamente donata dalla famiglia alla scuola.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo);
		$pdf->Ln($dopoparagrafo);

		$testo= "12. In caso di mancato rispetto degli accordi finanziari, esaurite le vie bonarie di soluzione, si procederà all'incasso per vie legali..";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo);
		$pdf->Ln($dopoparagrafo);

		$testo= "Il Consiglio di Amministrazione";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo, 0, "R");
		$pdf->Ln($dopoparagrafo);


	}

	if ($codscuola =='VR') {
		$pdf->AddPage();
	

		$pdf->SetFont('TitilliumWeb-SemiBold','',16);
		$pdf->Cell(0,10,"PRINCIPI CHE REGOLANO IL PERCORSO PEDAGOGICO", 0,1, 'C');
		$pdf->Ln(4);

		$testo1 = "La ".$ragionesocialescuola." ritiene fondamentale che i genitori/tutori degli alunni iscritti siano a conoscenza sia dei principi alla base del percorso pedagogico proposto sia dei principi che regolano il corretto funzionamento dell'organismo sociale in cui si trovano come soci della Cooperativa.
		A tal fine, premesso che:
		a)	La Steiner Waldorf Verona Cooperativa Sociale Onlus non ha scopo di lucro. ''Lo scopo principale che la Cooperativa intende perseguire è quello dell'interesse generale della comunità alla promozione umana e all'integrazione sociale dei cittadini, con lo svolgimento delle attività previste dal presente statuto e quindi l'attuazione di servizi socio assistenziali ed educativi e formativi, ai sensi dell'art. 1, lettera a) della Legge n. 381/1991... (omissis) (art. 3 dello statuto)''
		b)	La direzione pedagogica è affidata dal Consiglio di Amministrazione al Collegio degli Insegnanti, i quali adottano l'indirizzo pedagogico steineriano, con assoluta  libertà ed indipendenza delle scelte di carattere pedagogico.
		Si richiede la comprensione e la condivisione da parte dei genitori degli alunni iscritti, di alcuni aspetti fondamentali:
		a)	del piano di studi e dell'approccio educativo/pedagogico proposto, ispirato al pensiero di Rudolf Steiner
		b)	delle scelte attuate dal Collegio degli Insegnanti, sempre volte a sostenere un sano ed equilibrato sviluppo dell'alunno. Nell'ambito di tali scelte, nel caso fosse ritenuto necessario, potrebbero essere proposti dei percorsi, individuali o in piccoli gruppi, di euritmia, massaggio ritmico, laboratori artistici. Tali attività sono parte integrante della pedagogia steineriana ed è quindi necessario che i genitori supportino e condividano il percorso pedagogico nella sua completezza, sapendo che, in caso contrario, tale percorso sarebbe mancante di un aspetto fondamentale.
		c)	delle valutazioni pedagogiche attuate dal Collegio degli Insegnanti riguardanti sia  l'idoneità alla scolarizzazione (valutazione della maturità scolare dell'alunno/a per l'ingresso alla prima classe) sia l'accoglienza di allievi provenienti da scuole esterne.
		d)	dell'importanza di una continuità didattico-pedagogica dalla I° all'VIII° classe, necessaria per uno sviluppo armonico dell'alunno.
		e)	della possibilità, di ricorrere alla consulenza esterna in ambito pedagogico, per una valutazione psico-cognitiva dell'alunno (da effettuarsi c/o enti preposti). La più stretta collaborazione tra Famiglia, Collegio degli Insegnanti e Medico Scolastico, sono presupposti fondamentali per poter lavorare al meglio ed eventualmente tutelare, anche con una certificazione, l'alunno, al momento dell'esame di licenza media. 
		f)	dell'importanza di avvicinarsi alla conoscenza e alla comprensione dei principi che sono alla base del pensiero di R.Steiner relativamente all'essere umano nella sua triplice attività di Pensare Sentire e Volere come fondamento della struttura della Scuola Waldorf, in modo tale che all'interno della Scuola intesa come organismo, ciascuno possa trovare il proprio ruolo nella chiarezza e nel rispetto dei compiti che Steiner assegna al Collegio degli Insegnanti, al Consiglio di Amministrazione e ai Genitori, per una sana e corretta partecipazione alla vita della comunità scolastica. (Vedi allegato A, da conservare)
		g)	dell'importanza di partecipare agli incontri che la Scuola propone al fine di comprendere i principi che regolano il percorso pedagogico.";
		$testo2 = "Nella ".$nomescuola." vengono accolte famiglie ed alunni che accettano consapevolmente di convivere rispettando le altrui scelte, siano esse di pensiero, religiose o terapeutiche. Chi chiede di entrare a farne parte è cosciente che questo comporta accogliere responsabilmente posizioni ed orientamenti di segno differenti dai propri, nella reciproca libertà, e si fa carico in ogni circostanza, delle conseguenze di questa presa di responsabilità.";

		$pdf->SetFont($fontdefault,'',10);
		$testo1 = utf8_decode($testo1);
		$pdf->MultiCell(0,5,$testo1);
		$pdf->Ln(3);
		$pdf->SetFont('TitilliumWeb-SemiBold','',10);
		$testo2 = utf8_decode($testo2);
		$pdf->MultiCell(0,5,$testo2);

		$pdf->SetXY(10,230);
		//FIRMA PADRE FIRMA MADRE DATA E LUOGO AFFIANCATI
		$pdf->Ln(8);
		include("firmepadremadreluogo.php");
	}

//PAGINA DICHIARAZIONI ***********************************************************************************************

	$pdf->AddPage();


	$pdf->SetFont('TitilliumWeb-SemiBold','',16);
	$pdf->Cell(0,10,"DICHIARAZIONI", 0,1, 'C');
	$pdf->SetFont($fontdefault,'',10);
	$pdf->Ln(1);
	if ($ISC_mostra_sceltareligione == 0 && $ISC_mostra_premesso_che_lo_stato != 0) {
		$testo="Premesso che lo Stato assicura l'insegnamento della religione cattolica nelle scuole di ogni ordine e grado in conformità all'accordo che apporta modifiche al Concordato Lateranense (art. 9.2), il presente modulo costituisce richiesta dell'autorità scolastica in ordine all'esercizio del diritto di scegliere se avvalersi o non avvalersi dell'insegnamento della religione cattolica. I sottoscritti prendono atto che il ".$POF_PTOF_PSDext.", accettato all'atto della presente iscrizione, attualmente non prevede l'insegnamento specifico della religione intesa come materia curriculare che viene perciò sostituita da attività didattiche formative.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,4.3,$testo);
		$pdf->Ln(2);
	}

	$pdf->SetFont($fontdefault,'',10);
	$testo="Al fine dell'ammissione del/i proprio/i figlio/i i genitori dichiarano:";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,4.3,$testo);
	$pdf->Ln(2);

	if ($ISC_mostra_sceltareligione == 0 && $ISC_mostra_premesso_che_lo_stato != 0) {
		$testo="-	l'intenzione di non avvalersi per il/i proprio/i figlio/i dell'insegnamento della religione cattolica";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,4.3,$testo);
		$pdf->Ln(2);
	}

	if ($ISC_mostra_dietespeciali == 1) {
		$testo="-	che nel caso il/i proprio/i figlio/i fosse/ro affetto/i da allergie, intolleranze o patologie che richiedano diete speciali ne daranno tempestiva comunicazione alla segreteria della Scuola tramite la compilazione del <a href='downloadAllegato.php?nomeallegato=E'>MODULO DI RICHIESTA DIETE SPECIALI</a>  corredato da certificato medico specialistico";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
	} else {
		$testo="-	che nel caso il/i proprio/i figlio/i fosse/ro affetto/i da allergie ad alimenti, farmaci, insetti, metalli o altro ne daranno tempestiva comunicazione alla segreteria allegando certificato medico specialistico";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,4.3,$testo);
	}

	$pdf->Ln(5);
	$pdf->SetFont($fontdefault,'',10);
	$testo="-	che si impegnano a comunicare qualsiasi variazione riguardante i propri dati anagrafici entro e non oltre 30 giorni dalla variazione";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,4.3,$testo);
	$pdf->Ln(1);

	$testo="-	che il nucleo familiare è così composto";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,4.3,$testo);

	$pdf->Ln(2);
	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(10,5,"","TRL",0,'C');
	$pdf->Cell(40,5,"COGNOME","TRL",0,'C');
	$pdf->Cell(40,5,"NOME","TRL",0,'C');
	$pdf->Cell(70,5,"LUOGO E DATA DI NASCITA","TRL",0,'C');
	$pdf->Cell(30,5,"GRADO DI","TRL",1,'C');
	$pdf->Cell(10,5,"","RLB",0,'C');
	$pdf->Cell(40,5,"","RLB",0,'C');
	$pdf->Cell(40,5,"","RLB",0,'C');
	$pdf->Cell(70,5,"","RLB",0,'C');
	$pdf->Cell(30,5,"PARENTELA","RLB",1,'C');
		
	$pdf->SetFont($fontdefault,'',11);
	$pdf->SetWidths(array(10,40, 40,70,30));

	$i = 1;
	if ($ckpadreesclusodanucleo_fam != 1) {
		$pdf->Row(array($i, $cognomepadre_fam, $nomepadre_fam, $comunenascitapadre_fam."-".$provnascitapadre_fam."-".$datanascitapadre_fam, "padre"));
		$i++;
	}
	if ($ckmadreesclusadanucleo_fam != 1) {
		$pdf->Row(array($i, $cognomemadre_fam, $nomemadre_fam, $comunenascitamadre_fam."-".$provnascitamadre_fam."-".$datanascitamadre_fam, "madre"));
		$i++;
	}

	$sql = "SELECT ID_alu, nome_alu, cognome_alu, mf_alu, datanascita_alu, comunenascita_alu, provnascita_alu, paesenascita_alu  ".
	"FROM tab_famiglie LEFT JOIN tab_anagraficaalunni ON ID_fam = ID_fam_alu WHERE ID_fam= ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu, $nome_alu, $cognome_alu, $mf_alu, $datanascita_alu, $comunenascita_alu, $provnascita_alu, $paesenascita_alu);
	$nriga = $i;
	while (mysqli_stmt_fetch($stmt)) {
		if ($mf_alu == "M"){$figliofiglia = "figlio";} else {$figliofiglia = "figlia";}
		$datanascita_alu = date('d/m/Y', strtotime(str_replace('-','/', $datanascita_alu)));
		$pdf->Row(array($nriga, $cognome_alu, $nome_alu, $comunenascita_alu."-".$provnascita_alu."-".$datanascita_alu, $figliofiglia));
		$nriga++;
	}

	if ($blank) { //caso modulo BLANK
		for ($i = 1; $i <= 4; $i++) 
			{
				
				$pdf->Row(array($nriga, "", "", "", ""));
				$nriga++;
			}
	}


	$sql = "SELECT ID_cfa, nome_cfa, cognome_cfa, dataluogonascita_cfa, gradoparentela_cfa FROM tab_composizionefam WHERE ID_fam_cfa= ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_cfa, $nome_cfa, $cognome_cfa, $dataluogonascita_cfa, $gradoparentela_cfa);
	while (mysqli_stmt_fetch($stmt)) {
		$pdf->Row(array($nriga, $cognome_cfa, $nome_cfa, $dataluogonascita_cfa, $gradoparentela_cfa));
		$nriga++;
	}

	$pdf->SetXY(10,170);
	//FIRMA PADRE FIRMA MADRE E LEGALE RAPPRESENTANTE AFFIANCATI
	$pdf->Ln(8);
	include("firmepadremadreluogo.php");

//PARTE FIRMA UNICO GENITORE ****************************************************************************************
	if ($ISC_mostra_firmaunica ==1) {


		$pdf->SetXY(10,200);

		$pdf->SetFont('TitilliumWeb-SemiBold','',14);
		$pdf->Cell(0,8,utf8_decode("SOLO NEL CASO IN CUI LA DOMANDA VENGA FIRMATA DA UN SOLO GENITORE"), 0,1, 'C', True);

		$testo= 'Questo Documento è composto di {nb} pagine compresa questa.';
		$pdf->Ln(3);
		$pdf->SetFont($fontdefault,'',10);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$testo= "<n>Il/la sottoscritto/a, consapevole delle conseguenze amministrative e penali per chi rilasci dichiarazioni non corrispondenti a verita', ai sensi del DPR 445/2000, dichiara di avere effettuato tutte le scelte in esso comprese in osservanza delle disposizioni sulla responsabilita' genitoriale di cui agli artt. 316, 337 ter e 337 quater c.c., che richiedono il consenso di <b> entrambi </b> i genitori.<n>Dichiara in particolare che <b>la scelta del".$istituzione_supporto." per i minori indicati nel documento e' stata condivisa.</b>";
		$pdf->Ln(3);
		$pdf->SetFont($fontdefault,'',10);
		$testo = utf8_decode($testo);
		$pdf->WriteTag(0,4,utf8_decode($testo),"","J",0,0);
		$pdf->SetX(10);
		$pdf->Cell(0,8,"(Apporre la firma nello spazio apposito e barrare l'altro spazio.)",0,1,'L');



		$pdf->Ln(2);
		include("firmepadremadreluogo.php");
	}


//PAGINA CONSENSI ****************************************************************************************************
	$sql = "SELECT ID_alu, mf_alu, nome_alu, cognome_alu, ckprivacy1_alu, ckprivacy2_alu, ckprivacy3_alu, ckautfoto_alu, ckautmateriale_alu, ckautuscite_alu FROM (tab_famiglie JOIN tab_anagraficaalunni ON ID_fam_alu = ID_fam) WHERE ID_fam= ? AND noniscritto_alu = 0 ORDER BY datanascita_alu ASC";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu, $mf_alu, $nome_alu, $cognome_alu, $ckprivacy1_alu, $ckprivacy2_alu, $ckprivacy3_alu, $ckautfoto_alu, $ckautmateriale_alu, $ckautuscite_alu);
	$nn = 0;
	$ckautfoto_aluA = array();
	$ckautmateriale_aluA = array();
	$ckautuscite_aluA =  array();

	$nomi="";
	while (mysqli_stmt_fetch($stmt)) {
		//per decidere se fare successivamente un solo modulo per le autorizzazioni oppure uno per figlio guardo se le tre autorizzazioni sono uguali
		$ckautfoto_aluA[$nn] = $ckautfoto_alu;
		$ckautmateriale_aluA[$nn] = $ckautmateriale_alu;
		$ckautuscite_aluA[$nn] = $ckautuscite_alu;
		$nn++;
		$nomi = $nomi.$nome_alu." ".$cognome_alu.", ";
	}


	$fratelli = $nn;
	if ((count(array_unique($ckautfoto_aluA)) <= 1) && (count(array_unique($ckautmateriale_aluA)) <= 1) && (count(array_unique($ckautuscite_aluA)) <= 1)) {
		$autorizztutteuguali = 1;
	} else {
		$autorizztutteuguali = 0;
	}


	//a rigore non è corretto: ci vorrebbero n moduli, uno per ogni figlio: per la privacy li mettiamo insieme perchè tanto i consensi sono tutti obbligatori, ma per gli altri consensi non si può, in quanto potrebbero essere stati forniti consensi diversi a seconda del figlio
	$nomi = substr ($nomi, 0,-2);


	$pdf->AddPage();


	$pdf->SetFont('TitilliumWeb-SemiBold','',16);
	if ($nn ==1) {
		$pdf->Cell(0,8,utf8_decode("DICHIARAZIONE DI RESPONSABILITA' GENITORIALE SUL MINORE"), 0,1, 'C');
	} else {
		$pdf->Cell(0,8,utf8_decode("DICHIARAZIONE DI RESPONSABILITA' GENITORIALE SUI MINORI"), 0,1, 'C');
	}
	$pdf->SetFont($fontdefault,'',12);
	
	if ($blank) {
		$pdf->Cell(0,8,".............................................................................................................", 0,1, 'C');
	} else {
		$pdf->Cell(0,8,utf8_decode($nomi), 0,1, 'C');
	}
	$testo4="Con la presente dichiariamo di aver acquisito le informazioni fornite dal titolare del trattamento e compreso e condiviso il significato di quanto sopra indicato, facendo salvo il rinvio a tutta la normativa vigente e applicabile alla materia, consapevoli che i servizi da noi richiesti, ovvero richiesti da nostro/a figlio/a minore di 14 anni di età, ricadono nell'ambito della società dell'informazione e pertanto secondo la norma (art. 8 Regolamento UE 2016/679) è necessario che il consenso sia prestato o autorizzato dai titolari della responsabilità genitoriale sul minore (DPR 28/2/2000 N. 445 Art. 46 punto ''u'').";

	$pdf->Ln(1);
	$pdf->SetFont($fontdefault,'',10);
	$testo4 = utf8_decode($testo4);
	$pdf->MultiCell(0,5,$testo4);
	$pdf->Ln(3);

	$pdf->SetFont('TitilliumWeb-SemiBold','',11);
	$pdf->Cell(0,10,utf8_decode("Dichiaro di essere titolare della responsabilità genitoriale "), 0,1, 'C');
				//FIRMA PADRE FIRMA MADRE E DATA E LUOGO AFFIANCATI
				$pdf->Ln(3);
				include("firmepadremadreluogo.php");


	$pdf->SetFont('TitilliumWeb-SemiBold','',16);
	$pdf->Ln(10);
	$pdf->Cell(0,10,utf8_decode("DICHIARAZIONI DI CONSENSO AL TRATTAMENTO DEI DATI PERSONALI"), 0,1, 'C');
	$pdf->SetFont('TitilliumWeb-SemiBold','',11);

	if ($nn == 1) {
		$frasenelcaso = "Nel caso in cui vengano negati i seguenti consensi la Scuola non potrà dare seguito all'iscrizione dell'alunno";
	} else {
		$frasenelcaso = "Nel caso in cui vengano negati i seguenti consensi la Scuola non potrà dare seguito all'iscrizione degli alunni";
	}
	//$pdf->Cell(0,10,utf8_decode($frasenelcaso), 0,1, 'C'); TOLTA QUESTA FRASE 10/06/2021

	//privacy1 ****************************************************************************************************************************************
	$pdf->SetFont($fontdefault,'',11);

	if ($blank) { //caso modulo BLANK
		$pdf->Cell(95,7,"Presto il consenso".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
		$pdf->Cell(95,7,"Nego il consenso".$pdf->Image($imgsquare,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 
	} else {
		if ($ckprivacy1_alu == 1) {
			$pdf->Cell(95,7,"Presto il consenso".$pdf->Image($imgsquarecrossed,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
			$pdf->Cell(95,7,"Nego il consenso".$pdf->Image($imgsquare,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 
		} else {
			$pdf->Cell(95,7,"Presto il consenso".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
			$pdf->Cell(95,7,"Nego il consenso".$pdf->Image($imgsquarecrossed,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 
		}
	}
	$pdf->Ln(8);
	$pdf->Cell(0,5,utf8_decode("al trattamento dei dati personali al fine di permettere di gestire le attività di istruzione"),0,1,"C");
	$pdf->Cell(0,5,utf8_decode("educative e formative stabilite dal ".$POF_PTOF_PSDext),0,1,"C");


				//FIRMA PADRE FIRMA MADRE E DATA E LUOGO AFFIANCATI
				$pdf->Ln(3);
				include("firmepadremadreluogo.php");




	$pdf->Ln(8);
	//Tratteggio di separazione
	$pdf->SetDash(1,1); //5mm on, 5mm off;
	$pdf->Cell(190,1,"" , "B" ,0, 'L');
	$pdf->SetDash(); //Restore dash
	$pdf->SetDrawColor(0,0,0);
	$pdf->Ln(5);
	//privacy2 ****************************************************************************************************************************************
	$pdf->SetFont($fontdefault,'',11);
	if ($blank) { //caso modulo BLANK
		$pdf->Cell(95,7,"Presto il consenso".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
		$pdf->Cell(95,7,"Nego il consenso".$pdf->Image($imgsquare,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 
	} else {
		if ($ckprivacy2_alu == 1) {
			$pdf->Cell(95,7,"Presto il consenso".$pdf->Image($imgsquarecrossed,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
			$pdf->Cell(95,7,"Nego il consenso".$pdf->Image($imgsquare,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 
		} else {
			$pdf->Cell(95,7,"Presto il consenso".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
			$pdf->Cell(95,7,"Nego il consenso".$pdf->Image($imgsquarecrossed,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 
		}
	}
	$pdf->Ln(8);
	$pdf->Cell(0,5,utf8_decode("al trattamento dei dati identificativi degli orientamenti religiosi, politici e relativi alla salute"),0,1,"C");
	$pdf->Cell(0,5,utf8_decode("al solo fine di permettere di gestire le attività di istruzione, educative e formative stabilite dal ".$POF_PTOF_PSD),0,1,"C");
				
				//FIRMA PADRE FIRMA MADRE E DATA E LUOGO AFFIANCATI
				$pdf->Ln(3);
				include("firmepadremadreluogo.php");
	$pdf->Ln(8);
	//Tratteggio di separazione
	$pdf->SetDash(1,1); //5mm on, 5mm off;
	$pdf->Cell(190,1,"" , "B" ,0, 'L');
	$pdf->SetDash(); //Restore dash
	$pdf->SetDrawColor(0,0,0);
	$pdf->Ln(5);
	//privacy3 ****************************************************************************************************************************************
	$pdf->SetFont($fontdefault,'',11);
	if ($blank) { //caso modulo BLANK
		$pdf->Cell(95,7,"Presto il consenso".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
		$pdf->Cell(95,7,"Nego il consenso".$pdf->Image($imgsquare,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 
	} else {
		if ($ckprivacy3_alu == 1) {
			$pdf->Cell(95,7,"Presto il consenso".$pdf->Image($imgsquarecrossed,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
			$pdf->Cell(95,7,"Nego il consenso".$pdf->Image($imgsquare,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 
		} else {
			$pdf->Cell(95,7,"Presto il consenso".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
			$pdf->Cell(95,7,"Nego il consenso".$pdf->Image($imgsquarecrossed,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 
		}
	}
	$pdf->Ln(8);
	$pdf->Cell(0,5,utf8_decode("per l'invio di comunicazioni elettroniche anche tramite messaggi SMS, MMS ecc. "),0,1,"C");
	$pdf->Cell(0,5,utf8_decode("e/o posta elettronica E-MAIL e/o fax ai recapiti da me forniti per finalità informative"),0,1,"C");

	//

				//FIRMA PADRE FIRMA MADRE E DATA E LUOGO AFFIANCATI
				$pdf->Ln(3);
				include("firmepadremadreluogo.php");


//PAGINA LIBERATORIE *************************************************************************************************
	$pdf->SetFillColor(220,220,220);
	
	
	$sql = "SELECT ID_alu, mf_alu, nome_alu, cognome_alu, ckautfoto_alu, ckautmateriale_alu, ckautuscite_alu FROM (tab_famiglie JOIN tab_anagraficaalunni ON ID_fam_alu = ID_fam) WHERE ID_fam= ? AND noniscritto_alu = 0 ORDER BY datanascita_alu ASC";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu, $mf_alu, $nome_alu, $cognome_alu, $ckautfoto_alu, $ckautmateriale_alu, $ckautuscite);
	$nn = 0;


	while (mysqli_stmt_fetch($stmt)) {
		$nn++;
		//se $autorizztutteuguali = 1 allora devo produrre un solo modulo, altrimenti ne devo produrre uno per figlio
		if (($autorizztutteuguali == 1) && ($nn >1)) { goto fineloop;} 
		$pdf->AddPage();
	

		$pdf->SetFont('TitilliumWeb-SemiBold','',16);
		$pdf->Cell(0,10,utf8_decode("LIBERATORIA"), 0,1, 'C');
		$pdf->SetFont($fontdefault,'',12);
		// solo se $autorizztutteuguali = 0 allora devo produrre un modulo per figlio specificando quale
		if ($autorizztutteuguali == 0) {
			$pdf->Cell(0,10,utf8_decode($nome_alu." ".$cognome_alu), 0,1, 'C');
		} else {
			$pdf->Cell(0,10,utf8_decode($nomi), 0,1, 'C');
		} 
		$pdf->Ln(2);
		$pdf->SetFont('TitilliumWeb-SemiBold','',14);
		$pdf->Cell(0,8,utf8_decode("A.	UTILIZZO DI RIPRESE VIDEO E IMMAGINI FOTOGRAFICHE"), 0,1, 'C', True);
		$testo5= "Informativa per la pubblicazione dei dati
		Ai sensi degli artt. 10 e 320 cod. civ. e degli artt. 96 e 97 legge 22.4.1941, n. 633, Legge sul diritto d'autore, unitamente all'art. 13 del D. Lgs. n. 196/2003 e degli artt. 13-14 Regolamento UE n. 676/2016, si informa che i dati personali conferiti con la liberatoria allegata saranno trattati con modalità cartacee e telematiche nel rispetto della vigente normativa e dei principi di correttezza, liceità, trasparenza e riservatezza; in tale ottica i dati forniti, ivi inclusi ritratti contenuti nelle fotografie, potranno essere utilizzati per la pubblicazione su sito internet, su carta stampata e/o su qualsiasi altro mezzo di diffusione, nonché conservate negli archivi informatici, con finalità a carattere  meramente collegato alle attività svolte.
		La richiesta ha ad oggetto un dato biometrico normativamente definito dall'art. 4, punto 14 del Regolamento UE n. 676/2016. 
		A scopo di completezza si specifica che, in materia di privacy, rappresenta giurisprudenza consolidata il ritenere che una grave ed oggettiva imperfezione fisica o una deformazione del volto, possano essere considerate elementi sufficienti a legittimare il diniego del consenso all'inserimento della foto.
		Con riferimento alle foto e/o alle riprese audio/video scattate e/o riprese dalla ".$ragionesocialescuola." con la presente:";
		$pdf->Ln(3);
		$pdf->SetFont($fontdefault,'',9);
		$testo5 = utf8_decode($testo5);
		$pdf->MultiCell(0,5,$testo5);
		$pdf->SetFont($fontdefault,'',10);
		if ($ckautfoto_alu == 1) {
		$pdf->Cell(95,7,"Autorizzo".$pdf->Image($imgsquarecrossed,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
		$pdf->Cell(95,7,"Non Autorizzo".$pdf->Image($imgsquare,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 
		} else {
			$pdf->Cell(95,7,"Autorizzo".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
			$pdf->Cell(95,7,"Non Autorizzo".$pdf->Image($imgsquarecrossed,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 
		}
		$testo6= "la stessa a titolo gratuito, anche ai sensi degli artt. 10 e 320 cod. civ. e degli artt. 96 e 97 legge 22.4.1941, n. 633, Legge sul diritto d'autore, l'acquisizione di immagini e riprese video per la pubblicazione su sito internet, su carta stampata e/o su qualsiasi altro mezzo di diffusione, nonché conservate negli archivi informatici, con finalità a carattere  meramente collegato alle attività svolte.";
		$pdf->Ln(8);
		$pdf->SetFont($fontdefault,'',9);
		$testo6 = utf8_decode($testo6);
		$pdf->MultiCell(0,5,$testo6);
		
		// MATERIALE PRODOTO
		$pdf->Ln(2);
		$pdf->SetFont('TitilliumWeb-SemiBold','',14);
		if (($autorizztutteuguali == 1) && ($fratelli != 1)) {
			$titoloUtilizzo = "B.	UTILIZZO DEL MATERIALE PRODOTTO DAGLI ALUNNI";
		} else {
			$titoloUtilizzo = "B.	UTILIZZO DEL MATERIALE PRODOTTO DALL'ALUNNO";
		}
		$pdf->Cell(0,8,utf8_decode($titoloUtilizzo), 0,1, 'C', True);
		$testo7= "Considerato che nello svolgimento delle attività per documentare i percorsi ed i progressi svolti ci si può trovare nella condizione di utilizzare elaborati di vario tipo (relazioni, disegni, temi, fotografie, filmati, registrazioni, ...) ";
		$pdf->Ln(3);
		$pdf->SetFont($fontdefault,'',9);
		$testo7 = utf8_decode($testo7);
		$pdf->MultiCell(0,5,$testo7);
		$pdf->SetFont($fontdefault,'',10);
		if ($ckautmateriale_alu == 1) {
		$pdf->Cell(95,7,"Autorizzo".$pdf->Image($imgsquarecrossed,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
		$pdf->Cell(95,7,"Non Autorizzo".$pdf->Image($imgsquare,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 
		} else {
			$pdf->Cell(95,7,"Autorizzo".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
			$pdf->Cell(95,7,"Non Autorizzo".$pdf->Image($imgsquarecrossed,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 
		}
		$testo8= "l'Istituto a servirsi di tale documentazione a testimonianza e a corredo di quanto si realizza, nel rispetto della normativa sulla privacy.
		La presente liberatoria/autorizzazione potrà essere revocata in ogni tempo con comunicazione scritta da inviare via posta comune o e-mail.";
		$pdf->Ln(8);
		$pdf->SetFont($fontdefault,'',9);
		$testo8 = utf8_decode($testo8);
		$pdf->MultiCell(0,5,$testo8);
		
		// USCITE BREVI
		$pdf->Ln(2);
		$pdf->SetFont('TitilliumWeb-SemiBold','',14);
		$pdf->Cell(0,8,utf8_decode("C.	USCITE BREVI"), 0,1, 'C', True);
		$pdf->SetFont($fontdefault,'',10);
		if ($ckautuscite_alu == 1) {
		$pdf->Cell(95,7,"Autorizzo".$pdf->Image($imgsquarecrossed,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
		$pdf->Cell(95,7,"Non Autorizzo".$pdf->Image($imgsquare,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 
		} else {
			$pdf->Cell(95,7,"Autorizzo".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
			$pdf->Cell(95,7,"Non Autorizzo".$pdf->Image($imgsquarecrossed,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 
		}
		$testo9= "le uscite sul territorio cittadino all'interno dell'orario scolastico. Tali uscite saranno man mano presentate ai genitori nell'ambito delle riunioni periodiche. Gli alunni saranno accompagnati dai docenti. Sarà cura dei docenti dare avviso dell'uscita mediante brevi comunicazioni sul diario alcuni giorni prima delle visite previste. Con la presente si esonera anche l'Amministrazione da qualsiasi responsabilità derivante da comportamenti dell'alunno/a difformi dalle disposizioni impartite dai docenti.";
		$pdf->Ln(8);
		$pdf->SetFont($fontdefault,'',9);
		$testo9 = utf8_decode($testo9);
		$pdf->MultiCell(0,5,$testo9);

		$pdf->SetXY(10,230);
		//FIRMA PADRE FIRMA MADRE E DATA E LUOGO AFFIANCATI
		$pdf->Ln(8);
		include("firmepadremadreluogo.php");
	fineloop:
		
	}



//PAGINA MODULO ADESIONE SOCIO ***************************************************************************************
	include_once("AllegatoF_ModuloAdesioneSocio.php");


//Modulo SDD EX RID **************************************************************************************************
	if 	($ISC_include_SDD ==1) {
		$pdf->AddPage();
	


		switch ($intestazionefatt_fam) {
			case "altro":
				$nome = "";
				$cognome = "";
				$indirizzo = "";
				$comune = "";
				$prov = "";
				$CAP = "";
				$CF = "                ";
			break;
			case "padre":
				$nome = $nomepadre_fam;
				$cognome = $cognomepadre_fam;
				$indirizzo = $indirizzopadre_fam;
				$comune = $comunepadre_fam;
				$prov = $provpadre_fam;
				$CAP = $CAPpadre_fam;
				$CF = $cfpadre_fam;
			break;
			case "madre":
				$nome = $nomemadre_fam;
				$cognome = $cognomemadre_fam;
				$indirizzo = $indirizzomadre_fam;
				$comune = $comunemadre_fam;
				$prov = $provmadre_fam;
				$CAP = $CAPmadre_fam;
				$CF = $cfmadre_fam;
			break;
			case null:
				$nome = "";
				$cognome = "";
				$indirizzo = "";
				$comune = "";
				$prov = "";
				$CAP = "";
				$CF = "                ";
				
			}




		$pdf->SetFont('TitilliumWeb-SemiBold','',11);
		$pdf->MultiCell(0,5,utf8_decode("Mandato per addebito diretto SEPA - SDD Core (Area Unica dei Pagamenti in Euro) n° |__|__|__ /20__"), 0, "C");
		$pdf->Ln(2);
		$testo="Con la sottoscrizione del presente mandato, si autorizza la ".$ragionesocialescuola." a richiedere alla banca del debitore l'addebito sul suo conto e l'autorizzazione alla banca del debitore di procedere a tale addebito conformemente alle disposizioni impartite dalla ".$ragionesocialescuola." relativamente alle
		rette scolastiche della ".$nomescuola." per i seguenti alunni: ";


		$pdf->SetFont($fontdefault,'',9);
		$pdf->MultiCell(0,5,utf8_decode($testo), 1, "J");

		$pdf->Ln(2);
		$pdf->SetFont('TitilliumWeb-SemiBold','',11);

		$pdf->Cell(0,5,$nomi, 0,1, 'C');


		$pdf->Ln(2);

		$pdf->Cell(0,5,"FATTURA INTESTATA ". $testointestazione, 1,1, 'L');
		$pdf->SetFont($fontdefault,'',9);

		$hriga = 6;
		$w1 = 30;
		$w2 = 65;
		$w3 = 25;
		$w4 = 90;
		$w5 = 10;
		$w6 = 20;
		$w7 = 4.7;
		$w8 = 155;
		$w9 = 15;
		$w10 = 20;
		$wgap = 1;

	//DEBITORE
		$pdf->SetXY(10,75);
		$pdf->Cell(0,50,"", 1,1, 'L');
		$pdf->SetXY(10,75);
		$pdf->Cell(0,5,"DATI RELATIVI AL DEBITORE (intestatario del Conto Corrente di addebito)", 0,1, 'L');
		$pdf->SetXY(10,80);
		$pdf->Cell($w1,$hriga,"Cognome ",0,0,'R');
		$pdf->Cell($w2,$hriga,$cognome,1,0,'L');
		$pdf->Cell($w3,$hriga,"Nome ",0,0,'R');
		$pdf->Cell($w2,$hriga,$nome,1,1,'L');

		$pdf->Ln(2);
		$pdf->Cell($w1,$hriga,"Indirizzo e N.",0,0,'R');
		$pdf->Cell($w4,$hriga,$indirizzo,1,1,'L');


		$pdf->Ln(2);
		$pdf->Cell($w1,$hriga,"Comune ",0,0,'R');
		$pdf->Cell($w4,$hriga,$comune,1,0,'L');
		$pdf->Cell($w10,$hriga,"Prov ",0,0,'R');
		$pdf->Cell($w5,$hriga,$prov,1,0,'L');
		$pdf->Cell($w9,$hriga,"CAP ",0,0,'R');
		$pdf->Cell($w6,$hriga,$CAP,1,1,'L');

		$pdf->Ln(2);
		$pdf->Cell($w1,$hriga,"Cod. Fiscale ",0,0,'R');
		$pdf->SetFont($fontdefault,'',12);
		for ($x = 1; $x <= 16; $x++) {
			$pdf->Cell($w7,$hriga,substr($CF, $x-1, 1),1,0,'L');
			$pdf->Cell($wgap,$hriga,"",0,0,'L');
		}
		$pdf->SetFont($fontdefault,'',9);


		$pdf->Ln(12);
		$pdf->Cell($w1,$hriga,"Cod. IBAN ",0,0,'R');
		for ($x = 1; $x <= 27; $x++) {
			$pdf->Cell($w7,$hriga,"",1,0,'L');
			$pdf->Cell($wgap,$hriga,"",0,0,'L');
		}

	// CREDITORE
		$pdf->SetXY(10,125);
		$pdf->Cell(0,30,"", 1,1, 'L');
		$pdf->SetXY(10,125);
		$pdf->Cell(0,5,"DATI RELATIVI AL CREDITORE", 0,1, 'L');
		$pdf->SetXY(10,130);

		$pdf->Cell($w1,$hriga,"Rag. Sociale ",0,0,'R');
		$pdf->Cell($w8,$hriga,utf8_decode($ragionesocialescuola),1,1,'L');

		$pdf->Ln(2);
		$pdf->Cell($w1,$hriga,"Cod. Identificativo ",0,0,'R');	
		$pdf->Cell($w8,$hriga,$codIdentificativo,1,1,'L');

		$pdf->Ln(2);
		$pdf->Cell($w1,$hriga,"Sede Legale ",0,0,'R');	
		$pdf->Cell($w8,$hriga,utf8_decode($indirizzoscuola),1,0,'L');

	//SOTTOSCRITTORE
		$pdf->SetXY(10,155);
		$pdf->Cell(0,38,"", 1,1, 'L');
		$pdf->SetXY(10,155);
		$pdf->Cell(0,5,"DATI RELATIVI AL SOTTOSCRITTORE (nel caso in cui Sottoscrittore e Debitore NON coincidano)", 0,1, 'L');
		$pdf->SetXY(10,160);
		$pdf->Cell($w1,$hriga,"Cognome ",0,0,'R');
		$pdf->Cell($w2,$hriga,"",1,0,'L');
		$pdf->Cell($w3,$hriga,"Nome ",0,0,'R');
		$pdf->Cell($w2,$hriga,"",1,1,'L');

		$pdf->Ln(2);
		$pdf->Cell($w1,$hriga,"Indirizzo e N. ",0,0,'R');
		$pdf->Cell($w4,$hriga,"",1,1,'L');

		$pdf->Ln(2);
		$pdf->Cell($w1,$hriga,"Comune ",0,0,'R');
		$pdf->Cell($w4,$hriga,"",1,0,'L');
		$pdf->Cell($w10,$hriga,"Prov ",0,0,'R');
		$pdf->Cell($w5,$hriga,"",1,0,'L');
		$pdf->Cell($w9,$hriga,"CAP ",0,0,'R');
		$pdf->Cell($w6,$hriga,"",1,1,'L');

		$pdf->Ln(2);
		$pdf->Cell($w1,$hriga,"Cod. Fiscale ",0,0,'R');
		for ($x = 1; $x <= 16; $x++) {
			$pdf->Cell($w7,$hriga,"",1,0,'L');
			$pdf->Cell($wgap,$hriga,"",0,0,'L');
		}

	//TIPO DI PAGAMENTO
		$pdf->SetXY(10,193);
		$pdf->Cell(0,13,"", 1,1, 'L');

		$pdf->SetXY(10,195);
		$pdf->Cell($w1,$hriga,"Tipo di Pagamento ",0,0,'R');
		$pdf->Cell(65,7,"ricorrente".$pdf->Image($imgsquarecrossed,$pdf->GetX()+45, $pdf->GetY()+1,5),1,0,"C");
		// $pdf->Cell(25,7,"",0,0,"C");
		// $pdf->Cell(65,7,"singolo addebito".$pdf->Image($imgsquare,$pdf->GetX()+45, $pdf->GetY()+1,5),1,0,"C");

	//INVIARE MODULO

		// $pdf->SetFont('TitilliumWeb-SemiBold','',11);
		// $pdf->SetXY(10,210);
		// $testo= "Inviare il modulo compilato e firmato a : ".$emailamministrazionescuola."consegnando poi l'originale alla segreteria della scuola ";
		// $pdf->MultiCell(0,5,utf8_decode($testo),0,'L');

			
	//FIRMA
		$pdf->Ln(40);
		$pdf->SetFont($fontdefault,'',10);
		$pdf->Cell(60,5,"Firma",0,0,'C');
		$pdf->Cell(5,5,"",0,0,'C');
		$pdf->Cell(60,5,"",0,0,'C');
		$pdf->Cell(5,5,"",0,0,'C');
		$pdf->Cell(60,5,"Data e luogo",0,1,'C');

		$pdf->Ln(4);
		$pdf->SetFont($fontdefault,'',8);
		$pdf->Cell(60,5,"","B",0,'C');
		$pdf->Cell(5,5,"","",0,'C');
		$pdf->Cell(60,5,"",0,0,'C');
		$pdf->Cell(5,5,"","",0,'C');
		$pdf->Cell(60,5,"","B",0,'C');
		$pdf->Image('../assets/img/Icone/frecciafirmablack.png', 10, $pdf->GetY()-18, 20);
	}

}
$pdf->Output();
?>
