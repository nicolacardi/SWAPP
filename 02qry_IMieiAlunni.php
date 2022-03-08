<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("classi/alunni.php");

	$ID_mae = $_POST['ID_mae'];
	$annoscolastico_cla = $_POST['annoscolastico_cla'];

	//ora costruisco la clasuola ORDER BY sulla base di tutti i valori di ord
	//Metto com prima clausola ORDER BY quella della Classe che sicuramente deve prevalere sulle altre qualora selezionata
	
	for ($x = 1; $x <= 4; $x++) {
		$campo[$x] = $_POST['campo'][$x];
		//se il campo è del tipo tab_classialunni.classe_cla devo estrarre solo la seconda parte
		if (strpos($campo[$x], '.')) {$campo[$x] = substr($campo[$x], strrpos($campo[$x], '.') + 1);}
	}


		//devo passare alla classe alunni le classi scolastiche (e sezioni) del maestro in quest'anno: vado ad estrarle e le inserisco nel filtro del campo 3 e 4
		$classiA = array();
		$sezioniA =  array();
		$sql = "SELECT DISTINCT classe_cma, sezione_cma, vede_mae FROM tab_classimaestri LEFT JOIN tab_anagraficamaestri ON ID_mae_cma = ID_mae WHERE ID_mae_cma = ? AND annoscolastico_cma = ?";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "is", $ID_mae, $_POST['annoscolastico_cla']);	
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $classe_cma, $sezione_cma, $vede_mae);
		mysqli_stmt_store_result($stmt);
		$n = 0;
		while (mysqli_stmt_fetch($stmt)) {
			$n++;
			//Gli Array $classiA[] e $sezioniA[] contengono le combinazioni classe/sezione da mostrare
			$classiA[$n] =  $classe_cma;
			$sezioniA[$n] = $sezione_cma;
		}


		//nel caso in cui $vede_mae = 2 devo mostrare TUTTE le classi, quindi i due array vado a RIFARLI includendo tutte le classi dell'anno (asili esclusi)

		if ($vede_mae == 2) {
			//vuoto i due array appena creati e li riempio di nuovo con tutte le classi
			$classiA = array();
			$sezioniA = array();
			$sql = "SELECT DISTINCT classe_cma, sezione_cma FROM tab_classimaestri LEFT JOIN tab_classi ON classe_cls = classe_cma WHERE annoscolastico_cma = ? AND aselme_cls <> 'AS'";
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_bind_param($stmt, "s", $_POST['annoscolastico_cla']);	
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $classe_cma, $sezione_cma);
			$n = 0;
			while (mysqli_stmt_fetch($stmt)) {
				$n++;
				//Gli Array $classiA[] e $sezioniA[] contengono le combinazioni classe/sezione da mostrare
				$classiA[$n] =  $classe_cma;
				$sezioniA[$n] = $sezione_cma;
			}
		}
		//fil[3] è il filtro classe
		

		$fil[3] = "";
		for ($x = 1; $x <= $n; $x++) {
			$fil[3] = $fil[3].",".$classiA[$x]; //creo il filtro con l'elenco delle classi estratte
		}



		//******NON E' PERFETTA QELLA CHE SEGUE MA VA QUASI BENE */
		//arriva $_POST['fil'][3] che è ciò che è stato scritto
		//devo:
		//togliere l'eventuale =
		//creare un array a partire dal fatto che potrebbe essere scritto con delle virgole
		$FilterClasse = $_POST['fil'][3];
		if ($FilterClasse != '') {
			$FilterClasseBackup = $FilterClasse;
			if (substr($FilterClasseBackup, 0, 1) == "=") { $FilterClasse = substr($FilterClasse, 1); }
			$FilterClasseA = explode(",",$FilterClasse);
			//a questo punto ho classiA che contiene tutte le classi e FilterClasseA che contiene quelle che sono state digitate
			//devo confrontare FilterClasseA con classiA: e togliere eventuali classi che NON siano comprese in classiA
			//per ogni elemento di quelli scritti nel filtro...
			 foreach ($FilterClasseA as $ClasseSingola) {
			 	//se NON lo trovo nell'elenco delle classi consentite
			 	 if (!in_array($ClasseSingola, $classiA)) {
			 	 	//lo tolgo (cioè trovo in che posizione sta....e ne  faccio lo splice.)
			 	 	//array_splice($FilterClasseA, array_search($ClasseSingola, $FilterClasseA));
					$FilterClasseA[array_search($ClasseSingola, $FilterClasseA)] = "@";  //FACCIO ANDARE IN ERRORE QUESTA RICERCA
			 	 }
			 } 
			 $str = implode (",", $FilterClasseA);
			 if (substr($FilterClasseBackup, 0, 1) == "="  && $str != '') { $str = "=".$str;}
			 $str = "=".$str; 
			 $_POST['fil'][3] = $str;
		}






		if ($_POST['fil'][3] == '') {
			$_POST['fil'][3] = "=".substr($fil[3], 1) ; //se non c'è filtro uso l'elenco classi estratte
		}
		
		$fil[4] = "";
		for ($x = 1; $x <= $n; $x++) {
			$fil[4] = $fil[4].",".$sezioniA[$x]; 
		}
		if ($_POST['fil'][4] == '') {
			$_POST['fil'][4] = "=".substr($fil[4], 1) ;
		}

		?>
		<tr>
		<td>
	
			<?//echo(json_encode($_POST['ID_mae']))?>
			
			<?//=print_r($_POST['fil']);?>
		</td>
		</tr>
	<?
	
	//su richiesta di maestra Edith (03/02/19) torno a mostrare gli alunni ritirati

	$riga =  0;

	foreach (GetAlunniPerAnno ($_POST['campo'], 4, $_POST['ord'], $_POST['fil'], $_POST['annoscolastico_cla'], 0) as $alunno) {
		$riga++;
		if ($alunno->emailpadre_fam!="") {$emailtotale =  $emailtotale.",".$alunno->emailpadre_fam;}
		if ($alunno->emailmadre_fam!="") {$emailtotale =  $emailtotale.",".$alunno->emailmadre_fam;}
		?>
		<tr>
			<td style="width: 40px;">
			<?//=$alunno->test?>
			<?//print_r($FilterClasseA)?>
			
			<?//print_r($classiA)?>
				<button  style="font-size: 12px; text-align: center; width: 90%;" id="button_<?=$alunno->ID_alu?>" name="alu<?=$ID_alu?>" onclick="requeryDettaglio(<?=$alunno->ID_alu?>);" ><?=$riga?></button>
			</td>
			<td style="width:120px;">
				<input class="tablecell3 disab val<? echo($alunno->ID_alu) ?> w100" type="text" name="nome_alu" value = "<?=$alunno->nome_alu?>" disabled>
			</td>
			<td style="width:120px;">
				<input class="tablecell3 disab val<? echo($alunno->ID_alu) ?> w100" type="text" name="cognome_alu" value = "<?=$alunno->cognome_alu?>" disabled>
			</td>
			<td style="width:120px;">
				<input class="tablecell3 disab val<? echo($alunno->ID_alu) ?> w100" type="text" name="classe_cla" value = "<?=$alunno->classe_cla?>" disabled>
			</td>
			<td style="width:60px;">
				<input class="tablecell3 disab val<? echo($alunno->ID_alu) ?> w100" type="text" name="sezione_cla" value = "<?=$alunno->sezione_cla?>" disabled>
			</td>
			<td>
				<input id ="aselme<? echo($alunno->ID_alu) ?>" value = "<?=$alunno->aselme_cla?>" hidden>
			</td>
			<!-- <td class="w50px" style="display: none;">
				<div style="margin-left: 0px;">
				<?
								// $countvot1 = 0;
								// $countvot2 = 0;
								// $countgiu1 = 0;
								// $countgiu2 = 0;

								// //estraggo il tipo di pagella da utilizzare (1 o 2 e il numero di campi che sono da compilare in quel tipo)
								// $sql4 = "SELECT val_paa FROM tab_parametrixanno WHERE annoscolastico_paa = ? AND parname_paa = 'tipopagella_" .
								// $aselme_cla.
								// "';";
								// $stmt4 = mysqli_prepare($mysqli, $sql4);
								// mysqli_stmt_bind_param($stmt4, "s", $annoscolastico_cla);
								// mysqli_stmt_execute($stmt4);
								// mysqli_stmt_bind_result($stmt4, $tipopagella);
								// mysqli_stmt_store_result($stmt4);
								// while (mysqli_stmt_fetch($stmt4)) {}

								// //Il numero di campi da compilare dipende dal tipo di pagella, che ho estratto per l'anno corrente, da aselme e dal quadrimestre
								// //					1Q		2Q		1Q		2Q
								// //					EL		EL		ME		ME
								// //
								// //TIPO 1			11		11		27		27
								// //
								// //TIPO	2			26		27		28		29
								// //Lo metto giù come un array (avevo pensato di estrarlo da tab_parametrixanno dove li ho anche scritti,
								// //ma poi è stato definito che dipendono anche dal quadrimestre quindi avrei dovuto raddoppiare i record di tab_parametrixanno, non buono!

								// $NVot_GiuA = array("Tipo1_EL_1Q"=>11, "Tipo1_EL_2Q"=>11, "Tipo2_EL_1Q"=>26, "Tipo2_EL_2Q"=>27, "Tipo1_ME_1Q"=>27, "Tipo1_ME_2Q"=>27, "Tipo2_ME_1Q"=>28, "Tipo2_ME_2Q"=>29);
								// $indice1 = "Tipo".$tipopagella."_".$alunno->aselme_cla."_1Q";
								// $indice2 = "Tipo".$tipopagella."_".$alunno->aselme_cla."_2Q";
								// $NVot_Giu1 = $NVot_GiuA[$indice1];
								// $NVot_Giu2 = $NVot_GiuA[$indice2];

								// //Somma il numero di giudizi complessivi, quelli del primo e del secondo quadrimestre != "" da tab_classialunni in countgiu1 e in countgiu2
								// //in questa tabella viene scritto il giudizio finale ed intermedio
								// $sql3 = "SELECT giuquad1_cla, giuquad2_cla ".
								// "FROM tab_classialunni ".
								// "WHERE ID_alu_cla = ? AND annoscolastico_cla = ?";
								// $stmt3 = mysqli_prepare($mysqli, $sql3);
								// mysqli_stmt_bind_param($stmt3, "is", $alunno->ID_alu, $annoscolastico_cla);
								// mysqli_stmt_execute($stmt3);
								// mysqli_stmt_bind_result($stmt3, $giuquad1_cla, $giuquad2_cla);
								// mysqli_stmt_store_result($stmt3);
								// while (mysqli_stmt_fetch($stmt3)) {
								// 	if ($giuquad1_cla != "" && (strlen($giuquad1_cla) != 0) ) {$countgiu1++;}
								// 	if ($giuquad2_cla != "" && (strlen($giuquad2_cla) != 0) ) {$countgiu2++;}
								// }

								// $whereannocorrente2 = " AND annoscolastico_cla = '".$annoscolastico_cla."' ";
								// //aggiunge a countgiu1 e countgiu2 i giudizi != 0 di tab_classialunnivoti
								// //in questa tabella vengono scritti tutti i giudizi delle singole materie
								// //inoltre somma il numero di voti del primo e secondo quadrimestre != "" in countvot1 e countvot2
								// $sql2 = "SELECT ID_alu_cla, ".
								// "vot1_cla, giu1_cla, vot2_cla, giu2_cla ".
								// "FROM tab_classialunnivoti LEFT JOIN tab_materievoti ON codmat_cla = codmat_mat  AND aselme_cla = aselme_mat ".
								// "WHERE ID_alu_cla = ? AND tipodoc_mat = ? ".$whereannocorrente2;
								// //DA RENDERE PARAMETRICA - DIFFICILE
								// $stmt2 = mysqli_prepare($mysqli, $sql2);
								// mysqli_stmt_bind_param($stmt2, "ii", $alunno->ID_alu, $tipopagella);
								// mysqli_stmt_execute($stmt2);
								// mysqli_stmt_bind_result($stmt2, $ID_alu_claTMP, $vot1_claTMP, $giu1_claTMP, $vot2_claTMP, $giu2_claTMP);
								// mysqli_stmt_store_result($stmt2);
								// while (mysqli_stmt_fetch($stmt2)) {
								// 	if (($vot1_claTMP != "" ) && ($vot1_claTMP != "0") && ($vot1_claTMP != "-") && !(is_null($vot1_claTMP))) {$countvot1++;}
								// 	if (($vot2_claTMP != "" ) && ($vot2_claTMP != "0") && ($vot2_claTMP != "-") && !(is_null($vot2_claTMP))) {$countvot2++;}
								// 	if (($giu1_claTMP != "" ) && (strlen($giu1_claTMP) != 0)) {$countgiu1++;}
								// 	if (($giu2_claTMP != "" ) && (strlen($giu2_claTMP) != 0)) {$countgiu2++;}
								// }

								// //echo(($countvot1."+".$countgiu1."vs".$NVot_Giu1));
								// if ($alunno->aselme_cla != "AS" && $alunno->aselme_cla != "NI") {
								// 	// if ($countvot1 + $countgiu1 == 0) {echo("<img title='Pagella del 1^quadrimestre da iniziare' style='margin-left: 5px;' src='assets/img/ledrosso.png'>"); }
								// 	// else if (($countvot1 + $countgiu1) < $NVot_Giu1)  {echo("<img title='Pagella del 1^quadrimestre incompleta' style='margin-left: 5px;' src='assets/img/ledgiallo.png'>"); }
								// 	// else if (($countvot1 + $countgiu1) == $NVot_Giu1)  {echo("<img title='Pagella del 1^quadrimestre completa' style='margin-left: 5px;' src='assets/img/ledverde.png'>");}
								// 	// if ($countvot2 + $countgiu2 == 0) {echo("<img title='Pagella del 2^quadrimestre da iniziare' style='margin-left: 5px;' src='assets/img/ledrosso.png'>"); }
								// 	// else if (($countvot2 + $countgiu2) < $NVot_Giu2)  {echo("<img title='Pagella del 2^quadrimestre incompleta' style='margin-left: 5px;' src='assets/img/ledgiallo.png'>"); }
								// 	// else if (($countvot2 + $countgiu2) == $NVot_Giu2)  {echo("<img title='Pagella del 2^quadrimestre completa' style='margin-left: 5px;' src='assets/img/ledverde.png'>");}	
								// }?>

				</div>
			</td> -->
		</tr>
	<?}?>
		
	<tr>
		<td>
			<input id="contarecord_hidden" 		value = "<?=$riga?>" 		hidden>
		</td>
		<td>
			<input id="emailtotalehidden" 		value = "<?=$emailtotale?>" hidden>
		</td>
	</tr>

<script>
	$(document).ready(function(){
		let listaemails = $('#emailtotalehidden').val();
		listaemails = listaemails.slice(1);
		listaemails = "mailto:"+listaemails;
		$("#mailtotutti").attr("href", listaemails );
	});
	
	async function requeryDettaglio(ID_alu){

		//activeTab contiene il nome del tab attivo, o undefined se nessuno è attivo - tutte le tabs nascoste
		let activeTab = $('.nav-tabs .active > a').attr('href');
		coloraRighe (ID_alu);
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		postData = { ID_alu : ID_alu, annoscolastico_cla: annoscolastico_cla, activeTab: activeTab};
		//console.log ("02qry_IMieiAlunni.php - requeryDettaglio - postData a 02det_IMieiAlunni.php");
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "02det_IMieiAlunni.php",
			data: postData,
			dataType: 'html',
			success: function(html){

				//************* PREPARAZIONE PER QUALE PAGINA MOSTRARE ALLA FINE **************/
				//AssenzeShown contiene il valore block oppure none a seconda che le assenze siano mostrate oppure nascoste
				//oppure undefined se tutte le tabs sono ancora nascoste
				var AssenzeShown = $( "#liTabAssenze" ).css( "display");
				if (activeTab == undefined) {
					//al primo click activeTab è undefined: quando si arriva sulla pagina per la prima volta
					//in quel caso anche AssenzeShown è undefined
					//se è quel caso oppure se le Assenze sono nascoste allora mostriamo i dati anagrafici
					if (AssenzeShown == undefined || shown == 'none') {
						tabToShow = "#DatiAnagrafici";
					} else {
						//altrimenti mostriamo/selezioniamo la tab Assenze
						tabToShow = "#Assenze";
					}
				} else {
					//se invece già si è attivato un tab, su quello è bene restare
					tabToShow = activeTab;
				}

				//**************** PUBBLICAZIONE DEL DETTAGLIO DELL'ALUNNO ********************/

				$("#alunnodettaglio").html(html);


				//**************** SVELAMENTO/NASCONDIMENTO TAB QUADRIMESTRI ******************/
				let tipopagellaEL_hidden = $('#tipopagellaEL_hidden').val();
				let tipopagellaME_hidden = $('#tipopagellaME_hidden').val();
				let aselme_cla_hidden = $('#aselme_cla_hidden').val();
				// console.log ("tipopagellaEL : "+tipopagellaEL_hidden);
				// console.log ("tipopagellaME : "+tipopagellaME_hidden);
				// console.log ("aselme_cla : "+aselme_cla_hidden);
				// console.log ("-----");

				//vado  scrivere in pagtoshow il valore della pagina da mostrare
				let pagtoshow = $("#pagtoshow_hidden");
				pagtoshow.val(tabToShow);
				//e vado a mostrarla
				$("#TabsSchedaIMieiAlunni a[href='"+pagtoshow+"']").tab('show');


			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02qry_AssenzeRegistro ##fname##'");      
			}
		});
	}
</script>