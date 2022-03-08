<? 	

	//realpath(.) pare fornisca il path della route...rischioso?
	//include_once(realpath(".") . "/assets/functions/sqlBuildFunctions.php");
	include_once ("./assets/functions/sqlBuildFunctions.php");
	include_once ("assets/functions/functions.php");

	class Alunno {
		//classe Alunno
		
		//CAMPI DELLA TAB_ANAGRAFICAALUNNI
		public $ID_alu;
		public $nome_alu;
        public $cognome_alu;
        public $indirizzo_alu;
        public $citta_alu;
        public $CAP_alu;
        public $prov_alu;
        public $paese_alu;
		public $cf_alu;
		public $mf_alu;
		public $datanascita_alu;
		public $comunenascita_alu;
		public $provnascita_alu;
		public $paesenascita_alu;
		public $ckautfoto_alu;
		public $commento_alu;
		public $note_alu;
		public $img_alu;
		public $disabilita_alu;
		public $DSA_alu;
		// public $indirizzo2_alu;
        // public $citta2_alu;
        // public $CAP2_alu;
        // public $prov2_alu;
        // public $paese2_alu;
		public $scuolaprovenienza_alu;
		public $indirizzoscproven_alu;
		public $scuolaprimaprovenienza_alu;
		public $indirizzoscprimaproven_alu;
		// public $istcomprcompet_alu;
		// public $indirizzoistcompr_alu;
		// public $comuneistcompr_alu;
		// public $CAPistcompr_alu;
		// public $provistcompr_alu;
		public $ckautmateriale_alu;
		public $ckautuscite_alu;
		//altri campi non servono in questo contesto, semmai andranno aggiunti al model


		//CAMPI DELLA TAB_FAMIGLIA
		public $nomemadre_fam;
		public $cognomemadre_fam;
		public $telefonomadre_fam;
		public $altrotelmadre_fam;
		public $emailmadre_fam;
		public $sociomadre_fam;
		public $nomepadre_fam;
		public $cognomepadre_fam;
		public $telefonopadre_fam;
		public $altrotelpadre_fam;
		public $emailpadre_fam;
		public $sociopadre_fam;
		// public $datanascitapadre_fam;
		// public $comunenascitapadre_fam;
		// public $provnascitapadre_fam;
		// public $paesenascitapadre_fam;
		// public $cfpadre_fam;
		// public $indirizzopadre_fam;
		// public $comunepadre_fam;
		// public $provpadre_fam;
		// public $paesepadre_fam;
		// public $CAPpadre_fam;
		// public $titolopadre_fam;
		// public $profpadre_fam;
		// public $datanascitamadre_fam;
		// public $comunenascitamadre_fam;
		// public $provnascitamadre_fam;
		// public $paesenascitamadre_fam;
		// public $cfmadre_fam;
		// public $indirizzomadre_fam;
		// public $comunemadre_fam;
		// public $provmadre_fam;
		// public $paesemadre_fam;
		// public $CAPmadre_fam;
		// public $titolomadre_fam;
		// public $profmadre_fam;
		// public $imgmadre_fam;
		// public $imgpadre_fam;
		// public $notemadre_fam;
		// public $notepadre_fam ;
		// public $intestazionefatt_fam;

        //CAMPI DELLA TAB_CLASSIALUNNI
		public $classe_cla;
		public $classeprec_cla;
		public $ritirato_cla;
		public $sezione_cla;
		public $aselme_cla;
		public $annoscolastico_cla;

		//CAMPI DELLA TAB_LISTADATTESA
		public $data0_lda;
		public $data1_lda;
		public $data2_lda;
		public $data3_lda;


	}
	



	function GetAlunni ($campoName, $ord, $fil) {
		global $mysqli;
        $RetArray = array();

        
        // ora costruisco la clasuola ORDER BY sulla base di tutti i valori di ord
        for ($x = 1; $x <= 9; $x++) {
            $ordsql = orderbysql( $ord[$x], $campoName[$x], $ordsql);		
        }
        
        if ($ordsql == '') {
            $ordsql = ' ORDER BY cognome_alu ';
        } else {
            $ordsql = ' ORDER BY ' .  substr($ordsql, 2) ;
        }
        
        // ora costruisco la clasuola FILTER BY sulla base di tutti i valori di fil
        for ($x = 1; $x <= 9; $x++) {
            $fil[$x] = addslashes($fil[$x]); //escape con addslashes per poter selezionare anche casi tipo "d'andria"
            $filsql = filterbysqlexplode( $fil[$x], $campoName[$x], $filsql);
        }


        $filsql = " WHERE 1 = 1 ".$filsql; 
        $sql = "SELECT ID_alu, nome_alu, cognome_alu, indirizzo_alu, citta_alu, CAP_alu, prov_alu, paese_alu, cf_alu, mf_alu, datanascita_alu, comunenascita_alu, provnascita_alu, paesenascita_alu, ckautfoto_alu, commento_alu, note_alu, img_alu, disabilita_alu, ckautmateriale_alu, ckautuscite_alu, nomemadre_fam, cognomemadre_fam, telefonomadre_fam, altrotelmadre_fam, emailmadre_fam, sociomadre_fam, nomepadre_fam, cognomepadre_fam, telefonopadre_fam, altrotelpadre_fam, emailpadre_fam, sociopadre_fam FROM (tab_anagraficaalunni ".
        "LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam )".
		$filsql.$ordsql;
    
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $ID_alu, $nome_alu, $cognome_alu, $indirizzo_alu, $citta_alu, $CAP_alu, $prov_alu, $paese_alu, $cf_alu, $mf_alu, $datanascita_alu, $comunenascita_alu, $provnascita_alu, $paesenascita_alu, $ckautfoto_alu, $commento_alu, $note_alu, $img_alu, $disabilita_alu, $ckautmateriale_alu, $ckautuscite_alu, $nomemadre_fam, $cognomemadre_fam, $telefonomadre_fam, $altrotelmadre_fam, $emailmadre_fam, $sociomadre_fam, $nomepadre_fam, $cognomepadre_fam, $telefonopadre_fam, $altrotelpadre_fam, $emailpadre_fam, $sociopadre_fam);

		while (mysqli_stmt_fetch($stmt)) {
			$MyAlu = new Alunno();
            $MyAlu->ID_alu = $ID_alu;
            $MyAlu->nome_alu = $nome_alu;
			$MyAlu->cognome_alu = $cognome_alu;
			$MyAlu->indirizzo_alu = $indirizzo_alu;
			$MyAlu->citta_alu = $citta_alu;
			$MyAlu->CAP_alu = $CAP_alu;
			$MyAlu->prov_alu = $prov_alu;
			$MyAlu->paese_alu = $paese_alu;
			$MyAlu->cf_alu = $cf_alu;
			$MyAlu->mf_alu = $mf_alu;
			$MyAlu->datanascita_alu = timestamp_to_ggmmaaaa($datanascita_alu);
			$MyAlu->comunenascita_alu = $comunenascita_alu;
			$MyAlu->provnascita_alu = $provnascita_alu;
			$MyAlu->paesenascita_alu = $paesenascita_alu;
			$MyAlu->ckautfoto_alu = $ckautfoto_alu;
			$MyAlu->commento_alu = $commento_alu;
			$MyAlu->note_alu = $note_alu;
			$MyAlu->img_alu = $img_alu;
			$MyAlu->disabilita_alu = $disabilita_alu;
			$MyAlu->ckautmateriale_alu = $ckautmateriale_alu;
			$MyAlu->ckautuscite_alu = $ckautuscite_alu;
			$MyAlu->nomemadre_fam = $nomemadre_fam;
			$MyAlu->cognomemadre_fam = $cognomemadre_fam;
			$MyAlu->telefonomadre_fam = $telefonomadre_fam;
			$MyAlu->altrotelmadre_fam = $altrotelmadre_fam;
			$MyAlu->emailmadre_fam = $emailmadre_fam;
			$MyAlu->sociomadre_fam = $sociomadre_fam;
			$MyAlu->nomepadre_fam = $nomepadre_fam;
			$MyAlu->cognomepadre_fam = $cognomepadre_fam;
			$MyAlu->telefonopadre_fam = $telefonopadre_fam;
			$MyAlu->altrotelpadre_fam = $altrotelpadre_fam;
			$MyAlu->emailpadre_fam = $emailpadre_fam;
			$MyAlu->sociopadre_fam = $sociopadre_fam;


			array_push ($RetArray, $MyAlu);

		}

        return ($RetArray);
	}
	



	function GetAlunniPerAnno ($campoName, $ncampi, $ord, $fil, $annoscolastico_cla, $listaattesa) {
		global $mysqli;
		$RetArray = array();

        // ora costruisco la clasuola ORDER BY sulla base di tutti i valori di ord
        for ($x = 1; $x <= $ncampi; $x++) {
            $ordsql = orderbysql( $ord[$x], $campoName[$x], $ordsql);		
        }


		if ($ordsql == '') {
			$ordsql =  ' ORDER BY ord_cls, tab_classialunni.classe_cla, tab_classialunni.sezione_cla, cognome_alu ';
		} else {
			$ordsql = ' ORDER BY ' .  substr($ordsql, 2) ;
		}
		// ora costruisco la clasuola FILTER BY sulla base di tutti i valori di fil
		for ($x = 1; $x <= $ncampi; $x++) {
				$fil[$x] = addslashes($fil[$x]);
				$filsql = filterbysqlexplode( $fil[$x], $campoName[$x], $filsql);
		}

	
		//costruisco la WHERE per la parte relativa all'anno scolastico e
		//CONTEMPORANEAMENTE determino annorecorrente e annoreprossimo utili per le coroncine

		if ($annoscolastico_cla !="all")
		{
			$whereannocorrente = "WHERE tab_classialunni.annoscolastico_cla = '".$annoscolastico_cla."'";
		} else {
			$whereannocorrente = "WHERE tab_classialunni.annoscolastico_cla  <> '' ";
		}

		//incredibilmente se metto due soli uguali non funziona in certi casi
		if ($listaattesa === "All") {
		 	$wherelistaattesa = " ";
		} else {
			$wherelistaattesa = " AND tab_classialunni.listaattesa_cla = ".$listaattesa." ";
		}

		$sql = "SELECT DISTINCT ID_alu, ID_asc, ord_cls, nome_alu, cognome_alu, mf_alu, cf_alu, tab_classialunni.annoscolastico_cla, tab_classialunni.aselme_cla, tab_classialunni.classe_cla, tab_classialunni.sezione_cla, tab_classialunni.listaattesa_cla, indirizzo_alu, citta_alu, prov_alu, CAP_alu, paese_alu, datanascita_alu, comunenascita_alu, provnascita_alu, paesenascita_alu, ckautfoto_alu, ckautuscite_alu, ckautmateriale_alu,
		
		nomepadre_fam, cognomepadre_fam, telefonopadre_fam, altrotelpadre_fam, emailpadre_fam, nomemadre_fam, cognomemadre_fam,  telefonomadre_fam, altrotelmadre_fam, emailmadre_fam, sociopadre_fam, sociomadre_fam, annoscolasticoprec_asc, tab_classialunniprec.classe_cla AS classeprec_cla, tab_classialunni.ritirato_cla, data0_lda, data1_lda, data2_lda, data3_lda, accolto_lda
		FROM (((((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) 
		LEFT JOIN tab_famiglie ON ID_fam_alu = ID_fam) 
		LEFT JOIN tab_classi ON classe_cls = tab_classialunni.classe_cla ) 
		LEFT JOIN tab_anniscolastici ON annoscolastico_cla = annoscolastico_asc ) 
		LEFT JOIN tab_classialunni AS tab_classialunniprec ON tab_classialunniprec.annoscolastico_cla = annoscolasticoprec_asc AND ID_alu = tab_classialunniprec.ID_alu_cla) 
		LEFT JOIN tab_listadattesa ON ID_alu = ID_alu_lda AND tab_classialunni.annoscolastico_cla = annoscolastico_lda ".
		$whereannocorrente.$wherelistaattesa.$filsql.$ordsql;
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $ID_alu, $ID_asc, $ord_cls, $nome_alu, $cognome_alu, $mf_alu, $cf_alu, $annoscolastico_cla, $aselme_cla, $classe_cla, $sezione_cla, $listaattesa_cla, $indirizzo_alu, $citta_alu, $prov_alu, $CAP_alu, $paese_alu, $datanascita_alu, $comunenascita_alu, $provnascita_alu, $paesenascita_alu, $ckautfoto_alu, $ckautuscite_alu, $ckautmateriale_alu,
		$nomepadre_fam, $cognomepadre_fam, $telefonopadre_fam, $altrotelpadre_fam, $emailpadre_fam, $nomemadre_fam, $cognomemadre_fam,  $telefonomadre_fam, $altrotelmadre_fam, $emailmadre_fam, $sociopadre_fam, $sociomadre_fam, $annoscolasticoprec_asc, $classeprec_cla, $ritirato_cla, $data0_lda, $data1_lda, $data2_lda, $data3_lda, $accolto_lda);
		//id_asc è l'indice che corrisponde in tabella anniscolastici all'annoscolastico del record selezionato. Lo estraggo per metterlo nell'attributo name del campo tipo checkbox perchè serve
		//a effettuare le promozioni: con il codice id_asc si può accedere alla tabella anniscolastici ed estrarre l'anno scolastico "+1". Va salvato "padded" nel name della checkbox per poterlo poi estrarre.

		while (mysqli_stmt_fetch($stmt)) {
			$MyAlu = new Alunno();
			$MyAlu->ID_alu = $ID_alu;
			$MyAlu->nome_alu = $nome_alu;
			$MyAlu->cognome_alu = $cognome_alu;
			$MyAlu->indirizzo_alu = $indirizzo_alu;
			$MyAlu->citta_alu = $citta_alu;
			$MyAlu->CAP_alu = $CAP_alu;
			$MyAlu->prov_alu = $prov_alu;
			$MyAlu->paese_alu = $paese_alu;
			$MyAlu->cf_alu = $cf_alu;
			$MyAlu->mf_alu = $mf_alu;
			$MyAlu->datanascita_alu = $datanascita_alu;
			$MyAlu->comunenascita_alu = $comunenascita_alu;
			$MyAlu->provnascita_alu = $provnascita_alu;
			$MyAlu->paesenascita_alu = $paesenascita_alu;
			$MyAlu->ckautfoto_alu = $ckautfoto_alu;
			// $MyAlu->commento_alu = $commento_alu;
			// $MyAlu->note_alu = $note_alu;
			// $MyAlu->img_alu = $img_alu;
			// $MyAlu->disabilita_alu = $disabilita_alu;
			$MyAlu->ckautmateriale_alu = $ckautmateriale_alu;
			$MyAlu->ckautuscite_alu = $ckautuscite_alu;
			$MyAlu->nomemadre_fam = $nomemadre_fam;
			$MyAlu->cognomemadre_fam = $cognomemadre_fam;
			$MyAlu->telefonomadre_fam = $telefonomadre_fam;
			$MyAlu->altrotelmadre_fam = $altrotelmadre_fam;
			$MyAlu->emailmadre_fam = $emailmadre_fam;
			$MyAlu->sociomadre_fam = $sociomadre_fam;
			$MyAlu->nomepadre_fam = $nomepadre_fam;
			$MyAlu->cognomepadre_fam = $cognomepadre_fam;
			$MyAlu->telefonopadre_fam = $telefonopadre_fam;
			$MyAlu->altrotelpadre_fam = $altrotelpadre_fam;
			$MyAlu->emailpadre_fam = $emailpadre_fam;
			$MyAlu->sociopadre_fam = $sociopadre_fam;
			//MANCANO TANTI CAMPI...........................................................
			$MyAlu->classe_cla = $classe_cla;
			$MyAlu->classeprec_cla = $classeprec_cla;
			$MyAlu->sezione_cla = $sezione_cla;
			$MyAlu->ritirato_cla = $ritirato_cla;
			$MyAlu->aselme_cla = $aselme_cla;
			$MyAlu->annoscolastico_cla = $annoscolastico_cla;
			

			//aggiungo alcuni campi che mi servono e che non son prropriamente della clsse alunni
			$MyAlu->where = $filsql; 			//mi serve per fare il download dei dati filtrati
			$MyAlu->ord = $ordsql; 				//mi serve per debug solo
			array_push ($RetArray, $MyAlu);
			$MyAlu->ID_asc = $ID_asc;
			$MyAlu->ord_cls = $ord_cls;

			$MyAlu->data0_lda = $data0_lda;
			$MyAlu->data1_lda = $data1_lda;
			$MyAlu->data2_lda = $data2_lda;
			$MyAlu->data3_lda = $data3_lda;
			//$MyAlu->test = $sql;
			
		}

		
	return ($RetArray);

	}



	//************************** NON USATA ***************************/
	function GetAlunniPerAnnoWithPresenze ($campoName, $ncampi, $ord, $fil, $annoscolastico_cla, $listaattesa) {
		global $mysqli;
		$RetArray = array();

		$sql3 = "SELECT DISTINCT ora_ora 
		FROM tab_orario 
		WHERE classe_ora = ? 
		AND sezione_ora = ? 
		AND data_ora = ? ;";

		

        // ora costruisco la clausola ORDER BY sulla base di tutti i valori di ord
        for ($x = 1; $x <= $ncampi; $x++) {
            $ordsql = orderbysql( $ord[$x], $campoName[$x], $ordsql);		
        }


		if ($ordsql == '') {
			$ordsql =  ' ORDER BY ord_cls, tab_classialunni.classe_cla, tab_classialunni.sezione_cla, cognome_alu ';
		} else {
			$ordsql = ' ORDER BY ' .  substr($ordsql, 2) ;
		}
		// ora costruisco la clasuola FILTER BY sulla base di tutti i valori di fil
		for ($x = 1; $x <= $ncampi; $x++) {
				$fil[$x] = addslashes($fil[$x]);
				$filsql = filterbysqlexplode( $fil[$x], $campoName[$x], $filsql);
		}
	
		//costruisco la WHERE per la parte relativa all'anno scolastico e

		if ($annoscolastico_cla !="all")
		{
			$whereannocorrente = "WHERE tab_classialunni.annoscolastico_cla = '".$annoscolastico_cla."'";
		} else {
			$whereannocorrente = "WHERE tab_classialunni.annoscolastico_cla  <> '' ";
		}

		//incredibilmente se metto due soli uguali non funziona in certi casi
		if ($listaattesa === "All") {
		 	$wherelistaattesa = " ";
		} else {
			$wherelistaattesa = " AND tab_classialunni.listaattesa_cla = ".$listaattesa." ";
		}

		$sql = "SELECT DISTINCT 
		ID_alu, 
		nome_alu, cognome_alu, 
		tab_classialunni.annoscolastico_cla, tab_classialunni.aselme_cla, tab_classialunni.classe_cla, tab_classialunni.sezione_cla, tab_classialunni.listaattesa_cla, 

		tab_classialunni.ritirato_cla,
		ID_asc, ord_cls

		FROM tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla 
		LEFT JOIN tab_classi ON classe_cls = tab_classialunni.classe_cla 
		LEFT JOIN tab_anniscolastici ON annoscolastico_cla = annoscolastico_asc 
		LEFT JOIN tab_assenze ON ID_alu = ID_alu_ass 
		
		".

		$whereannocorrente.$wherelistaattesa.$filsql.$ordsql;
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $ID_alu, $nome_alu, $cognome_alu, $annoscolastico_cla, $aselme_cla, $classe_cla, $ritirato_cla, $sezione_cla, $listaattesa_cla,  $ID_asc, $ord_cls);


		while (mysqli_stmt_fetch($stmt)) {
			$MyAlu = new Alunno();
			$MyAlu->ID_alu = $ID_alu;
			$MyAlu->nome_alu = $nome_alu;
			$MyAlu->cognome_alu = $cognome_alu;

			$MyAlu->classe_cla = $classe_cla;
			$MyAlu->sezione_cla = $sezione_cla;
			$MyAlu->ritirato_cla = $ritirato_cla;
			$MyAlu->aselme_cla = $aselme_cla;
			$MyAlu->annoscolastico_cla = $annoscolastico_cla;

			//aggiungo alcuni campi che mi servono e che non son prropriamente della clsse alunni
			$MyAlu->where = $filsql; 			//mi serve per fare il download dei dati filtrati
			$MyAlu->ord = $ordsql; 				//mi serve per debug solo
			array_push ($RetArray, $MyAlu);
			$MyAlu->ID_asc = $ID_asc;
			$MyAlu->ord_cls = $ord_cls;
			
		}

		
	return ($RetArray);

	}

	




	function GetArrayAnniScolasticiFrequentati () {
		global $mysqli;
        $RetArray = array();
		$sql = "SELECT DISTINCT annoscolastico_cla FROM tab_classialunni ORDER BY annoscolastico_cla ";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $annoscolastico_cla);

		while (mysqli_stmt_fetch($stmt)) {
			$MyAlu = new Alunno();
			$MyAlu->annoscolastico_cla = $annoscolastico_cla;
			
			array_push ($RetArray, $MyAlu);
		}
		return ($RetArray);
	}


	

?>