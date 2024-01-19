<?
include_once("../database/databaseBii.php");
$annoiscrizioni = $_SESSION['anno_iscrizioni'];
$ISC_include_SDD = $_SESSION['ISC_include_SDD'];
include_once("diciture.php");
include_once("settings_fpdf_Classi.php");
include_once("settings_fpdf_Base.php");
//$annoscolastico = $_SESSION['anno_iscrizioni'];

$ID_fam = 1000;


$imgsquare = '../assets/img/square.png';
$imgsquaremini = '../assets/img/squaremini.png';
$imgsquarecrossed = '../assets/img/squarecrossed.png';
$imgsquarecrossedmini = '../assets/img/squarecrossedmini.png';



$pdf->AddPage();
$pdf->SetFont('TitilliumWeb-SemiBold','',18);
$pdf->Cell(0,10,"DOMANDA DI ISCRIZIONE", 0,1, 'C');
$pdf->SetFont($fontdefault,'',14);
$pdf->Cell(0,10,"alla ".$nomecittascuola, 0,1, 'C');
$pdf->SetFont($fontdefault,'',14);
$pdf->Cell(0,5,"Anno Scolastico ...................", 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);
$pdf->Cell(0,15,"I sottoscritti", 0,1, 'L');
$pdf->SetFont($fontdefault,'',10);



//#region DATI PADRE**********************************************************************************************************

	$pdf->SetFont('TitilliumWeb-SemiBold','',12);
	$pdf->Cell(95,7,"DATI ANAGRAFICI DEL PADRE o TUTORE",1,0,'L');

	$pdf->SetFont($fontdefault,'',12);

	$pdf->Cell(95,7,"Socio della ".$formagiuridica."     si ".$pdf->Image($imgsquare,$pdf->GetX()+52, $pdf->GetY()+1,5)."         no".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),1,1,'L');



	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Cognome",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Nome",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Luogo di nascita",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Data di nascita",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);


	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Paese di nascita",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Codice Fiscale",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Residenza",'LTR',0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(40,7,"",'LBR',0,'L');
	$pdf->Cell(30,7,"",1,0,'L');
	$pdf->Cell(90,7,"",1,0,'L');
	$pdf->Cell(30,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Recapiti telefonici",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(75,7,"",1,0,'L');
	$pdf->Cell(75,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Indirizzo e-mail",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Titolo di Studio",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Professione",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->Cell(0,10,"", 0,1, 'L');
//#endregion

//#region DATI MADRE**********************************************************************************************************
	$pdf->SetFont('TitilliumWeb-SemiBold','',12);
	$pdf->Cell(95,7,"DATI ANAGRAFICI DELLA MADRE o TUTORE",1,0,'L');

	$pdf->SetFont($fontdefault,'',12);

	$pdf->Cell(95,7,"Socia della ".$formagiuridica."     si ".$pdf->Image($imgsquare,$pdf->GetX()+52, $pdf->GetY()+1,5)."         no".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),1,1,'L');


	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Cognome",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Nome",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Luogo di nascita",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Data di nascita",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);

	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Paese di nascita",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Codice Fiscale",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Residenza",'LTR',0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(40,7,"",'LBR',0,'L');
	$pdf->Cell(30,7,"",1,0,'L');
	$pdf->Cell(90,7,"",1,0,'L');
	$pdf->Cell(30,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Recapiti telefonici",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(75,7,"",1,0,'L');
	$pdf->Cell(75,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Indirizzo e-mail",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Titolo di Studio",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');

	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(40,7,"Professione",1,0,'L');
	$pdf->SetFont($fontdefault,'',14);
	$pdf->Cell(150,7,"",1,1,'L');
//#endregion

//#region PAGINA/E ALUNNI*****************************************************************************************************


	for ($nn = 0; $nn <= 1; $nn++) {
		if (!($nn & 1)) {$pdf->AddPage();}
		
		$pdf->SetFont('TitilliumWeb-SemiBold','',16);
		$pdf->Cell(0,10,"CHIEDONO L'ISCRIZIONE PER L'ANNO SCOLASTICO .............", 0,1, 'C');
		$pdf->SetFont($fontdefault,'',14);
		
		$frase ="del... propri... figli...";
		$pdf->Cell(0,10,$frase, 0,1, 'C');
		
		$w1 = 45;
		$w2 = 145;
		$w3 = 85;
		$w4 = 30;
		$h1 = 7;

		$pdf->SetFont($fontdefault,'',12);
		$pdf->Cell($w1,$h1,"Cognome",1,0,'L');
		$pdf->SetFont($fontdefault,'',14);
		$pdf->Cell($w2,$h1,"",1,1,'L');
		
		$pdf->SetFont($fontdefault,'',12);
		$pdf->Cell($w1,$h1,"Nome",1,0,'L');
		$pdf->SetFont($fontdefault,'',14);
		$pdf->Cell($w2,$h1,"",1,1,'L');
		
		$pdf->SetFont($fontdefault,'',12);
		$pdf->Cell($w1,$h1,"Luogo di nascita",1,0,'L');
		$pdf->SetFont($fontdefault,'',14);
		$pdf->Cell($w2,$h1,"",1,1,'L');
		
		$pdf->SetFont($fontdefault,'',12);
		$pdf->Cell($w1,$h1,"Data di nascita",1,0,'L');
		$pdf->SetFont($fontdefault,'',14);
		$pdf->Cell($w2,$h1,"",1,1,'L');
		
		$pdf->SetFont($fontdefault,'',12);
		$pdf->Cell($w1,$h1,"Paese di nascita",1,0,'L');
		$pdf->SetFont($fontdefault,'',14);
		$pdf->Cell($w2-$w3,$h1,'',1,0,'L');
		$pdf->SetFont($fontdefault,'',12);
		$pdf->Cell($w4,$h1,"Cittadinanza",1,0,'L');
		$pdf->SetFont($fontdefault,'',14);
		$pdf->Cell($w3-$w4,$h1,'',1,1,'L');
		
		$pdf->SetFont($fontdefault,'',12);
		$pdf->Cell($w1,$h1,"Codice Fiscale",1,0,'L');
		$pdf->SetFont($fontdefault,'',14);
		$pdf->Cell($w2,$h1,"",1,1,'L');
		
		$pdf->SetFont($fontdefault,'',12);
		$pdf->Cell($w1,$h1,"Residenza",'LTR',0,'L');
		$pdf->SetFont($fontdefault,'',14);
		$pdf->Cell($w2,$h1,"",1,1,'L');
		
		$pdf->SetFont($fontdefault,'',14);
		$pdf->Cell($w1,$h1,"",'LBR',0,'L');
		$pdf->Cell(30,$h1,"",1,0,'L');
		$pdf->Cell(90,$h1,"",1,0,'L');
		$pdf->Cell(25,$h1,"",1,1,'L');
		
		$pdf->SetFont($fontdefault,'',12);
		$pdf->Cell($w1,$h1,"Scuola di Provenienza",1,0,'L');
		$pdf->SetFont($fontdefault,'',14);
		$pdf->Cell($w2,$h1,"",1,1,'L');
		
		$pdf->SetFont($fontdefault,'',12);
		$pdf->Cell($w1,$h1,"Indirizzo Scuola",1,0,'L');
		$pdf->SetFont($fontdefault,'',14);
		$pdf->Cell($w2,$h1,"",1,1,'L');
		
		$pdf->SetFont($fontdefault,'',12);


			$disabilita = $pdf->Image($imgsquare,$pdf->GetX()+2, $pdf->GetY()+1,5)."        alunno/a con disabilita'";

		$pdf->Cell(95,$h1,"",1,0,'L');


			$DSA = $pdf->Image($imgsquare,$pdf->GetX()+2, $pdf->GetY()+1,5)."        alunno/a con DSA";
		
		$pdf->Cell(95,$h1,"",1,1,'L');

		$pdf->SetFont('TitilliumWeb-SemiBold','',14);
		$pdf->Cell(0,8,"alla .............",0,1,'C');
		$pdf->SetFont($fontdefault,'',12);
		$pdf->Cell(0,8,"(indicare se SCUOLA MATERNA o a quale classe)",0,1,'C');

		
		if (!($nn & 1)) {$pdf->Cell(0,10,"","T",1,'C');}
	}
//#endregion

//#region PRE-CONTRATTO - parte comune ***************************************************************************************
	$Nfiglio = array("1"=>"Prim", "2"=>"Second", "3"=>"Terz", "4"=>"Quart", "5"=>"Quint");
	$MF = array("M"=>"o figlio", "F"=>"a figlia");
	$classi = array("ASILO"=>"MATERNA", "I"=>"PRIMA ELEMENTARE", "II"=>"SECONDA ELEMENTARE", "III"=>"TERZA ELEMENTARE", "IV"=>"QUARTA ELEMENTARE", "V"=>"QUINTA ELEMENTARE", "VI"=>"PRIMA MEDIA (VI)", "VII"=>"SECONDA MEDIA (VII)", "VIII"=>"TERZA MEDIA (VIII)", "NIDO"=>"ASILO NIDO");
//#endregion

//#region PAGINE CONTRATTO PADOVA ********************************************************************************************

	if ($codscuola =='PD') {

		$pdf->AddPage();
		$pdf->SetFont('TitilliumWeb-SemiBold','',16);
		$pdf->Cell(0,10,"CONTRATTO DI PRESTAZIONE SCOLASTICA", 0,1, 'C');
		$pdf->SetFont($fontdefault,'',11);
		$pdf->Ln(5);

		$testo="Con la presente scrittura privata, tra le parti:";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
		$pdf->Ln(2);


		$testo="- <b>Società Cooperativa Steiner Waldorf Padova</b>, con sede in Padova, via Retrone 20, qui di seguito per brevità 'Ente Gestore' e";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
		$pdf->Ln(5);


		$pdf->Ln(2);

		$testo="- Il Sig. .......................................................................................... codice fiscale .................................................... nato il ..... /..... /........ a .................................................................................................... residente a ............................................................................................... via/piazza ....................................................................................";

		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
		$pdf->Ln(7);

		$testo="e la Sig.ra .................................................................................... codice fiscale .................................................... nata il ..... /..... /........ a .................................................................................................... residente a ............................................................................................... via/piazza ....................................................................................";

		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
		$pdf->Ln(7);

		$testo= "genitori/esercenti la responsabilita' genitoriale di:................................................................................................................................";
		$pdf->WriteHTML($testo);
		$pdf->Ln(5);



		$pdf->SetFont('TitilliumWeb-SemiBold','',12);
		$pdf->Cell(0,8,"PREMESSO CHE", 0,1, 'C');
		$pdf->SetFont($fontdefault,'',11);
		$pdf->Ln(4);
		

		$testo="-	L'Ente Gestore gestisce una istituzione scolastica pubblica non statale paritaria per materna e primaria, non paritaria per secondaria di primo grado;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
		$pdf->Ln(4);

		$testo="-	il suddetto Ente Gestore si finanzia in massima parte con contributi e donazioni delle famiglie; la puntualità e regolarità nei pagamenti sono necessari per la copertura delle spese del personale e per il buon funzionamento della Scuola;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
		$pdf->Ln(4);

		$testo="-	nell'economia dell'Ente Gestore la solidarietà della comunità scolastica rappresenta un presupposto irrinunciabile;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
		$pdf->Ln(4);

		$testo="-	si è presa visione e si condividono i principi che regolano il Percorso pedagogico (<a href='downloadAllegato.php?nomeallegato=A'>Allegato A</a>) ed il ".$POF_PTOF_PSD." e PEI della scuola (disponibili in segreteria o scaricabili dal sito www.waldorfpadova.it);<br>";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
		$pdf->Ln(4);



		$testo="-	si è presa visione e si condivide il Regolamento Interno (<a href='downloadAllegato.php?nomeallegato=B_".$codscuola."'>Allegato B</a>);<br>";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
		$pdf->Ln(4);

		$testo="-	si è presa visione e si condivide il Regolamento Pediatrico (<a href='downloadAllegato.php?nomeallegato=C_PD'>Allegato C</a>);<br>";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
		$pdf->Ln(4);

		$testo="-	l'ammissione alla Scuola è subordinata al parere del Collegio degli Insegnanti e del Consiglio di Amministrazione;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
		$pdf->Ln(4);

		$testo="-	si dichiara di aver presentato domanda di iscrizione per l'anno scolastico ".$annoiscrizioni." obbligandosi, in caso di accettazione della medesima domanda da parte dell'Ente Gestore, a sottoscrivere il presente contratto di prestazione scolastica;
		";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

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

		$testo="art.3)	I genitori/tutori/esercenti la responsabilità genitoriale sono consapevoli delle conseguenze amministrative per chi rilasci dichiarazioni non corrispondenti a verità, ai sensi del D.P.R. 445/2000, anche in osservanza delle disposizioni sulla responsabilità genitoriale di cui agli artt. 316, 337 ter e 337 quater del codice civile che richiedono il consenso di entrambi i genitori;";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		//-------

		$pdf->AddPage();

		$testo= "art.4)	I genitori/tutori/esercenti la responsabilità genitoriale si obbligano in solido a corrispondere all'Ente Gestore per l'anno scolastico ".$annoiscrizioni.", una quota annua a titolo di  CONTRIBUTO SCOLASTICO MINIMO così definito (vedi <a href='downloadAllegato.php?nomeallegato=D_".$codscuola."'>Allegato D</a>):
		";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);




		$pdf->Ln(10);
		$pdf->SetFont($fontdefault,'',11);

									


		// $sql = "SELECT ID_alu, mf_alu, nome_alu, cognome_alu, classe_cla, quotapromessa_alu, quotaconcordata_alu, ratepromesse_fam, quotacontraggiuntivo_fam, ratecontraggiuntivo_fam, intestazionefatt_fam, modalitapag_fam FROM (tab_anagraficaalunni JOIN tab_classialunni ON ID_alu = ID_alu_cla) JOIN tab_famiglie ON ID_fam_alu = ID_fam WHERE ID_fam_alu= ? AND noniscritto_alu = 0 ORDER BY datanascita_alu ASC";
		// $stmt = mysqli_prepare($mysqli, $sql);
		// mysqli_stmt_bind_param($stmt, "i", $ID_fam);
		// mysqli_stmt_execute($stmt);
		// mysqli_stmt_bind_result($stmt, $ID_alu, $mf_alu, $nome_alu, $cognome_alu, $classe_cla, $quotapromessa_alu, $quotaconcordata_alu, $ratepromesse_fam, $quotacontraggiuntivo_fam, $ratecontraggiuntivo_fam, $intestazionefatt_fam, $modalitapag_fam);

		$totquotapromessa = 0;
			$pdf->Cell(75,5,"NOME e COGNOME","LTR",0,'C');
			$pdf->Cell(40,5,"# figlio","LTR",0,'C');
			$pdf->Cell(45,5,"Iscrizione alla classe","LTR",0,'C');
			$pdf->Cell(30,5,"Quota annua","LTR",1,'C');
			$pdf->Cell(75,5,"","LBR",0,'L');
			$pdf->Cell(40,5,"","LBR",0,'L');
			$pdf->Cell(45,5,"","LBR",0,'L');
			$pdf->Cell(30,5,"(euro)","LBR",1,'C');
			
		for ($nn = 0; $nn <= 3; $nn++) {
			$pdf->Cell(75,8,"",1,0,'L');
			$pdf->Cell(40,8,"",1,0,'L');
			$pdf->Cell(45,8,"",1,0,'L');
			$pdf->Cell(30,8,"",1,1,'C');
		}
		$pdf->SetFont('TitilliumWeb-SemiBold','',12);
		$pdf->Cell(160,10,"Totale contributo annuo",1,0,'L');
		$pdf->Cell(30,10,"",1,1,'C');				

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

		$unicasoluzione = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+1,5)."      unica entro il .................;";
		$pdf->Cell(0,8,$unicasoluzione,0,1,'L');

		$diecirate = $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY()+1,5).utf8_decode("      DILAZIONATA entro il giorno 5 di ciascun mese in 10 mensilità (da settembre a giugno)");

		$pdf->Cell(0,8,$diecirate,0,1,'L');



		$pdf->Ln(5);

		$pdf->SetFont($fontdefault,'',11);
		$testo= "art.5)	I genitori/tutori/esercenti la responsabilità genitoriale che confermino l'iscrizione all'anno successivo si impegnano a versare la quota di iscrizione per l'anno successivo pari a euro 85 (per ciascun figlio iscritto) entro il .................; la quota di iscrizione è di euro 160 per iscrizioni oltre tale data";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
		$pdf->Ln(4);

		$testo="art.6)	I genitori/tutori/esercenti la responsabilità genitoriale si impegnano a versare a consuntivo entro il .................; l'eventuale conguaglio per le spese didattiche anticipate dalla Scuola.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
		$pdf->Ln(4);

		$frasequotacontraggiuntivo_fam = ".....................";
		$fraseratecontraggiuntivo_fam = ".....";
		$testo ="I sottoscritti intendono inoltre versare un CONTRIBUTO AGGIUNTIVO di euro  ".$frasequotacontraggiuntivo_fam." versato in ".$fraseratecontraggiuntivo_fam." rate.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
		$pdf->Ln(4);


		$testointestazione ="a : .......................................";

		$testo= "I sottoscritti chiedono che le fatture vengano intestate ".$testointestazione;
		$pdf->SetFont($fontdefault,'',11);
		$testo = utf8_decode($testo);
		$pdf->Cell(0,7,$testo,0,1,"L");

		$pdf->Ln(4);

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

		$testo="Art.9) In caso di ritiro /disdetta dell'iscrizione oltre il 30 marzo di ogni anno, l'Ente Gestore si avvale del diritto di trattenere interamente la quota di iscrizione.";
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
		$pdf->Ln(4);

		$testo="In caso di risoluzione del contratto e di ritiro dell'alunno per cause non imputabili alla scuola, prima dell'inizio dell'anno scolastico, si riconosce all'Ente Gestore la facoltà di avvalersi del diritto di non restituire nessun importo già versato alla scuola, mentre i Genitori/Tutori/esercenti la responsabilità genitoriale si obbligano a versare all'Ente Gestore le quote relative a tre mensilità.";
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
		

		//$pdf->SetXY(10,200);
		//FIRMA PADRE FIRMA MADRE DATA E LUOGO AFFIANCATI
		$pdf->Ln(8);
		$pdf->SetFont($fontdefault,'',10);
		$pdf->Cell(60,5,"Firma del padre/tutore* (leggibile)",0,0,'C');
		$pdf->Cell(5,5,"",0,0,'C');
		$pdf->Cell(60,5,"Firma della madre/tutrice* (leggibile)",0,0,'C');
		$pdf->Cell(5,5,"",0,0,'C');
		$pdf->Cell(60,5,"Data e luogo",0,1,'C');

		$pdf->SetFont($fontdefault,'',8);
		$pdf->Cell(60,5,"(* ove presente)",0,0,'C');
		$pdf->Cell(5,5,"",0,0,'C');
		$pdf->Cell(60,5,"(* ove presente)",0,1,'C');

		$pdf->Ln(4);
		$pdf->SetFont($fontdefault,'',8);
		$pdf->Cell(60,5,"","B",0,'C');
		$pdf->Cell(5,5,"","",0,'C');
		$pdf->Cell(60,5,"","B",0,'C');
		$pdf->Cell(5,5,"","",0,'C');
		$pdf->Cell(60,5,"","B",0,'C');


		$pdf->Ln(10);
		$pdf->Cell(60,5,"Per la Soc. Coop Steiner Waldorf Padova",0,1,'C');
		$pdf->Cell(60,5,"(Il rappresentante legale)",0,1,'C');
		$pdf->Ln(4);
		$pdf->Cell(60,5,"","B",1);

	}
//#endregion

//#region PAGINE CONTRATTO CITTADELLA ****************************************************************************************
	if ($codscuola =='CI') {
		$pdf->AddPage();
		$pdf->SetFont('TitilliumWeb-SemiBold','',16);
		$pdf->Cell(0,10,"IMPEGNO ECONOMICO", 0,1, 'C');
		$pdf->SetFont($fontdefault,'',11);
		$pdf->Ln(5);

		$testo= "I suindicati genitori/tutori/esercenti la responsabilità genitoriale:";
		$testo = utf8_decode($testo);
		$pdf->Cell(0,10,$testo, 0,1, 'L');
		

		$testo="- si impegnano in solido a corrispondere all'Ente Gestore per l'anno scolastico ....................., una quota annua a titolo di  CONTRIBUTO DI GESTIONE così definita (v. <a href='downloadAllegato.php?nomeallegato=D_".$codscuola."'>Allegato D</a>): ";
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
		$pdf->Ln(7);

		
		$pdf->SetFont($fontdefault,'',11);

		
		$pdf->Cell(55,8,"NOME e COGNOME","LTR",0,'C');
		$pdf->Cell(30,8,"# figlio","LTR",0,'C');
		$pdf->Cell(40,8,"Iscrizione alla classe","LTR",0,'C');
		$pdf->Cell(30,8,"Tipo di Quota","LTR",0,'C');
		$pdf->Cell(35,8,"Quota annua euro","LTR",1,'C');

		// $pdf->Cell(55,5,"","LBR",0,'L');
		// $pdf->Cell(30,5,"","LBR",0,'L');
		// $pdf->Cell(40,5,"","LBR",0,'L');
		// $pdf->Cell(30,5,"","LBR",0,'C');
		// $pdf->Cell(35,5,"(euro)","LBR",1,'C');
			
			
		for ($nn = 0; $nn <= 3; $nn++) {
			$n++;
			$pdf->Cell(55,8,"",1,0,'L');
			$pdf->Cell(30,8,"",1,0,'L');
			$pdf->Cell(40,8,"",1,0,'L');
			$pdf->Cell(30,8,"",1,0,'C');
			$pdf->Cell(35,8,"",1,1,'C');
		}
		$pdf->SetFont('TitilliumWeb-SemiBold','',12);
		$pdf->Cell(155,10,"Totale annuo contributo di gestione",1,0,'L');
		$pdf->Cell(35,10,"",1,1,'C');

		$pdf->Ln(2);
		

		$testo= "- tale quota verrà versata in .......rate secondo le scadenze sotto indicate";
		$pdf->SetFont($fontdefault,'',11);
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
		$pdf->Ln(6);
		$pdf->Cell(0,15,"",1,1,'C');
		$pdf->Ln(2);
		
		
		
		$testo= "- si impegnano al versamento della quota di iscrizione pari ad euro 100 per alunno entro il 22/01/2021 o al momento dell'iscrizione.";
		$pdf->SetFont($fontdefault,'',11);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->Ln(2);

		$testo= "Scelgono di:";
		$pdf->SetFont($fontdefault,'',10);
		$testo = utf8_decode($testo);
		$pdf->Cell(0,7,$testo,"T",1,"C");
		$pdf->SetFont($fontdefault,'',9);
		$pdf->Cell(60,7,"svolgere le pulizie".$pdf->Image($imgsquare,$pdf->GetX()+45, $pdf->GetY()+1,5),"B",0,"C");
		$pdf->Cell(130,7,"non svolgere le pulizie e versare la somma di euro ......................".$pdf->Image($imgsquare,$pdf->GetX()+110, $pdf->GetY()+1,5),"B",0,"C"); 
		
		
		$pdf->Ln(9);

		$testo= $pdf->Image($imgsquare,$pdf->GetX(), $pdf->GetY(),5)."      chiedono un colloquio per accedere al 'Fondo di Solidarietà per le Famiglie'.";
		$pdf->SetFont($fontdefault,'',11);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);
		

		$pdf->Ln(4);
		$testo= "Solo per la prima iscrizione alla scuola Aurora: versano la cauzione per alunno nuovo iscritto di euro 300";
		$pdf->SetFont($fontdefault,'',10);
		$testo = utf8_decode($testo);
		$pdf->Cell(0,7,$testo,"T",1,"C");
		$pdf->SetFont($fontdefault,'',9);
		$pdf->Cell(60,7,"in soluzione unica".$pdf->Image($imgsquare,$pdf->GetX()+45, $pdf->GetY()+1,5),"B",0,"C");
		$pdf->Cell(130,7,"in 3 rate (1/3 all'iscrizione-1/3 settembre-saldo ottobre 2021)".$pdf->Image($imgsquare,$pdf->GetX()+110, $pdf->GetY()+1,5),"B",0,"C"); 
		
		$pdf->Ln(12);

		// $testo= "- chiedono che le fatture vengano intestate ".$testointestazione;
		// $pdf->SetFont($fontdefault,'',11);
		// $testo = utf8_decode($testo);
		// $pdf->Cell(0,7,$testo,"T",1,"L");

		$testo= "- chiedono che le fatture vengano intestate a  ...................................................................";
		$pdf->SetFont($fontdefault,'',11);
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
		$pdf->Ln(7);
		
		$testo= "- scelgono di pagare secondo la seguente modalità .........................................................";
		$pdf->SetFont($fontdefault,'',11);
		$testo = utf8_decode($testo);
		$pdf->WriteHTML($testo);
		$pdf->Ln(7);

		$testo= "I sottoscritti dichiarano di essere consapevoli che la scuola può utilizzare i dati contenuti nel presente modulo di iscrizione esclusivamente nell'ambito e per i fini istituzionali propri della Pubblica Amministrazione.";
		$pdf->SetFont($fontdefault,'',11);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,5,$testo);

		$pdf->SetXY(10,220);
		//FIRMA PADRE FIRMA MADRE DATA E LUOGO AFFIANCATI
		$pdf->Ln(8);
		$pdf->SetFont($fontdefault,'',10);
		$pdf->Cell(60,5,"Firma del padre/tutore* (leggibile)",0,0,'C');
		$pdf->Cell(5,5,"",0,0,'C');
		$pdf->Cell(60,5,"Firma della madre/tutrice* (leggibile)",0,0,'C');
		$pdf->Cell(5,5,"",0,0,'C');
		$pdf->Cell(60,5,"Data e luogo",0,1,'C');

		$pdf->SetFont($fontdefault,'',8);
		$pdf->Cell(60,5,"(* ove presente)",0,0,'C');
		$pdf->Cell(5,5,"",0,0,'C');
		$pdf->Cell(60,5,"(* ove presente)",0,1,'C');

		$pdf->Ln(4);
		$pdf->SetFont($fontdefault,'',8);
		$pdf->Cell(60,5,"","B",0,'C');
		$pdf->Cell(5,5,"","",0,'C');
		$pdf->Cell(60,5,"","B",0,'C');
		$pdf->Cell(5,5,"","",0,'C');
		$pdf->Cell(60,5,"","B",0,'C');




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
//#endregion

//#region PAGINA PRINCIPI CHE REGOLANO ***************************************************************************************

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
		$pdf->SetFont($fontdefault,'',10);
		$pdf->Cell(60,5,"Firma del padre/tutore* (leggibile)",0,0,'C');
		$pdf->Cell(5,5,"",0,0,'C');
		$pdf->Cell(60,5,"Firma della madre/tutrice* (leggibile)",0,0,'C');
		$pdf->Cell(5,5,"",0,0,'C');
		$pdf->Cell(60,5,"Data e luogo",0,1,'C');

		$pdf->SetFont($fontdefault,'',8);
		$pdf->Cell(60,5,"(* ove presente)",0,0,'C');
		$pdf->Cell(5,5,"",0,0,'C');
		$pdf->Cell(60,5,"(* ove presente)",0,1,'C');

		$pdf->Ln(4);
		$pdf->SetFont($fontdefault,'',8);
		$pdf->Cell(60,5,"","B",0,'C');
		$pdf->Cell(5,5,"","",0,'C');
		$pdf->Cell(60,5,"","B",0,'C');
		$pdf->Cell(5,5,"","",0,'C');
		$pdf->Cell(60,5,"","B",0,'C');
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

		$testo= "1. Il contributo di gestione (retta annuale) rappresenta un impegno responsabile verso le necessità della scuola. Il suo ammontare annuale definito per alunno, viene determinato in fase di bilancio preventivo e successivamente confermato entro l'inizio effettivo dell'anno scolastico dal consiglio di amministrazione responsabile della gestione economica. La famiglia è invitata a scegliere consapevolmente la retta che può sostenere, tra la retta COMPLETA, RIDOTTA, MINIMA o MINIMA CON PIU' FIGLI. Il sostegno, non solo economico, della scuola da parte dei genitori è dato dal versamento della retta ma anche e soprattutto dalla partecipazione attiva alle varie iniziative e all'organizzazione della scuola.";
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

		$testo= "4. Chi lascia la scuola durante l'anno scolastico è tenuto a versare il contributo economico fino alla fine dell'anno in corso compreso di eventuale integrazione.";
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

		$testo= "7. Al 31 Agosto 2021 si riterranno valide le conferme annuali d'iscrizione alla classe successiva, solo se saranno stati eseguiti integralmente: il pagamento del contributo di gestione dovuto per l'anno in corso 2020/21, il saldo delle spese del materiale, il saldo di eventuali contributi straordinari per il pareggio di bilancio.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo);
		$pdf->Ln($dopoparagrafo);

		$testo= "8. Entro il 21 gennaio 2021 deve essere versata la quota d'iscrizione facendo pervenire in segreteria il ''Modulo di Iscrizione - Impegno Finanziario'', debitamente compilato e firmato.";
		$pdf->SetFont($fontdefault,'',$fontsizedefault);
		$testo = utf8_decode($testo);
		$pdf->MultiCell(0,$interlinea,$testo);
		$pdf->Ln($dopoparagrafo);

		$testo= "9. Entro il 30/09 dovrà essere versata la quota associativa (euro 10 a socio)";
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
//#endregion


//#region PAGINA DICHIARAZIONI ************************************************************************************************


	$pdf->AddPage();
	$pdf->SetFont('TitilliumWeb-SemiBold','',16);
	$pdf->Cell(0,10,"DICHIARAZIONI", 0,1, 'C');
	$pdf->SetFont($fontdefault,'',11);
	$pdf->Ln(4);
	$testo="Premesso che lo Stato assicura l'insegnamento della religione cattolica nelle scuole di ogni ordine e grado in conformità all'accordo che apporta modifiche al Concordato Lateranense (art. 9.2), il presente modulo costituisce richiesta dell'autorità scolastica in ordine all'esercizio del diritto di scegliere se avvalersi o non avvalersi dell'insegnamento della religione cattolica. I sottoscritti prendono atto che il ".$POF_PTOF_PSDext.", accettato all'atto della presente iscrizione, attualmente non prevede l'insegnamento specifico della religione intesa come materia curriculare che viene perciò sostituita da attività didattiche formative.";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);
	$pdf->Ln(2);

	$pdf->SetFont($fontdefault,'',11);
	$testo="Al fine dell'ammissione del/i proprio/i figlio/i i genitori dichiarano:";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);
	$pdf->Ln(2);

	$testo="-	l'intenzione di non avvalersi per il/i proprio/i figlio/i dell'insegnamento della religione cattolica";
	$testo = utf8_decode($testo);
	$pdf->WriteHTML($testo);
	$pdf->Ln(6);


	$testo="-	che nel caso il/i proprio/i figlio/i fosse(ro) affetto/i da allergie, intolleranze o patologie che richiedano diete speciali daranno tempestiva comunicazione alla segreteria della Scuola tramite la compilazione del <a href='downloadAllegato.php?nomeallegato=E'>MODULO DI RICHIESTA DIETE SPECIALI</a>  (corredato da certificato medico specialistico)";
	$testo = utf8_decode($testo);
	$pdf->WriteHTML($testo);
	$pdf->Ln(6);

	$testo="-	che si impegnano a comunicare qualsiasi variazione riguardante i propri dati anagrafici entro e non oltre 30 giorni dalla variazione";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);
	$pdf->Ln(2);

	$testo="-	che il nucleo familiare è così composto";
	$testo = utf8_decode($testo);
	$pdf->MultiCell(0,5,$testo);

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
	$pdf->Row(array("1", "", "", "", "padre"));
	$pdf->Row(array("2", "", "", "", "madre"));



	for ($nn = 0; $nn <= 3; $nn++) {
		$pdf->Row(array("", "", "", "", ""));
	}



	$pdf->SetXY(10,230);
	//FIRMA PADRE FIRMA MADRE E LEGALE RAPPRESENTANTE AFFIANCATI
	$pdf->Ln(8);
	include("firmepadremadreluogo.php");
//#endregion


//#region PAGINA CONSENSI ****************************************************************************************************


	//a rigore non è corretto: ci vorrebbero n moduli, uno per ogni figlio: per la privacy li mettiamo insieme perchè tanto i consensi sono tutti obbligatori, ma per gli altri consensi non si può, in quanto potrebbero essere stati forniti consensi diversi a seconda del figlio



	$pdf->AddPage();
	$pdf->SetFont('TitilliumWeb-SemiBold','',16);
	if ($nn ==1) {
		$pdf->Cell(0,8,utf8_decode("DICHIARAZIONE DI RESPONSABILITA' GENITORIALE SUL MINORE"), 0,1, 'C');
	} else {
		$pdf->Cell(0,8,utf8_decode("DICHIARAZIONE DI RESPONSABILITA' GENITORIALE SUI MINORI"), 0,1, 'C');
	}
	$pdf->SetFont($fontdefault,'',12);
	$pdf->Cell(0,8,"..................................................................................................", 0,1, 'C');

	$testo4="Con la presente dichiariamo di aver acquisito le informazioni fornite dal titolare del trattamento e compreso e condiviso il significato di quanto sopra indicato, facendo salvo il rinvio a tutta la normativa vigente e applicabile alla materia, consapevoli che i servizi da noi richiesti, ovvero richiesti da nostro/a figlio/a, ricadono nell'ambito della società dell'informazione e pertanto secondo la norma (art. 8 Regolamento UE 2016/679) è necessario che il consenso sia prestato o autorizzato dai titolari della responsabilità genitoriale sul minore (DPR 28/2/2000 N. 445 Art. 46 punto ''u'').";

	$pdf->Ln(1);
	$pdf->SetFont($fontdefault,'',10);
	$testo4 = utf8_decode($testo4);
	$pdf->MultiCell(0,5,$testo4);
	$pdf->Ln(3);

	$pdf->SetFont('TitilliumWeb-SemiBold','',11);
	$pdf->Cell(0,10,utf8_decode("Dichiaro di essere titolare della responsabilità genitoriale "), 0,1, 'C');
	//FIRMA PADRE FIRMA MADRE E DATA E LUOGO AFFIANCATI
	$pdf->Ln(3);
	$pdf->SetFont($fontdefault,'',10);
	$pdf->Cell(60,5,"Firma del padre/tutore* (leggibile)",0,0,'C');
	$pdf->Cell(5,5,"",0,0,'C');
	$pdf->Cell(60,5,"Firma della madre/tutrice* (leggibile)",0,0,'C');
	$pdf->Cell(5,5,"",0,0,'C');
	$pdf->Cell(60,5,"Data e luogo",0,1,'C');

	$pdf->SetFont($fontdefault,'',8);
	$pdf->Cell(60,5,"(* ove presente)",0,0,'C');
	$pdf->Cell(5,5,"",0,0,'C');
	$pdf->Cell(60,5,"(* ove presente)",0,0,'C');
	$pdf->Cell(5,5,"",0,0,'C');
	$pdf->Cell(60,5,"",0,1,'C');

	$pdf->Ln(4);
	$pdf->SetFont($fontdefault,'',8);
	$pdf->Cell(60,5,"","B",0,'C');
	$pdf->Cell(5,5,"","",0,'C');
	$pdf->Cell(60,5,"","B",0,'C');
	$pdf->Cell(5,5,"","",0,'C');
	$pdf->Cell(60,5,"","B",0,'C');


	$pdf->SetFont('TitilliumWeb-SemiBold','',16);
	$pdf->Ln(20);
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

		$pdf->Cell(95,7,"Presto il consenso".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
		$pdf->Cell(95,7,"Nego il consenso".$pdf->Image($imgsquare,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 

	$pdf->Ln(8);
	$pdf->Cell(0,5,utf8_decode("al trattamento dei dati personali al fine di permettere di gestire le attività di istruzione"),0,1,"C");
	$pdf->Cell(0,5,utf8_decode("educative e formative stabilite dal ".$POF_PTOF_PSDext),0,1,"C");


				//FIRMA PADRE FIRMA MADRE E DATA E LUOGO AFFIANCATI
				$pdf->Ln(3);
				$pdf->SetFont($fontdefault,'',10);
				$pdf->Cell(60,5,"Firma del padre/tutore* (leggibile)",0,0,'C');
				$pdf->Cell(5,5,"",0,0,'C');
				$pdf->Cell(60,5,"Firma della madre/tutrice* (leggibile)",0,0,'C');
				$pdf->Cell(5,5,"",0,0,'C');
				$pdf->Cell(60,5,"Data e luogo",0,1,'C');

				$pdf->SetFont($fontdefault,'',8);
				$pdf->Cell(60,5,"(* ove presente)",0,0,'C');
				$pdf->Cell(5,5,"",0,0,'C');
				$pdf->Cell(60,5,"(* ove presente)",0,0,'C');
				$pdf->Cell(5,5,"",0,0,'C');
				$pdf->Cell(60,5,"",0,1,'C');

				$pdf->Ln(4);
				$pdf->SetFont($fontdefault,'',8);
				$pdf->Cell(60,5,"","B",0,'C');
				$pdf->Cell(5,5,"","",0,'C');
				$pdf->Cell(60,5,"","B",0,'C');
				$pdf->Cell(5,5,"","",0,'C');
				$pdf->Cell(60,5,"","B",0,'C');
	$pdf->Ln(8);
	//Tratteggio di separazione
	$pdf->SetDash(1,1); //5mm on, 5mm off;
	$pdf->Cell(190,1,"" , "B" ,0, 'L');
	$pdf->SetDash(); //Restore dash
	$pdf->SetDrawColor(0,0,0);
	$pdf->Ln(5);

	//privacy2 ****************************************************************************************************************************************
	$pdf->SetFont($fontdefault,'',11);

		$pdf->Cell(95,7,"Presto il consenso".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
		$pdf->Cell(95,7,"Nego il consenso".$pdf->Image($imgsquare,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 

	$pdf->Ln(8);
	$pdf->Cell(0,5,utf8_decode("al trattamento dei dati identificativi degli orientamenti religiosi, politici e relativi alla salute"),0,1,"C");
	$pdf->Cell(0,5,utf8_decode("al solo fine di permettere di gestire le attività di istruzione, educative e formative stabilite dal ". $POF_PTOF_PSD),0,1,"C");

				//FIRMA PADRE FIRMA MADRE E DATA E LUOGO AFFIANCATI
				$pdf->Ln(3);
				$pdf->SetFont($fontdefault,'',10);
				$pdf->Cell(60,5,"Firma del padre/tutore* (leggibile)",0,0,'C');
				$pdf->Cell(5,5,"",0,0,'C');
				$pdf->Cell(60,5,"Firma della madre/tutrice* (leggibile)",0,0,'C');
				$pdf->Cell(5,5,"",0,0,'C');
				$pdf->Cell(60,5,"Data e luogo",0,1,'C');

				$pdf->SetFont($fontdefault,'',8);
				$pdf->Cell(60,5,"(* ove presente)",0,0,'C');
				$pdf->Cell(5,5,"",0,0,'C');
				$pdf->Cell(60,5,"(* ove presente)",0,0,'C');
				$pdf->Cell(5,5,"",0,0,'C');
				$pdf->Cell(60,5,"",0,1,'C');

				$pdf->Ln(4);
				$pdf->SetFont($fontdefault,'',8);
				$pdf->Cell(60,5,"","B",0,'C');
				$pdf->Cell(5,5,"","",0,'C');
				$pdf->Cell(60,5,"","B",0,'C');
				$pdf->Cell(5,5,"","",0,'C');
				$pdf->Cell(60,5,"","B",0,'C');
	$pdf->Ln(8);
	//Tratteggio di separazione
	$pdf->SetDash(1,1); //5mm on, 5mm off;
	$pdf->Cell(190,1,"" , "B" ,0, 'L');
	$pdf->SetDash(); //Restore dash
	$pdf->SetDrawColor(0,0,0);
	$pdf->Ln(5);

	//privacy3 ****************************************************************************************************************************************
	$pdf->SetFont($fontdefault,'',11);
		$pdf->Cell(95,7,"Presto il consenso".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
		$pdf->Cell(95,7,"Nego il consenso".$pdf->Image($imgsquare,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 

	$pdf->Ln(8);
	$pdf->Cell(0,5,utf8_decode("per l'invio di comunicazioni elettroniche anche tramite messaggi SMS, MMS ecc. "),0,1,"C");
	$pdf->Cell(0,5,utf8_decode("e/o posta elettronica E-MAIL ai recapiti da me forniti per finalità informative"),0,1,"C");

	//

				//FIRMA PADRE FIRMA MADRE E DATA E LUOGO AFFIANCATI
				$pdf->Ln(3);
				$pdf->SetFont($fontdefault,'',10);
				$pdf->Cell(60,5,"Firma del padre/tutore* (leggibile)",0,0,'C');
				$pdf->Cell(5,5,"",0,0,'C');
				$pdf->Cell(60,5,"Firma della madre/tutrice* (leggibile)",0,0,'C');
				$pdf->Cell(5,5,"",0,0,'C');
				$pdf->Cell(60,5,"Data e luogo",0,1,'C');

				$pdf->SetFont($fontdefault,'',8);
				$pdf->Cell(60,5,"(* ove presente)",0,0,'C');
				$pdf->Cell(5,5,"",0,0,'C');
				$pdf->Cell(60,5,"(* ove presente)",0,0,'C');
				$pdf->Cell(5,5,"",0,0,'C');
				$pdf->Cell(60,5,"",0,1,'C');

				$pdf->Ln(4);
				$pdf->SetFont($fontdefault,'',8);
				$pdf->Cell(60,5,"","B",0,'C');
				$pdf->Cell(5,5,"","",0,'C');
				$pdf->Cell(60,5,"","B",0,'C');
				$pdf->Cell(5,5,"","",0,'C');
				$pdf->Cell(60,5,"","B",0,'C');
//#endregion

//#region PAGINA LIBERATORIE *************************************************************************************************

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

		$pdf->Cell(95,7,"Autorizzo".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
		$pdf->Cell(95,7,"Non Autorizzo".$pdf->Image($imgsquare,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 

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
		$testo7= "Considerato che la Scuola nello svolgimento delle attività per documentare i percorsi ed i progressi svolti può trovarsi nella condizione di utilizzare elaborati di vario tipo (relazioni, disegni, temi, fotografie, filmati, registrazioni, ...) ";
		$pdf->Ln(3);
		$pdf->SetFont($fontdefault,'',9);
		$testo7 = utf8_decode($testo7);
		$pdf->MultiCell(0,5,$testo7);
		$pdf->SetFont($fontdefault,'',10);

		$pdf->Cell(95,7,"Autorizzo".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
		$pdf->Cell(95,7,"Non Autorizzo".$pdf->Image($imgsquare,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 

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

			$pdf->Cell(95,7,"Autorizzo".$pdf->Image($imgsquare,$pdf->GetX()+65, $pdf->GetY()+1,5),0,0,"C");
			$pdf->Cell(95,7,"Non Autorizzo".$pdf->Image($imgsquare,$pdf->GetX()+64, $pdf->GetY()+1,5),0,0,"C"); 

		$testo9= "le uscite didattiche sul territorio cittadino all'interno dell'orario scolastico. Tali uscite saranno man mano presentate ai genitori nell'ambito delle riunioni di classe.
		Sarà cura degli insegnanti dare avviso dell'uscita mediante brevi comunicazioni sul diario alcuni giorni prima delle visite previste.";
		$pdf->Ln(8);
		$pdf->SetFont($fontdefault,'',9);
		$testo9 = utf8_decode($testo9);
		$pdf->MultiCell(0,5,$testo9);

		$pdf->SetXY(10,230);
		//FIRMA PADRE FIRMA MADRE E DATA E LUOGO AFFIANCATI
		$pdf->Ln(8);
		$pdf->SetFont($fontdefault,'',10);
		$pdf->Cell(60,5,"Firma del padre/tutore* (leggibile)",0,0,'C');
		$pdf->Cell(5,5,"",0,0,'C');
		$pdf->Cell(60,5,"Firma della madre/tutrice* (leggibile)",0,0,'C');
		$pdf->Cell(5,5,"",0,0,'C');
		$pdf->Cell(60,5,"Data e luogo",0,1,'C');

		$pdf->SetFont($fontdefault,'',8);
		$pdf->Cell(60,5,"(* ove presente)",0,0,'C');
		$pdf->Cell(5,5,"",0,0,'C');
		$pdf->Cell(60,5,"(* ove presente)",0,0,'C');
		$pdf->Cell(5,5,"",0,0,'C');
		$pdf->Cell(60,5,"",0,1,'C');

		$pdf->Ln(4);
		$pdf->SetFont($fontdefault,'',8);
		$pdf->Cell(60,5,"","B",0,'C');
		$pdf->Cell(5,5,"","",0,'C');
		$pdf->Cell(60,5,"","B",0,'C');
		$pdf->Cell(5,5,"","",0,'C');
		$pdf->Cell(60,5,"","B",0,'C');
	fineloop:
		
	}
//#endregion

//#region PAGINA MODULO ADESIONE SOCIO ***************************************************************************************

	if ($codscuola =='PD') {


		//per il padre
		if ($sociopadre_fam == 1) {
			$pdf->AddPage();
			$pdf->SetFont('TitilliumWeb-SemiBold','',10);

			$pdf->Cell(0,7,utf8_decode("DA STAMPARE E CONSEGNARE SOLO QUALORA L'ADESIONE NON SIA STATA EFFETTUATA IN PRECEDENZA"), 1,1, 'C', True);
			$pdf->SetFont('TitilliumWeb-SemiBold','',16);
			$pdf->Cell(0,10,utf8_decode("RICHIESTA DI ADESIONE A SOCIO"), 0,1, 'C');

			$pdf->SetFont($fontdefault,'',10);
			$pdf->Cell(110,7,"",0,0);
			$pdf->Cell(25,7,"Data e Luogo ",0,0,'L');
			$pdf->Cell(45,7,"","B",1);

			$pdf->Ln(7);
			$pdf->Cell(110,5,"",0,0);
			$pdf->Cell(70,5,utf8_decode("Al Cda della Società Cooperativa"),0,1,'L');
			$pdf->Cell(110,5,"",0,0);
			$pdf->Cell(70,5,utf8_decode("Società Cooperativa"),0,1,'L');
			$pdf->Cell(110,5,"",0,0);
			$pdf->Cell(70,5,utf8_decode("Steiner Waldorf Padova"),0,1,'L');
			$pdf->Cell(110,5,"",0,0);
			$pdf->Cell(70,5,utf8_decode("Via Retrone 20, Padova"),0,1,'L');

			$pdf->SetFont($fontdefault,'',12);
			$pdf->Ln(5);
			$pdf->Cell(30,7,"Il sottoscritto ",0,0,'L');
			$pdf->Cell(100,7,strtoupper($nomepadre_fam)." ".strtoupper($cognomepadre_fam),"B",1,'C');
			$pdf->Cell(30,7,"nato a ",0,0,'L');
			$pdf->Cell(100,7,strtoupper($comunenascitapadre_fam." (".$provnascitapadre_fam.") - ".$paesenascitapadre_fam),"B",0,'C');
			$pdf->Cell(10,7," il ",0,0,'C');
			$pdf->Cell(40,7,strtoupper($datanascitapadre_fam),"B",1,'C');
			$pdf->Cell(30,7,"residente a ",0,0,'L');
			$pdf->Cell(100,7,strtoupper($comunepadre_fam." (".$provpadre_fam.") - ".$paesepadre_fam),"B",0,'C');
			$pdf->Cell(10,7," CAP ",0,0,'C');
			$pdf->Cell(40,7,strtoupper($CAPpadre_fam),"B",1,'C');
			$pdf->Cell(30,7,"in via ",0,0,'L');
			$pdf->Cell(150,7,$indirizzopadre_fam,"B",1,'C');
			$pdf->Cell(30,7,"COD FISCALE ",0,0,'L');
			$pdf->Cell(150,7,strtoupper($cfpadre_fam),"B",1,'C');
			$pdf->Cell(30,7,"Tel ",0,0,'L');
			$pdf->Cell(40,7,strtoupper($telefonopadre_fam),"B",0,'C');
			$pdf->Cell(20,7,"e-mail ",0,0,'C');
			$pdf->Cell(90,7,$emailpadre_fam,"B",1,'C');
			$pdf->SetFont('TitilliumWeb-SemiBold','',12);
			$pdf->Ln(5);
			$pdf->Cell(0,10,utf8_decode("Con la presente chiede di poter essere ammesso in qualità di:"), 0,1, 'C');
			$pdf->SetFont($fontdefault,'',11);
			$pdf->Cell(10,7,"",0,0);
			$pdf->Cell(40,7,$pdf->Image($imgsquarecrossedmini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socio Fruitore",1,0,"L");
			$pdf->Cell(40,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socio Lavoratore",1,0,"L");
			$pdf->Cell(40,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socio Volontario",1,0,"L");
			$pdf->Cell(40,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Altro",1,1,"L");
			$pdf->Ln(5);

			$testo= "alla ".$ragionesocialescuola.", sottoscrivendo n. 1 quota di capitale sociale
			per un importo di euro 25,00 da versare così come espressamente previsto dallo Statuto Sociale.";
			$pdf->MultiCell(0,5,utf8_decode($testo), 0, "C");

			$pdf->SetFont('TitilliumWeb-SemiBold','',12);
			$pdf->Cell(0,10,utf8_decode("DICHIARA:"), 0,1, 'C');
			$pdf->SetFont($fontdefault,'',10);

			$testo="di non svolgere alcuna attività in contrasto con gli scopi sociali della Cooperativa
			- di essere a conoscenza ed approvare lo Statuto della Cooperativa
			- di accettare le deliberazioni legalmente adottate dagli organismi sociali
			- di accettare le clausole arbitrali come previsto dallo Statuto
			- di aver preso visione delle informazioni di seguito riportate, relative all' 'INFORMATIVA AI SENSI E PER GLI EFFETTI DI CUI
			ALL'ARTICOLO 13, D. LGS. 30 GIUGNO 2003 N. 196' ed esprime altresì il proprio consenso al trattamento e alla comunicazione
			dei propri dati personali.";

			$pdf->MultiCell(0,5,utf8_decode($testo), 0, "L");
			$pdf->Ln(10);
			$pdf->Cell(90,5,"IL RICHIEDENTE",0,0,'L');
			$pdf->Cell(100,5,"","B",1);

			$pdf->Ln(7);
			$pdf->Cell(100,5,"Allego:",0,1,'L');
			$pdf->Cell(100,5,utf8_decode("1. Fotocopia del documento di identità valido"),0,1,'L');
			$pdf->Cell(100,5,utf8_decode("2. Fotocopia del codice fiscale"),0,0,'L');

			$pdf->Ln(15);
			$pdf->Cell(90,5,"Per la Soc. Coop Steiner Waldorf Padova",0,1,'L');
			$pdf->Cell(90,5,"Firma rappresentante del CDA",0,0,'L');
			$pdf->Cell(100,5,"","B",1);

		}


		//per la madre
		if ($sociomadre_fam == 1) {
			$pdf->AddPage();
			$pdf->SetFont('TitilliumWeb-SemiBold','',10);

			$pdf->Cell(0,7,utf8_decode("DA STAMPARE E CONSEGNARE SOLO QUALORA L'ADESIONE NON SIA STATA EFFETTUATA IN PRECEDENZA"), 1,1, 'C', True);
			$pdf->SetFont('TitilliumWeb-SemiBold','',16);
			$pdf->Cell(0,10,utf8_decode("RICHIESTA DI ADESIONE A SOCIA"), 0,1, 'C');

			$pdf->SetFont($fontdefault,'',10);
			$pdf->Cell(110,7,"",0,0);
			$pdf->Cell(25,7,"Data e Luogo ",0,0,'L');
			$pdf->Cell(45,7,"","B",1);

			$pdf->Ln(7);
			$pdf->Cell(110,5,"",0,0);
			$pdf->Cell(70,5,utf8_decode("Al Cda della Società Cooperativa"),0,1,'L');
			$pdf->Cell(110,5,"",0,0);
			$pdf->Cell(70,5,utf8_decode("Società Cooperativa"),0,1,'L');
			$pdf->Cell(110,5,"",0,0);
			$pdf->Cell(70,5,utf8_decode("Steiner Waldorf Padova"),0,1,'L');
			$pdf->Cell(110,5,"",0,0);
			$pdf->Cell(70,5,utf8_decode("Via Retrone 20, Padova"),0,1,'L');

			$pdf->SetFont($fontdefault,'',12);
			$pdf->Ln(5);
			$pdf->Cell(30,7,"La sottoscritta ",0,0,'L');
			$pdf->Cell(100,7,strtoupper($nomemadre_fam)." ".strtoupper($cognomemadre_fam),"B",1,'C');
			$pdf->Cell(30,7,"nata a ",0,0,'L');
			$pdf->Cell(100,7,strtoupper($comunenascitamadre_fam." (".$provnascitamadre_fam.") - ".$paesenascitamadre_fam),"B",0,'C');
			$pdf->Cell(10,7," il ",0,0,'C');
			$pdf->Cell(40,7,strtoupper($datanascitamadre_fam),"B",1,'C');
			$pdf->Cell(30,7,"residente a ",0,0,'L');
			$pdf->Cell(100,7,strtoupper($comunemadre_fam." (".$provmadre_fam.") - ".$paesemadre_fam),"B",0,'C');
			$pdf->Cell(10,7," CAP ",0,0,'C');
			$pdf->Cell(40,7,strtoupper($CAPmadre_fam),"B",1,'C');
			$pdf->Cell(30,7,"in via ",0,0,'L');
			$pdf->Cell(150,7,$indirizzomadre_fam,"B",1,'C');
			$pdf->Cell(30,7,"COD FISCALE ",0,0,'L');
			$pdf->Cell(150,7,strtoupper($cfmadre_fam),"B",1,'C');
			$pdf->Cell(30,7,"Tel ",0,0,'L');
			$pdf->Cell(40,7,strtoupper($telefonomadre_fam),"B",0,'C');
			$pdf->Cell(20,7,"e-mail ",0,0,'C');
			$pdf->Cell(90,7,$emailmadre_fam,"B",1,'C');
			$pdf->SetFont('TitilliumWeb-SemiBold','',12);
			$pdf->Ln(5);
			$pdf->Cell(0,10,utf8_decode("Con la presente chiede di poter essere ammessa in qualità di:"), 0,1, 'C');
			$pdf->SetFont($fontdefault,'',11);
			$pdf->Cell(10,7,"",0,0);
			$pdf->Cell(40,7,$pdf->Image($imgsquarecrossedmini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socia Fruitrice",1,0,"L");
			$pdf->Cell(40,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socia Lavoratrice",1,0,"L");
			$pdf->Cell(40,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Socia Volontaria",1,0,"L");
			$pdf->Cell(40,7,$pdf->Image($imgsquaremini,$pdf->GetX()+3, $pdf->GetY()+1)."          Altro",1,1,"L");
			$pdf->Ln(5);

			$testo= "alla ".$ragionesocialescuola.", sottoscrivendo n. 1 quota di capitale sociale
			per un importo di euro 25,00 da versare così come espressamente previsto dallo Statuto Sociale.";
			$pdf->MultiCell(0,5,utf8_decode($testo), 0, "C");

			$pdf->SetFont('TitilliumWeb-SemiBold','',12);
			$pdf->Cell(0,10,utf8_decode("DICHIARA:"), 0,1, 'C');
			$pdf->SetFont($fontdefault,'',10);

			$testo="di non svolgere alcuna attività in contrasto con gli scopi sociali della Cooperativa
			- di essere a conoscenza ed approvare lo Statuto della Cooperativa
			- di accettare le deliberazioni legalmente adottate dagli organismi sociali
			- di accettare le clausole arbitrali come previsto dallo Statuto
			- di aver preso visione delle informazioni di seguito riportate, relative all' 'INFORMATIVA AI SENSI E PER GLI EFFETTI DI CUI
			ALL'ARTICOLO 13, D. LGS. 30 GIUGNO 2003 N. 196' ed esprime altresì il proprio consenso al trattamento e alla comunicazione
			dei propri dati personali.";

			$pdf->MultiCell(0,5,utf8_decode($testo), 0, "L");
			$pdf->Ln(10);
			$pdf->Cell(90,5,"LA RICHIEDENTE",0,0,'L');
			$pdf->Cell(100,5,"","B",1);

			$pdf->Ln(7);
			$pdf->Cell(100,5,"Allego:",0,1,'L');
			$pdf->Cell(100,5,utf8_decode("1. Fotocopia del documento di identità valido"),0,1,'L');
			$pdf->Cell(100,5,utf8_decode("2. Fotocopia del codice fiscale"),0,0,'L');

			$pdf->Ln(15);
			$pdf->Cell(90,5,"Per la Soc. Coop Steiner Waldorf Padova",0,1,'L');
			$pdf->Cell(90,5,"Firma rappresentante del CDA",0,0,'L');
			$pdf->Cell(100,5,"","B",1);
		}
	}
//#endregion

//#region Modulo SDD EX RID **************************************************************************************************
	if 	($ISC_include_SDD ==1) {
		$pdf->AddPage();
		$pdf->SetFont('TitilliumWeb-SemiBold','',14);
		$pdf->MultiCell(0,5,utf8_decode("Mandato per addebito diretto SEPA Core n° |__|__|__ /20__"), 0, "C");
		$pdf->Ln(2);
		$testo="La sottoscrizione del presente mandato, comporta l'autorizzazione per la ".$ragionesocialescuola."
		di richiedere alla banca del debitore l'addebito del suo conto e l'autorizzazione alla banca del debitore di procedere a tale addebito
		conformememente alle disposizioni impartite dalla ".$ragionesocialescuola." relativamente alle
		rette scolastiche della ".$nomescuola.".
		Il debitore ha diritto di ottenere il rimborso dalla propria Banca secondo gli accordi ed alle condizioni che regolano il rapporto contrattuale con la stessa. Se del caso, il rimborso deve essere richiesto nel termine di 8 settimane a decorrere della data di addebito in conto.";
		$pdf->SetFont($fontdefault,'',9);
		$pdf->MultiCell(0,5,utf8_decode($testo), 1, "L");

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
		$pdf->Cell(0,5,"DATI RELATIVI AL DEBITORE (titolare del Conto Corrente)", 0,1, 'L');
		$pdf->SetXY(10,80);
		$pdf->Cell($w1,$hriga,"Cognome ",0,0,'R');
		$pdf->Cell($w2,$hriga,"",1,0,'L');
		$pdf->Cell($w3,$hriga,"Nome ",0,0,'R');
		$pdf->Cell($w2,$hriga,"",1,1,'L');

		$pdf->Ln(2);
		$pdf->Cell($w1,$hriga,"Indirizzo ",0,0,'R');
		$pdf->Cell($w4,$hriga,"",1,0,'L');
		$pdf->Cell($w10,$hriga,"N. Civico ",0,0,'R');
		$pdf->Cell($w5,$hriga,"",1,1,'L');

		$pdf->Ln(2);
		$pdf->Cell($w1,$hriga,"Localita' ",0,0,'R');
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

		$pdf->Ln(12);
		$pdf->Cell($w1,$hriga,"Cod. IBAN ",0,0,'R');
		for ($x = 1; $x <= 27; $x++) {
			$pdf->Cell($w7,$hriga,"",1,0,'L');
			$pdf->Cell($wgap,$hriga,"",0,0,'L');
		}

	// CREDITORE
		$pdf->SetXY(10,130);
		$pdf->Cell(0,30,"", 1,1, 'L');
		$pdf->SetXY(10,130);
		$pdf->Cell(0,5,"DATI RELATIVI AL CREDITORE", 0,1, 'L');
		$pdf->SetXY(10,135);

		$pdf->Cell($w1,$hriga,"Rag. Sociale ",0,0,'R');
		$pdf->Cell($w8,$hriga,utf8_decode($ragionesocialescuola),1,1,'L');

		$pdf->Ln(2);
		$pdf->Cell($w1,$hriga,"Cod. Identificativo ",0,0,'R');	
		$pdf->Cell($w8,$hriga,$codIdentificativo,1,1,'L');

		$pdf->Ln(2);
		$pdf->Cell($w1,$hriga,"Sede Legale ",0,0,'R');	
		$pdf->Cell($w8,$hriga,$indirizzoscuola,1,0,'L');

	//SOTTOSCRITTORE
		$pdf->SetXY(10,165);
		$pdf->Cell(0,38,"", 1,1, 'L');
		$pdf->SetXY(10,165);
		$pdf->Cell(0,5,"DATI RELATIVI AL SOTTOSCRITTORE (nel caso in cui Sottoscrittore e Debitore NON coincidanoe)", 0,1, 'L');
		$pdf->SetXY(10,170);
		$pdf->Cell($w1,$hriga,"Cognome ",0,0,'R');
		$pdf->Cell($w2,$hriga,"",1,0,'L');
		$pdf->Cell($w3,$hriga,"Nome ",0,0,'R');
		$pdf->Cell($w2,$hriga,"",1,1,'L');

		$pdf->Ln(2);
		$pdf->Cell($w1,$hriga,"Indirizzo ",0,0,'R');
		$pdf->Cell($w4,$hriga,"",1,0,'L');
		$pdf->Cell($w10,$hriga,"N. Civico ",0,0,'R');
		$pdf->Cell($w5,$hriga,"",1,1,'L');

		$pdf->Ln(2);
		$pdf->Cell($w1,$hriga,"Localita' ",0,0,'R');
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
		$pdf->SetXY(10,205);
		$pdf->Cell(0,13,"", 1,1, 'L');

		$pdf->SetXY(10,208);
		$pdf->Cell($w1,$hriga,"Tipo di Pagamento ",0,0,'R');
		$pdf->Cell(65,7,"ricorrente".$pdf->Image($imgsquarecrossed,$pdf->GetX()+45, $pdf->GetY()+1,5),1,0,"C");
		$pdf->Cell(25,7,"",0,0,"C");
		$pdf->Cell(65,7,"singolo addebito".$pdf->Image($imgsquare,$pdf->GetX()+45, $pdf->GetY()+1,5),1,0,"C");

	//FIRMA
		$pdf->Ln(30);
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
//#endregion
$pdf->Output();
?>
