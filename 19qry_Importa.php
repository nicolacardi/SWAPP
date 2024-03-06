<?

	include_once("database/databaseii.php");
	//avvertenza: questa routine è un MOSTRO!

	$ID_fam = $_POST['ID_fam'];

	//estraggo l'anno scolastico che servirà in caso di cancellazione (non iscritto_alu e per le quote)
	$sqlA = "SELECT annopreiscrizione_fam FROM ".$_SESSION['databaseB'].".tab_famiglie WHERE ID_fam = ? ";
	$stmtA = mysqli_prepare($mysqli, $sqlA);
	mysqli_stmt_bind_param($stmtA, "i", $ID_fam);
	mysqli_stmt_execute($stmtA);
	mysqli_stmt_bind_result($stmtA, $annoscolastico);
	while (mysqli_stmt_fetch($stmtA)) {
	}
	
//Arrays per tab_anagraficaalunni ******************************************************************************
	
	//Array nomi dei campi da importare  ATTENZIONE: noniscritto_alu va lasciato per ultimo
	//per aggiungere un campo modificare 
	//$nomicampi, $stringaupdate

	$nomicampi = array("idle", "ID_alu", "nome_alu", "cognome_alu", "indirizzo_alu", "citta_alu", "CAP_alu", "prov_alu", "paese_alu", "cf_alu", "mf_alu", "datanascita_alu", "comunenascita_alu", "provnascita_alu", "paesenascita_alu", "cittadinanza_alu", "scuolaprovenienza_alu", "indirizzoscproven_alu", "ckautfoto_alu", "ckautmateriale_alu", "ckautuscite_alu", "quotapromessa_alu", "ratepromesse_alu", "disabilita_alu", "DSA_alu", "tipoquota_alu", "ckautuscitaautonoma_alu", "ckdoposcuola_alu", "ckreligione_alu", "altreligione_alu", "ckmensa_alu", "cktrasportopubblico_alu", "noniscritto_alu");  //importante! lasciare noniscritto_alu come ultimo campo, ID_alu come campo in posizione 1
	$stringaupdate = "issssssssssssssssiiiiiiiiiiiiii"; //include i campi da ID_alu al penultimo

//Scrittura dinamica dei valori in importazione in matrici *****************************************************	

	$numcampi = count($nomicampi);
	$importato = array();
	
	$sql = "SELECT ID_alu FROM ".$_SESSION['databaseB'].".tab_anagraficaalunni WHERE ID_fam_alu = ? ";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $ID_fam);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_alu);
	$nfratello = 0;
	while (mysqli_stmt_fetch($stmt)) {
		//per ciascun fratello della famiglia si fa questa assegnazione nella matrice
		$nfratello++;

			for ($nomecampo = 1; $nomecampo<$numcampi; $nomecampo++){
				$importato[$nomecampo][0][$nfratello] = $nomicampi[$nomecampo];
				$importato[$nomecampo][1][$nfratello] = $_POST["alu-".$ID_alu."-".$nomicampi[$nomecampo]."-"."1"];
				// la posizione [2] indica la scelta effettuata di importare il valore in arrivo o tenere quello già presente
				$importato[$nomecampo][2][$nfratello] = $_POST["alu-".$ID_alu."-".$nomicampi[$nomecampo]."-"."ck"]; 
				$importato[$nomecampo][3][$nfratello] = $_POST["alu-".$ID_alu."-".$nomicampi[$nomecampo]."-"."2"];


				//in importato [n][0][nfratello] metto il nome del campo
				//in importato [n][1][nfratello] metto il valore che si trova in dbA
				//in importato [n][2][nfratello] metto la scelta fatta (cioè se di importare il valore di dbA o il valore di dbB)
				//in importato [n][3][nfratello] metto il valore in arrivo da dbB 

				/*L'array $importato sarà poi fatto così
								[0]				[1]							[2]								[3]					
				1				ID_alu			10							1 (1 o 2  a 2^ si scelga A o B)	10						1
				2				nome_alu		Valentino					1								valentino				1
				3				cognome_alu		DalZio						2								Dal Zio					1
				4				indirizzo_alu	via cave					2								Via delle Cave 140/C	1
				5				citta_alu		Padova						1								padova					1
				6
				...
				E poi ce ne sarà anche uno per ogni fratello che c'è
												
								[0]				[1]							[2]								[3]					
				1				ID_alu			30							1 (1 o 2  a 2^ si scelga A o B)	10						2
				2				nome_alu		Galileo						1								Galileo					2
				3				cognome_alu		DalZio						2								Dal Zio					2
				4				indirizzo_alu	via cave					2								Via delle Cave 140/C	2
				5				citta_alu		Padova						1								padova					2
				6
				...
				quindi
				Il primo indice va da 0 a (numcampi - 1) ed è legato al campo
				Il secondo indice va da 0 a 3 e indica se si tratta del nome del campo, del valore in dbA, del ck, del valore in dbB
				Il terzo indice indica il numero del fratello (1,2, 3 ecc.)
				ad esempio:
				importato[2][0][1] = nome_alu
				importato[2][1][1] = Valentino
				importato[2][2][1] = 1
				importato[2][3][1] = valentino

				e così per ogni campo
				poi c'è la stessa cosa per ogni fratello
				*/	
				//in posizione (numcampi -1 ) ed in particolare in $importato[numcampi - 1][3][nfratello], se == 1 sta scritto se è stato scelto di non iscrivere
			}
	
	}
	$nfratelli = $nfratello;
	

	


//Costruzione dinamica della UPDATE sulla base delle matrici ***************************************************	

	for ($nfratello = 1; $nfratello<=$nfratelli; $nfratello++) {
		//in posizione numcampi - 1 ed in particolare in $importato[numcampi - 1][3][nfratello], si trova noniscrittto_alu 
		//se == 1 allora è stato scelto di non iscrivere

		if ($importato[$numcampi - 1][3][$nfratello]!= 1) {
			//creo la UPDATE in maniera dinamica ciclando sui campi da 1 all'ultimo
			$fieldsParam = array();
			$elencocampi = "";
			for ($nomecampo = 1; $nomecampo<($numcampi -1); $nomecampo++){
				$elencocampi = $elencocampi . $nomicampi[$nomecampo]. " = ? , ";
			}
			$elencocampi = substr ($elencocampi, 0, -2);
			
			$sql2 = "UPDATE tab_anagraficaalunni SET ".$elencocampi." WHERE ID_alu = ".$importato[1][1][$nfratello];

			$stmt2 = mysqli_prepare($mysqli, $sql2);
			$fieldsParam = array(&$stmt2, $stringaupdate);
			
			for ($campo = 1; $campo <($numcampi -1); $campo++) {
				//aggiungo ora i VALORI a fieldsParam. 
				//In [$campo] [2] sta scritto se l'utente ha scelto il valore importato da dbB $importato[$campo][3][$nfratello] 
				//oppure quello già presente in dbA $importato[$campo][1][$nfratello]
				
				if ($importato[$campo][2][$nfratello] == 1) { $fieldsParam[$campo + 1] = & $importato[$campo][1][$nfratello];} //attenzione alla notazione &!
				if ($importato[$campo][2][$nfratello] == 2) { $fieldsParam[$campo + 1] = & $importato[$campo][3][$nfratello];}
			}
			//a questo punto ho anche creato dinamicamente la stringa dei valori della update: essendo campi dinamici va usata call_user_func_array
			call_user_func_array('mysqli_stmt_bind_param', $fieldsParam);
			mysqli_stmt_execute($stmt2);
			mysqli_stmt_store_result($stmt2);
		} else{	
//Cancellazione in caso non iscritto ***************************************************************************	
			//***************************************copiato da 06qry_deleteAnnoScolastico...***********************
			$ID_alu = $importato[1][1][$nfratello];
			//devo estrarre QUALE anno scolastico vada cancellato. Questa informazione si trova nel campo annopreiscrizione_fam in dbB ed è stato compilato
			//da 19copiainDBB_fam.php


			//va cancellato ogni record da tab_classialunni dove ID_alu_cla e annoscolastico_cla (tabella delle iscrizioni all'anno scolastico)
			$sql = "DELETE FROM tab_classialunni ".
			" WHERE ID_alu_cla = ? AND annoscolastico_cla = ?;";
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_bind_param($stmt, "is", $ID_alu, $annoscolastico);
			mysqli_stmt_execute($stmt);
			//va cancellato ogni record (ce ne sono n in quanto ci sono 4 materie alle EL, 12 alle ME, 1 all'AS) da tab_classialunnivoti dove ID_alu_cla e annoscolastico_cla
			$sql = "DELETE FROM tab_classialunnivoti ".
			" WHERE ID_alu_cla = ? AND annoscolastico_cla = ?;";
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_bind_param($stmt, "is", $ID_alu, $annoscolastico);
			mysqli_stmt_execute($stmt);
			//va cancellato ogni record (ce ne sono n in quanto ci sono 9 materie in V e 9 in VIII) da tab_certcompetenze dove ID_alu_cer e annoscolastico_cer
			$sql = "DELETE FROM tab_certcompetenze ".
			" WHERE ID_alu_cer = ? AND annoscolastico_cer = ?;";
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_bind_param($stmt, "is", $ID_alu, $annoscolastico);
			mysqli_stmt_execute($stmt);
			//inoltre va cancellato ogni record in tab_mensilirette dove ID_alu_ret e annoscolastico_ret
			$sql2 = "DELETE FROM tab_mensilirette ".
			" WHERE ID_alu_ret = ? AND annoscolastico_ret = ?;";
			$stmt2 = mysqli_prepare($mysqli, $sql2);
			mysqli_stmt_bind_param($stmt2, "is", $ID_alu, $annoscolastico);
			mysqli_stmt_execute($stmt2);
			//infine va cancellato ogni record in tab_pagamentialtri dove ID_alu_ret e annoscolastico_ret
			// $sql3 = "DELETE FROM tab_pagamentialtri ".
			// " WHERE ID_alu_pga = ? AND annoscolastico_pga = ?;";
			// $stmt3 = mysqli_prepare($mysqli, $sql3);
			// mysqli_stmt_bind_param($stmt3, "is", $ID_alu, $annoscolastico);
			// mysqli_stmt_execute($stmt3);
			//e lo stesso in tab_pagamenti
			$sql35 = "DELETE FROM tab_pagamenti ".
			" WHERE ID_alu_pag = ? AND annoscolastico_pag = ?;";
			$stmt35 = mysqli_prepare($mysqli, $sql35);
			mysqli_stmt_bind_param($stmt35, "is", $ID_alu, $annoscolastico);
			mysqli_stmt_execute($stmt35);
			//**********************************FINO QUI *********************************
		}
	}
	
	
//Arrays per tab_famiglie **************************************************************************************

	$nomicampifam = array("idle", "cognome_fam", "sociopadre_fam", "cognomepadre_fam", "nomepadre_fam", "datanascitapadre_fam", "comunenascitapadre_fam", "provnascitapadre_fam", "paesenascitapadre_fam", "cfpadre_fam", "indirizzopadre_fam", "comunepadre_fam", "CAPpadre_fam", "provpadre_fam", "paesepadre_fam", "telefonopadre_fam", "altrotelpadre_fam", "emailpadre_fam", "titolopadre_fam", "profpadre_fam", "sociomadre_fam", "cognomemadre_fam", "nomemadre_fam", "datanascitamadre_fam", "comunenascitamadre_fam", "provnascitamadre_fam", "paesenascitamadre_fam", "cfmadre_fam", "indirizzomadre_fam", "comunemadre_fam", "CAPmadre_fam", "provmadre_fam", "paesemadre_fam", "telefonomadre_fam", "altrotelmadre_fam", "emailmadre_fam", "titolomadre_fam", "profmadre_fam", "quotacontraggiuntivo_fam", "ratecontraggiuntivo_fam", "intestazionefatt_fam", "modalitapag_fam", "pulizie_fam", "richcolloquio_fam", "ratepromesse_fam", "ckcarpoolingpadre_fam", "ckcarpoolingmadre_fam", "ibanpadre_fam", "ibanmadre_fam", "ruolopadre_fam", "ruolomadre_fam");

	$stringaupdatefam = "sisssssssssssssssssisssssssssssssssssiisiiiiiissss";

//Scrittura dinamica dei valori in importazione in matrici *****************************************************	

	$numcampifam = count($nomicampifam);
	$importatofam = array();
	
	
	for ($nomecampofam = 1; $nomecampofam<$numcampifam; $nomecampofam++){
		$importatofam[$nomecampofam][0][1] = $nomicampifam[$nomecampofam];
		$importatofam[$nomecampofam][1][1] = $_POST["fam-".$ID_fam."-".$nomicampifam[$nomecampofam]."-"."1"];
		$importatofam[$nomecampofam][2][1] = $_POST["fam-".$ID_fam."-".$nomicampifam[$nomecampofam]."-"."ck"];
		$importatofam[$nomecampofam][3][1] = $_POST["fam-".$ID_fam."-".$nomicampifam[$nomecampofam]."-"."2"];
	}
	

	
	//l'array è fatto così:
	//NOME CAMPO - 			VALORE DB A - SCELTA TRA A E B 	- VALORE DB B 			- SEMPRE 1 (per uniformità con parte alu)
	//nomepadre_fam   		Francesco   - 1                	- Francesco   			- 1
	//cognomepadre_fam  	Dal Zio     - 1               	- Dal Zio      			- 1
	//.....


	
	$n = 1;
	$fieldsParamfam = array();
	$elencocampifam = "";
	for ($nomecampofam = 1; $nomecampofam<$numcampifam; $nomecampofam++){
		$elencocampifam = $elencocampifam . $nomicampifam[$nomecampofam]. " = ? , ";
	}
	$elencocampifam = substr ($elencocampifam, 0, -2);
	
	$sql3 = "UPDATE tab_famiglie SET ".$elencocampifam." WHERE ID_fam = ".$ID_fam; //$importatofam[1][1][1];

	$stmt3 = mysqli_prepare($mysqli, $sql3);
	$fieldsParamfam = array(&$stmt3, $stringaupdatefam);
	for ($campofam = 1; $campofam<$numcampifam; $campofam++) {
		if ($importatofam[$campofam][2][1] == 1) { $fieldsParamfam[$campofam+1] = & $importatofam[$campofam][1][1];}
		if ($importatofam[$campofam][2][1] == 2) { $fieldsParamfam[$campofam+1] = & $importatofam[$campofam][3][1];}
	}
	call_user_func_array('mysqli_stmt_bind_param', $fieldsParamfam);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_store_result($stmt3);

	$sql4="DELETE FROM ".$_SESSION['databaseA'].".tab_composizionefam WHERE ID_fam_cfa = ?";
	$stmt4 = mysqli_prepare($mysqli, $sql4);
	mysqli_stmt_bind_param($stmt4, "i", $ID_fam);
	mysqli_stmt_execute($stmt4);

	$sql5 ="INSERT INTO ".$_SESSION['databaseA'].".tab_composizionefam (ID_fam_cfa, nome_cfa, cognome_cfa, dataluogonascita_cfa, gradoparentela_cfa) SELECT ID_fam_cfa, nome_cfa, cognome_cfa, dataluogonascita_cfa, gradoparentela_cfa FROM ".$_SESSION['databaseB'].".tab_composizionefam WHERE ".$_SESSION['databaseB'].".tab_composizionefam.ID_fam_cfa = ?;";
	$stmt5 = mysqli_prepare($mysqli, $sql5);
	mysqli_stmt_bind_param($stmt5, "i", $ID_fam);
	mysqli_stmt_execute($stmt5);

	$sql6 ="UPDATE ".$_SESSION['databaseB'].".tab_famiglie SET datirecuperati_fam = 1 WHERE ID_fam = ?;";
	$stmt6 = mysqli_prepare($mysqli, $sql6);
	mysqli_stmt_bind_param($stmt6, "i", $ID_fam);
	mysqli_stmt_execute($stmt6);

//Importazione e distribuzione delle quote *********************************************************************	
	//A questo punto va eseguita una importazione PARTICOLARE, per le quote, che vanno inserite
	//nella tabella tab_mensilirette, divise in base al numero di mensilità
	$D = array();
	$C = array();
	//$annoscolastico = $_POST['annoscolasticoprox'];  //sostituita dall'estrazione di annopreiscrizione_fam
	for ($nfratello = 1; $nfratello<=$nfratelli; $nfratello++) {

		//poichè è impensabile accedere alla routine di calcolo delle quote di default,
		//in quanto quella era stata pensata per un ID_alu alla volta, mentre
		//in questo caso dovrei ricalcolare le quote per 'i figli di una famiglia'
		//posso però estrarre la quota di default che GIA' è stata inserita in database e "riadattarla" al numero di rate
		//in posizione (numcampi - 1) ed in particolare in $importato[numcampi - 1][3][nfratello], se == 1 sta scritto se è stato scelto di non iscrivere
		//e andrà in noniscritto_alu
		if ($importato[$numcampi - 1][3][$nfratello]!= 1) {
			//Importo i valori SOLO SE si è scelto di importare la quota, altrimenti lascio come stava


			//in posizione 21 si trova la quota, in posizione 22 le rate
			//if ($importato[21][2][$nfratello] == 2) { //abbandono questa strada perchè altrimenti inserire un campo nuovo non si può
			$ID_alu_ret = $importato[1][1][$nfratello];
			if ( $_POST["alu-".$ID_alu_ret."-quotapromessa_alu-ck"] == '2') { //pesco direttamente il campo quotapromessa e ratepromesse
				//$quota = $importato[21][3][$nfratello];
				$quota = $_POST["alu-".$ID_alu_ret."-quotapromessa_alu-2"];
				//$rate = $importato[22][3][$nfratello];
				$rate = $_POST["alu-".$ID_alu_ret."-ratepromesse_alu-2"];

				// if ($rate == 99) { $QuotaProRata = $quota/10; } //in caso di rate "da concordare" si usa lo standard 10 rate
				// else {
					$QuotaProRata = $quota/$rate;
				// };

				$sql7 = "SELECT SUM(default_ret) as quotadefault FROM ".$_SESSION['databaseA'].".tab_mensilirette WHERE ID_alu_ret = ? AND annoscolastico_ret = ?;";
				$stmt7 = mysqli_prepare($mysqli, $sql7);
				mysqli_stmt_bind_param($stmt7, "is", $ID_alu_ret, $annoscolastico);
				mysqli_stmt_execute($stmt7);
				mysqli_stmt_bind_result($stmt7, $quotadefault);
				while (mysqli_stmt_fetch($stmt7)) {
				}

				// if ($rate == 99) { $QuotaProRataDefault = $quotadefault/10; } //in caso di rate "da concordare" si usa lo standard 10 rate
				// else { 
					$QuotaProRataDefault = $quotadefault/$rate;
				// }

				for ($x = 1; $x <= 12; $x++) {
					$D[$x] = 0;
				}
				for ($x = 1; $x <= 12; $x++) {
					$C[$x] = 0;
				}

				switch ($rate) {
				case 1:
					$SeqMesiRataUnicaDefault = $_SESSION['SeqMesiRataUnicaDefault'];
					//rata unica: va attribuita al mese che compare in SeqMesiRataUnicaDefault
					for ($x = 0; $x <= 11; $x++) {
						if (substr($SeqMesiRataUnicaDefault, $x, 1) == 1) {
							$D[$x+1] = $QuotaProRataDefault;
							$C[$x+1] = $QuotaProRata;
						}
					}
					break;
				case 2:
					$SeqMesi2RateDefault = $_SESSION['SeqMesi2RateDefault'];
					//2 rate: vanno attribuite ai mesi che compaiono in SeqMesi2RateDefault
					for ($x = 0; $x <= 11; $x++) {
						if (substr($SeqMesi2RateDefault, $x, 1) == 1) {
							$D[$x+1] = $QuotaProRataDefault;
							$C[$x+1] = $QuotaProRata;
						}
					}
					break;
				case 3:
					$SeqMesi3RateDefault = $_SESSION['SeqMesi3RateDefault'];
					//3 rate: vanno attribuite ai mesi che compaiono in SeqMesi3RateDefault
					for ($x = 0; $x <= 11; $x++) {
						if (substr($SeqMesi3RateDefault, $x, 1) == 1) {
							$D[$x+1] = $QuotaProRataDefault;
							$C[$x+1] = $QuotaProRata;
						}
					}
					break;
				case 10:
					//10 rate: da Gennaio a Giugno e da Settembre a Dicembre
					for ($x = 1; $x <= 6; $x++) {
						$D[$x] = $QuotaProRataDefault;
						$C[$x] = $QuotaProRata;
					}
					for ($x = 9; $x <= 12; $x++) {
						$D[$x] = $QuotaProRataDefault;
						$C[$x] = $QuotaProRata;
					}
					break;
				case 12:
					for ($x = 1; $x <= 12; $x++) {
						$D[$x] = $QuotaProRataDefault;
						$C[$x] = $QuotaProRata;
					}
					break;
				case 99:
					//uso per il caso di "rata da concordare" le 10 rate: da Gennaio a Giugno e da Settembre a Dicembre
					for ($x = 1; $x <= 6; $x++) {
						$D[$x] = $QuotaProRataDefault;
						$C[$x] = $QuotaProRata;
					}
					for ($x = 9; $x <= 12; $x++) {
						$D[$x] = $QuotaProRataDefault;
						$C[$x] = $QuotaProRata;
					}
					break;

				default:
				}

				for ($x = 1; $x <= 12; $x++) {
	
					$sql = "UPDATE tab_mensilirette SET
					default_ret = ? ,
					concordato_ret = ? , 
					pagato_ret =  0, 
					datapagato_ret =  '1900-01-01' 
					WHERE ID_alu_ret  = ? AND 
					mese_ret = ? AND 
					annoscolastico_ret = ? ";
					$stmt = mysqli_prepare($mysqli, $sql);

					mysqli_stmt_bind_param($stmt, "iiiis", $D[$x], $C[$x] , $ID_alu_ret, $x, $annoscolastico);

					mysqli_stmt_execute($stmt);
				}	
			}


		}
	}




	$return['sql3'] = $sql5;
	$return['importato'] = $importatofam[1][1][1];
	$return['test'] = $annoscolastico;

	$return['test2'] = $SeqMesiRataUnicaDefault;

	$return['test3'] = $sql7;
	$return['test4'] = $rate;
	$return['test5'] = $ratepromesse_alu;

	$return['test6'] = $quota;

	$return['test7'] = $QuotaProRata;

	$return['test8'] = $QuotaProRataDefault;
	$return['test9'] = $ID_alu_ret;
	$return['test10'] = $quotadefault;

     echo json_encode($return);?>

