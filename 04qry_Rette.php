<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");

	$metodoPagA = ["idle", "C", "B", "CC"];

	$ckDVal = $_POST['ckDVal'];
	$ckCVal = $_POST['ckCVal'];
	$ckPVal = $_POST['ckPVal'];
	$ckPDVal = $_POST['ckPDVal'];
	$numPag = $_POST['numPag']-1;
	if ($ckDVal == "true") {$ckDValN = 1;} else {$ckDValN = 0; }
	if ($ckCVal == "true") {$ckCValN = 1;} else {$ckCValN = 0; }
	if ($ckPVal == "true") {$ckPValN = 1;} else {$ckPValN = 0; }
	if ($ckPDVal == "true") {$ckPDValN = 1;} else {$ckPDValN = 0; }
	//$totvaloridamostrare = $ckDValN+$ckCValN + 2*$ckPValN;
	$totvaloridamostrare = $ckDValN+$ckCValN + $ckPValN + $ckPDValN;
	switch ($totvaloridamostrare) {
		case 4:
			$righeperPagina = 5;
			break;
		case 3:
			$righeperPagina = 7;
			break;
		case 2:
			$righeperPagina = 11;
			break;
		case 1:
			$righeperPagina = 18;
			break;
		default:
			$righeperPagina = 15;
	}


	//costruisco la clasuola ORDER BY sulla base di tutti i valori di ord 
	if (isset ($_POST['ord1'])){
		$ord1 = $_POST['ord1'];
		$ordsql = orderbysql( $ord1, 'nome_alu', $ordsql);
	} 
	if (isset ($_POST['ord2'])){
		$ord2 = $_POST['ord2'];
		$ordsql = orderbysql( $ord2, 'cognome_alu', $ordsql);
	} 
	if (isset ($_POST['ord3'])){
		$ord3 = $_POST['ord3'];
		$ordsql = orderbysql( $ord3, 'classe_cla', $ordsql);
	} 
	if (isset ($_POST['ord4'])){
			$ord4 = $_POST['ord4'];
			$ordsql = orderbysql( $ord4, 'sezione_cla', $ordsql);
	} 
	
	function orderbysql ($ord, $campo, $ordsq) {
		switch ($ord) {
			case '--' :
				break;
			case 'az' :
				$ordsq = $ordsq . ' , '. $campo. ' '. 'ASC ' ;
				break;
			case 'za':
				$ordsq = $ordsq . ' , '. $campo. ' '. 'DESC ' ;
				break;
		}
		return $ordsq;
	}
	
	if ($ordsql == '') {
		$ordsql =  ' ord_cls ASC, sezione_cla ASC, cognome_alu ASC, ';
	} else {
		$ordsql = ' ' .  substr($ordsql, 2) . ", ";
	}
	
	/* costruisco la clausola FILTER BY sulla base di tutti i valori di fil */
	if (isset ($_POST['fil1'])){
		$fil1 = addslashes($_POST['fil1']);
		$filsql = filterbysqlexplode( $fil1, 'nome_alu', $filsql);
	} 
	if (isset ($_POST['fil2'])){
		$fil2 = addslashes($_POST['fil2']);
		$filsql = filterbysqlexplode( $fil2, 'cognome_alu', $filsql);
	} 
	if (isset ($_POST['fil3'])){
		$fil3 = addslashes($_POST['fil3']);
		$filsql = filterbysqlexplode( $fil3, 'classe_cla', $filsql);
	}
	if (isset ($_POST['fil4'])){
		$fil4 = addslashes($_POST['fil4']);
		$filsql = filterbysqlexplode( $fil4, 'sezione_cla', $filsql);
	} 



	$whereannocorrente = "WHERE annoscolastico_ret = '".$_POST['annoscolastico']."'";
	
	function filterbysqlexplode ($fil, $campo, $filsq) {
		//in questa funzione ricevo l'intera stringa
		//per prima cosa individuo se c'è l'uguale come primo carattere perchè le chiamate
		//a filterbysql avverranno come = o come LIKE a seconda
		if ($fil == '') {
			return $filsq;
		}

		if (substr($fil,0,1) == '=') {
			$parametro = "=";
			$fil = substr($fil, 1); //tolgo da $fil l'uguale in questo caso, tanto quello l'ho già registrato come parametro
		} else {
			$parametro = "LIKE";
		}
		//a questo punto divido la stringa in base alle virgole eventualmente presenti
		//e passo ciascuna substring a filterbysql con il parametro predeterminato

		$fil_arr = explode (",", $fil); 
		foreach($fil_arr as $elemento_tra_virgole) {
			$filsqV = filterbysql( $elemento_tra_virgole, $campo, $filsqV, $parametro);
		}
		$filsq =  $filsq." AND ( ". substr($filsqV, 4). ") ";
		return $filsq;
	}


	function filterbysql ($elemento_tra_virgole, $campo, $filsq, $parametro) {
		//parametro può essere = o LIKE
		//elemento_tra_virgole è ormai eventualmente depurato dell'uguale iniziale (se presente)
		if ($parametro == "=") {
			$filsq = $filsq . " OR ". $campo. " = '". $elemento_tra_virgole ."' ";
		} else {
			$filsq = $filsq . " OR ". $campo. " LIKE '%". $elemento_tra_virgole ."%' ";
		}
		return $filsq;
	}

	
	$listaattesa = $_POST['listaattesa'];
	if ($listaattesa != "All") {
		$wherelistaattesa = " AND listaattesa_cla = ".$listaattesa." ";
	} else {
		$wherelistaattesa = " ";
	}
	
	// CON QUESTA NUOVA SQL INTRODUCO ANCHE UNA SELECT DELLE RETTE PAGATE, IL CUI TOTALE PESCO DALLA TABELLA pagamenti.
	// QUELLA SOTTOSTANTE INVECE ESTRAEVA pagato_ret DALLA TABELLA tab_mensilirette DOVE VADO IN EFFETTI A SCRIVERE IL TOTALE OGNI VOLTA CHE SALVO
	// ERA SUCCESSO IN TRE CASI (FORIN, MAURI E ZOE VIOLA) CHE IL SALVATAGGIO NON AVESSE SALVATO IL TOTALE E QUINDI POI NON VENIVA ESTRATTO A DOVERE
	// DA QUI LA NECESSITA' DI PESCARE DIRETTAMENTE DALLA TABELLA tab_pagamenti... 
	$sql = "SELECT ID_ret, ID_alu_ret, nome_alu, cognome_alu, annoscolastico_ret, classe_cla, sezione_cla, mese_ret, default_ret, concordato_ret, TotPagatoRette, datapagato_ret, TotPagato, ord_mese, ord_cls, flag_invio_dati, metodopag_ret 
	FROM tab_mensilirette LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_ret
	LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_ret = annoscolastico_cla 
	
	LEFT JOIN (SELECT ID_alu_pag, annoscolastico_pag , SUM(importo_pag) as TotPagato FROM tab_pagamenti WHERE causale_pag <> 1 GROUP BY ID_alu_pag, annoscolastico_pag) AS altripag ON altripag.ID_alu_pag = ID_alu AND altripag.annoscolastico_pag = annoscolastico_ret

	LEFT JOIN (SELECT ID_alu_pag, ID_ret_pag, annoscolastico_pag , SUM(importo_pag) as TotPagatoRette FROM tab_pagamenti WHERE causale_pag = 1 GROUP BY ID_ret_pag, ID_alu_pag, annoscolastico_pag) AS rettepag ON rettepag.ID_alu_pag = ID_alu AND rettepag.annoscolastico_pag = annoscolastico_ret AND rettepag.ID_ret_pag = ID_ret
	
	LEFT JOIN tab_classi ON classe_cla = classe_cls ".$whereannocorrente.$wherelistaattesa.$filsql." 
	ORDER BY ".$ordsql." ID_alu_ret, annoscolastico_ret ASC, ord_mese ;";

	// $sql = "SELECT ID_ret, ID_alu_ret, nome_alu, cognome_alu, annoscolastico_ret, classe_cla, sezione_cla, mese_ret, default_ret, concordato_ret, pagato_ret, datapagato_ret, TotPagato, ord_mese, ord_cls, flag_invio_dati, metodopag_ret 
	// FROM tab_mensilirette LEFT JOIN tab_anagraficaalunni ON ID_alu = ID_alu_ret
	// LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_ret = annoscolastico_cla 
	// LEFT JOIN (SELECT ID_alu_pag, annoscolastico_pag , SUM(importo_pag) as TotPagato FROM tab_pagamenti WHERE causale_pag <> 1 GROUP BY ID_alu_pag, annoscolastico_pag) AS altripag ON altripag.ID_alu_pag = ID_alu AND altripag.annoscolastico_pag = annoscolastico_ret
	// LEFT JOIN tab_classi ON classe_cla = classe_cls ".$whereannocorrente.$wherelistaattesa.$filsql." 
	// ORDER BY ".$ordsql." ID_alu_ret, annoscolastico_ret ASC, ord_mese ;";

?>
<!-- <tr style="border-bottom: 1px grey solid;">
				<td>
					test in corso
				</td>
				<td colspan="9">
					<?//=$sql?>
				</td>
</tr> -->
<?


	
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ret, $ID_alu_ret, $nome_alu, $cognome_alu, $annoscolastico_ret, $classe_cla, $sezione_cla, $mese_ret, $default_ret, $concordato_ret, $pagato_ret, $datapagato_ret, $pagato_pga, $ord_mese, $ord_cls, $flag_invio_dati, $metodopag_ret); 
	$riga = 0;//riga equivale al numero del record che si sta guardando della tabella rette
	$j = 0; //j è un numero che cresce di una unità ogni volta che scrivo un alunno.
	while (mysqli_stmt_fetch($stmt)) {
		$riga++;
		if ($datapagato_ret=="0000-00-00" || $datapagato_ret=="1900-01-01" || $datapagato_ret == NULL ) {
			$datapagato = "";
		} else {
			$gg = date('d',strtotime($datapagato_ret));
			$mm = date('m',strtotime($datapagato_ret));
			$yy = date('y', strtotime($datapagato_ret));
			$datapagato = $gg."/".$mm."/".$yy;
		}
		
		
		// if ($datapagato_pga=="0000-00-00"|| $datapagato_pga=="1900-01-01" || $datapagato_pga == NULL) {
		// 	$datapagatoI = "";
		// } else {
		// 	$gg = date('d',strtotime($datapagato_pga));
		// 	$mm = date('m',strtotime($datapagato_pga));
		// 	$yy = date('y', strtotime($datapagato_pga));
		// 	$datapagatoI = $gg."/".$mm."/".$yy;
		// }
		
		
		
		
		if (($riga >($numPag*12*$righeperPagina)) && ($riga<=(($numPag+1)*12*$righeperPagina))) {
			if (fmod($riga-1, 12)==0) {
				//azzero i totali di riga
				//apre la riga ogni 12 record
				$TOTD = 0;
				$TOTC = 0;
				$TOTP = 0;
				$j = $j+1;
				?>
				<tr style="border-bottom: 1px grey solid;">
					<!--mostra i primi valori (nome, cognome, sezione, classe) ogni 12 record-->
					<td>
						<?//=$ID_alu_ret?>
						<button  onclick="postToSchedaAlunno(<?=$ID_alu_ret?>, '<?=$nome_alu?>', '<?=$cognome_alu?>');">
							<img style="width: 16px; cursor: pointer" src='assets/img/Icone/search-plus-solid.svg'>
						</button>
						<?= ($riga-1)/12 + 1 ?>
					</td>
					<td>
						<input class="tablecell5 disab" type="text" name="nome_alu_det" value = "<?=$nome_alu?>" disabled>
					</td>
					<td>
						<input class="tablecell5 disab" type="text" name="cognome_alu_det" value = "<?=$cognome_alu?>" disabled>
					</td>
		
					<td>
						<input class="tablecell5 disab" type="text" value = "<?=$classe_cla?>" disabled>
					</td>
					<td>
						<input class="tablecell5 disab" type="text" value = "<?=$sezione_cla?>" disabled>
					</td>
					<td>
						<div class="Rdefault" style="margin-top: 7px; font-size: 10px;">
							<span title="Quote Default" <? if ($ckDVal=='false') {echo("style='display:none;'");}?>>Default</span>
						</div>
						<div class="Rconcordato" style="margin-top: 7px; ; font-size: 10px;">
							<span title="Quote Concordate" <? if ($ckCVal=='false') {echo("style='display:none;'");}?>>Concordato</span>
						</div>
						<div class="Rpagato" style="margin-top: 7px; ; font-size: 10px;">
							<span title="Quote Pagate" <? if ($ckPVal=='false') {echo("style='display:none;'");}?>>Pagato</span>
						</div>
						<div class="RDpagato" style="margin-top: 7px; ; font-size: 10px;">
							<span title="Data Pagato" <? if ($ckPDVal=='false') {echo("style='display:none;'");}?>>Data Pag</span>
						</div>
					</td>

					<td>
						<div>
							<input autocomplete="false" name="hidden" type="text" style="display:none;">
							<button style="width: 20px; padding: 0px;" data-toggle="modal" onclick="calcolaQuotePerModal(<?=$ID_alu_ret?>);">
							<img title="Calcola Quote..." style="width: 15px; cursor: pointer;" src='assets/img/Icone/magic-solid.svg'>
							</button>
							<!-- <button style="width: 20px; padding: 0px;" id="buttonsave<?//=$ID_alu_ret?>"onclick="salva(<?//=$ID_alu_ret?>);"> -->
							<!-- <img id="imgsave<?//=$ID_alu_ret?>" style="width: 18px; cursor: pointer;" src='assets/img/Icone/save-regular-grey.svg'> -->
						</div>
					</td>
					<td>
						<div class="Rdefault">
							<input class="tablecell2 seModColora"  type="text" style="visibility: hidden; <? if ($ckDVal=='false') {echo("display:none;");}?>" >
						</div>
						<div class="Rconcordato">
							<input class="tablecell2 seModColora"  type="text" style="visibility: hidden; <? if ($ckCVal=='false') {echo("display:none;");}?>" >
						</div>
						<div class="Rpagato">
							<!-- class="tablecell2 seModColora" -->
							<input 
							class="tablecell2"
							name = "<? echo($mese_ret.'I') ?>" 
							id="<? echo($annoscolastico_ret.'I'.$ID_alu_ret) ?>" 
							type="text" 
							value = "<? if(fmod($pagato_pga, 1) !== 0.00){echo($pagato_pga);} else { echo(intval($pagato_pga)); } ?>" <? if ($ckPVal=='false') {echo("style='display:none;'");}?>
							onclick="showModalPagamenti('altro', 0, <?=$ID_alu_ret?>, <?=$annoscolastico_ret?>)"
							>
						</div>
						<!-- <div class="RDpagato">
							<input 
							class="datepicker tablecell2 seModColora dpd" 
							id = "<?// echo($annoscolastico_ret."a".$ID_alu_ret); ?>" 
							type="text" 
							value = "<?// echo($datapagatoI); ?>" style=" font-size: 10px; <?// if ($ckPDVal=='false') {echo("display:none;");}?>" 
							onchange="validateDate('<?// echo($annoscolastico_ret."a".$ID_alu_ret); ?>');">
						</div> -->
					</td>
			<? } ?>
					<!-- mostra i valori delle rette per OGNI record della tabella rette-->
					<td>
						<div class="Rdefault">
							<!-- era class="tablecell2 seModColora" -->
							<input
							class="tablecell2"
							type="text"
							id="<? echo($mese_ret.'D'.$ID_alu_ret) ?>"
							name = "<? echo($mese_ret.'D') ?>"
							value = "<? if(fmod($default_ret, 1) !== 0.00){echo($default_ret);} else { echo(intval($default_ret)); } ?>" 
							<? if ($ckDVal=='false') {echo("style='display:none;'");}?> 
							onchange= "salvaRetta(<?=$ID_ret?> , '<?echo($mese_ret.'D'.$ID_alu_ret)?>', 'D', <?=$mese_ret?>, <?=$ID_alu_ret?>)"
							>
						</div>
						<div class="Rconcordato">
							<!-- era class="tablecell2 seModColora" -->
							<input 
							class="tablecell2 <?if ($concordato_ret<$default_ret) { echo ('warnconcordato');} ?>" 
							name = "<? echo($mese_ret.'C') ?>" 
							id="<? echo($mese_ret.'C'.$ID_alu_ret) ?>" 
							type="text" 
							value = "<? if(fmod($concordato_ret, 1) !== 0.00){echo($concordato_ret);} else { echo(intval($concordato_ret)); } ?>" 
							<? if ($ckCVal=='false') {echo("style='display:none;'");}?> 
							onchange= "salvaRetta(<?=$ID_ret?> , '<?echo($mese_ret.'C'.$ID_alu_ret)?>', 'C', <?=$mese_ret?>, <?=$ID_alu_ret?>)"
							>
						</div>
						<div class="Rpagato" style="position:relative">
							<input
							class="tablecell2 <?if ($pagato_ret<$concordato_ret) { echo ('warnpagato');} ?>" 
							type="text" 
							id="<? echo($mese_ret.'P'.$ID_alu_ret) ?>" 
							name = "<? echo($mese_ret.'P') ?>" 
							value = "<? if(fmod($pagato_ret, 1) !== 0.00){echo($pagato_ret);} else { echo(intval($pagato_ret)); } ?>" 
							<? if ($ckPVal=='false') {echo("style='display:none;'");}?>
							onclick="showModalPagamenti('rette', <?=$ID_ret?>, <?=$ID_alu_ret?>);"
							readonly >
							<!-- onchange="InsertDateP(<?//=$ID_alu_ret?>, <?//=$mese_ret?>);" -->
							<?
							// vecchio flag per invio dati
									//if ($_SESSION['inviodatirette_altrisistemi'] == 1) {?>
										<!-- <input class="ckInvioDatiRette" id = "ckInvioDatiRette_<?//=$ID_ret?>" type="checkbox" onclick='flagInvioDati(<?//=$ID_ret?>);' <?// if ($flag_invio_dati == 1) { echo ('checked');} ?>>
										<?//if ($flag_invio_dati == 1){?>
											<span class="metodoPagLbl" style="position: absolute; left: 16px; font-size: 7px; z-index: 1000"><?//=$metodoPagA[$metodopag_ret]?></span>
										<?//}?> -->
									<?//}?>
						</div>
						<!-- <div class="RDpagato" >
							<input 
							class="datepicker tablecell2 <?//if ($pagato_ret<$concordato_ret) { echo ('warnpagato');} ?> seModColora dpd" 
							type="text"  
							id = "<?// echo($mese_ret."a".$ID_alu_ret); ?>" 
							name="<?// echo($mese_ret.'Date') ?>" 
							value = "<?//=$datapagato?>" 
							style=" font-size: 10px; <?// if ($ckPDVal=='false') {echo("display:none;");}?>"  
							onchange="validateDate('<?// echo($mese_ret."a".$ID_alu_ret); ?>');">
							
						</div> -->
						<?
						$TOTD =  $TOTD + floatval($default_ret);
						$TOTC =  $TOTC + floatval($concordato_ret);
						$TOTP =  $TOTP + floatval($pagato_ret);
						?>
					</td>
					<?
					//mostra i totali e chiude la riga ogni 12 escluso il primo - che vale 0 (per quello +$j)
					if ($riga==(($j+$numPag*$righeperPagina)*12)) {?>
					<td>
					</td>
					<td>
						<!--ora mostro i totali di riga-->
						<div class="Rdefault" style="text-align: center !important;">
							<input class="tablecell4" type="text" value = "<? if(fmod($TOTD, 1) !== 0.00){echo($TOTD);} else { echo(intval($TOTD)); } ?>" <? if ($ckDVal=='false') {echo("style='display:none;'");}?> >
						</div>
						<div class="Rconcordato" style="text-align: center;">
							<input class="tablecell4 <?if ($TOTC<$TOTD) { echo ('warnconcordato');} ?>" type="text" value = "<? if(fmod($TOTC, 1) !== 0.00){echo($TOTC);} else { echo(intval($TOTC)); } ?>" <? if ($ckCVal=='false') {echo("style='display:none;'");}?>>
						</div>
						<div class="Rpagato" style="text-align: center;">
							<input class="tablecell4 <?if ($TOTP<$TOTC) { echo ('warnpagato');} ?>" type="text" value = "<? if(fmod($TOTP, 1) !== 0.00){echo($TOTP);} else { echo(intval($TOTP)); } ?>" <? if ($ckPVal=='false') {echo("style='display:none;'");}?>>
						</div>
						<div class="RDpagato" style="text-align: center;">
							<input class="tablecell4" type="text"  <? if ($ckPDVal=='false') {echo("style='display:none;'");} else {echo("style='visibility: hidden;'");}?> >
						</div>
					</td>
				</tr>
			<?} //fine if per mostrare la fine riga ogni 12 escluso il primo ?>
		<?} //fine if per mostrare i record della pagina corrente e basta ?>
	<?} //fine while?>
	<tr>
		<td>
			<input id="contarecord_hidden" 		value = "<?=($riga/12) ?>" 					hidden>
		</td>
		<td>
			<input id="recordperpagina_hidden" 	value = "<?=$righeperPagina?>" 				hidden>
		</td>
		<td>
			<input id="where_hidden" 			value = "<?=$wherelistaattesa.$filsql?>" 	hidden>
		</td>
		$whereannocorrente.$wherelistaattesa.$filsql
	</tr>
<script>

	$(function () {
		moment.locale('en', {
          week: { dow: 1 }
        });
		
		//$('.bootstrap-datetimepicker-widget').remove();

		$('.dpd').datetimepicker({
			pickTime: false, 
			format: "DD/MM/YYYY",
            weekStart: 1
		});

		//$('.seModColora').change(function () {
			//questa funzione, se attivata fa sì che alla modifica degli elementi della classe seModColora
			//il pulsante Save si colori in modo che l'utente sia indotto a premerlo...
			// let idDaColorare = ($(this).attr('id'));
			// //devo estrarre dall' id ID_alu_ret
			// chrfrom = 0; 
			// if (idDaColorare.includes("D")) {chrfrom = idDaColorare.indexOf("D");}
			// if (idDaColorare.includes("C")) {chrfrom = idDaColorare.indexOf("C");}
			// if (idDaColorare.includes("P")) {chrfrom = idDaColorare.indexOf("P");}
			// if (idDaColorare.includes("a")) {chrfrom = idDaColorare.indexOf("a");}
			// id = idDaColorare.substr(-(idDaColorare.length - chrfrom - 1));
			// coloraSave (id);
		//});
		
	});
	
	function coloraSave(id_alu_ret) {
		//$("#imgsave"+id_alu_ret).css('color', 'red');
		$("#imgsave"+id_alu_ret).attr("src", "assets/img/Icone/save-regular-red.svg");
	}
	
	//Funzione per validare se la data inserita è corretta (infatti il campo è editabile)
	//se non corretta il campo viene cancellato
	function validateDate(indice) {
		datadavalidare = $("#"+indice).val();
		if (isValidDate(datadavalidare)) {
			//console.log ("04qry_Rette.php - validateDate");
			//console.log("data valida");
		} else {
			$("#"+indice).val("");
			//console.log("data non valida");
		}
	}
 
 
	function isValidDate(dateString) {
        if(!/^\d{1,2}\/\d{1,2}\/\d{2}$/.test(dateString)){
        //if(!/^\d{1,2}\/\d{1,2}/.test(dateString)){ //serviva nel caso di data DD/MM
            return false;
        }
        // Parse the date parts to integers
        let parts = dateString.split("/");
        let day = parseInt(parts[0], 10);
        let month = parseInt(parts[1], 10);
        //let currentTime = new Date(); serviva nel caso di data DD/MM
        let year = parseInt(parts[2], 10);
        //let year = currentTime.getFullYear(); serviva nel caso di data DD/MM
        // Check the ranges of month and year
        if(month == 0 || month > 12){
            //console.log ("mese non valido");
            return false;
        }
        let monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];
        // Adjust for leap years
        if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
            monthLength[1] = 29;
        // Check the range of the day
        return (day > 0) && (day <= monthLength[month - 1]);
	}
	
	function InsertDateP(ID_alu_ret, mese_ret) {
		QuotaPMese = $("#"+mese_ret+"P"+ID_alu_ret).val();
		if (QuotaPMese == 0 || QuotaPMese == "" || isNaN(QuotaPMese)) {
			$("#"+mese_ret+"P"+ID_alu_ret).val(0);
		} else {
			//console.log ("date"+ID_alu_ret+"a"+mese_ret);
			DataQuotaPMese  = $("#"+mese_ret+"a"+ID_alu_ret).val();
			//console.log ("DataQuotaPMese"+DataQuotaPMese);
			if (DataQuotaPMese == "") {
				let currentTime = new Date();
				//let year = currentTime.getFullYear();
				let month = str_pad(currentTime.getMonth()+1);
				let day = str_pad(currentTime.getDate());
                let year = currentTime.getFullYear();
                year = year.toString().substr(-2);
                
				//console.log (day+"/"+month);
				//$("#"+mese_ret+"a"+ID_alu_ret).val(day+"/"+month); //serviva nel caso di data DD/MM
                $("#"+mese_ret+"a"+ID_alu_ret).val(day+"/"+month+"/"+year);
			}
		}
	}
	
	function str_pad(n) {
    return String("00" + n).slice(-2);
	}
	
	function postToAnagrafica(nome, cognome) {
		
		let form = $(document.createElement('form'));
		$(form).attr("action", "00Anagrafica.php");
		$(form).attr("method", "POST");
		$(form).css("display", "none");
	
		let input_nomealu = $("<input>")
		.attr("type", "text")
		.attr("name", "nomealunnoDaAltraPag")
		.val(nome);
		$(form).append($(input_nomealu));
		
		let input_cognomealu = $("<input>")
		.attr("type", "text")
		.attr("name", "cognomealunnoDaAltraPag")
		.val(cognome);
		$(form).append($(input_cognomealu));
		
		form.appendTo( document.body );
		$(form).submit();
	}
	
	function postToSchedaAlunno(ID, nome, cognome) {
		
		let form = $(document.createElement('form'));
		$(form).attr("action", "06SchedaAlunno.php");
		$(form).attr("method", "POST");
		$(form).css("display", "none");
	
		let input_IDalu = $("<input>")
		.attr("type", "text")
		.attr("name", "ID_aluDaAltraPag")
		.val(ID);
		$(form).append($(input_IDalu));
		
		let input_nomealu = $("<input>")
		.attr("type", "text")
		.attr("name", "nome_aluDaAltraPag")
		.val(nome);
		$(form).append($(input_nomealu));
		
		let input_cognomealu = $("<input>")
		.attr("type", "text")
		.attr("name", "cognome_aluDaAltraPag")
		.val(cognome);
		$(form).append($(input_cognomealu));
		
		form.appendTo( document.body );
		$(form).submit();
		
	}
	
	
	function calcolaQuotePerModal (ID_alu) {

		//deve applicare le checkbox come da default
		let seqMesiDefault = $("#seqMesiDefault").val();  //stringa di 12 0 o 1 che indica come ripartire le quote per default
		for (i = 1; i <= 12; i++) {
			if (seqMesiDefault.substr(i-1, 1) == 1 ) {
				$('#meseRipartizioneSingolo'+i).prop('checked', true);
			} else {
				$('#meseRipartizioneSingolo'+i).prop('checked', false);
			}
		}

		let annoscolastico_ret = $("#selectannoscolastico").val();
		let quote_fratelli_diverse = $("#quote_fratelli_diverse").val();
		//posta ID_alu a 04_getfratellieQuote per poi passare l'html a id=calcolo
		postData = { ID_alu : ID_alu, annoscolastico_ret : annoscolastico_ret, quote_fratelli_diverse : quote_fratelli_diverse};
		console.log ("04qry_Rette.php - CalcolaQuotePerModal: questo passo a 04qry_getFratellieQuote.php");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "04qry_getFratellieQuote.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log("maggiore "+data.maggiore);
				console.log("gemelli "+data.gemelli);
				console.log("datanascita_alu "+data.datanascita_alu);
				console.log("ultimadatanascita_fratello "+data.datanascita_fratello);
				console.log("fratelli "+data.numfratelli);
				console.log("test "+data.test);
				//$("#test").val(data.test);
				$("#NumeroFratelli").val(data.numfratelli);
				$("#Classe").val(data.classe_cla);
				$("#QuotaAnno").val(data.quotacalcolata);
				$("#QuotaConcordata").val(data.quotacalcolata);

				RicalcolaRateMensili();

				$("#ID_alu_hidden").val(ID_alu);
				$("#NomeCognomeAlu").html(data.nome_alu+' '+data.cognome_alu);
				$("#ResponsoFratelli").html(data.responso);
				$('#modalMostraQuoteCalcolate').modal('show');
				//console.log (data.nome_alu+' '+data.cognome_alu);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '04qry_Rette ##fname##'");      
			}
			
		});
	}
	

	$('.ckMeseSingolo').click ( function(event){
		//con questa routine impedisco che si possano uncheckare tutte le checkbox
		stoppa = 1;
		for (i = 1; i <= 12; i++) {
			if ($('#meseRipartizioneSingolo'+i).prop('checked')) {stoppa = 0}
		}

		if (stoppa == 1) {
			var $checkbox = $(this);
			$checkbox.prop('checked', true)
		} else {
			RicalcolaRateMensili(); //se ce n'è almeno uno di checked allora vado al ricalcolo
		}
	});


	function RicalcolaRateMensili(){

		QuotaAnno = $("#QuotaAnno").val();
		QuotaConcordata = $("#QuotaConcordata").val();

		//vado a vedere contare sono i mesi checked per calcolare la rata mensile arrotondata di base
		seqMesi ="";
		for (i = 1; i <= 12; i++) {
			if (!$('#meseRipartizioneSingolo'+i).prop('checked')) {seqMesi=seqMesi+"0";} else {seqMesi=seqMesi+"1";}
		}
		let meseSiNo = [];
		mesiTot = 0;
		for (i = 1; i <= 12; i++) {
			meseSiNo[i] = seqMesi.substr(i-1, 1)
			mesiTot = mesiTot + parseInt(meseSiNo[i]);
		}

		$("#QuotaMese").val(Math.floor(QuotaAnno/mesiTot));
		$("#QuotaMeseConcordata").val(Math.floor(QuotaConcordata/mesiTot));	
	}
	
	function ApplicaRateCalcolate() {
		//(meseDID_alu)
		//treratetrimestrali_ck = $('#treratetrimestrali_ck').prop('checked'); //true se selezionato
		//Rate = $("#Rate").val();
		//QuotaMese = $("#QuotaMese").val();
		//QuotaMeseConcordata = $("#QuotaMeseConcordata").val();

		ID_alu = 			$("#ID_alu_hidden").val();
		QuotaDefault = 		$("#QuotaAnno").val();
		QuotaConcordata = 	$("#QuotaConcordata").val();

		//costruisco seqMesi, una stringa sulla base delle selezioni eseguite sulle 12 checkbox
		seqMesi = "";
		for (i = 1; i <= 12; i++) {
			if (!$('#meseRipartizioneSingolo'+i).prop('checked')) {seqMesi=seqMesi+"0";} else {seqMesi=seqMesi+"1";}
		}
		
		//costruisco anche un array meseSiNo sulla stessa base e calcolo quanti sono i mesi selezionati
		let meseSiNo = [];
		mesiTot = 0;
		for (i = 1; i <= 12; i++) {
			meseSiNo[i] = seqMesi.substr(i-1, 1)
			mesiTot = mesiTot + parseInt(meseSiNo[i]);
		}

		//calcolo la prima quota in modo da sistemare gli arrotondamenti
		quotaarrotC = Math.floor(QuotaConcordata/mesiTot); //la quota da inserire nei mesi indicati con 1 in seqMesiDefault
		primaquotaC = quotaarrotC + (QuotaConcordata - quotaarrotC * mesiTot); //la prima quota deve essere così per non arrotondare il totale

		quotaarrotD = Math.floor(QuotaDefault/mesiTot); //la quota da inserire nei mesi indicati con 1 in seqMesiDefault
		primaquotaD = quotaarrotD + (QuotaDefault - quotaarrotD * mesiTot); //la prima quota deve essere così per non arrotondare il totale

		let mesi = ["idle", 9, 10, 11, 12, 1, 2, 3, 4, 5, 6, 7, 8];
		let postData3 = [];
		primaquotaCk = 1;


		for (i = 9; i <= 12; i++) {
			
			if (primaquotaCk == 1) {
				quotameseC = primaquotaC * meseSiNo[i];
				quotameseD = primaquotaD * meseSiNo[i];
			} else {
				quotameseC = quotaarrotC * meseSiNo[i]
				quotameseD = quotaarrotD * meseSiNo[i];
			}

			if (meseSiNo[i] == "1" ) {primaquotaCk = 0;}
			if (!$("#ckConcordataNo").is(":checked")) { $("#"+i+'C'+ID_alu).val(quotameseC);} //va applicata solo se non è selezionata la ckbox
			$("#"+i+'D'+ID_alu).val(quotameseD); //impostazione rate di default
		}

		for (i = 1; i <= 8; i++) {
			
			if (primaquotaCk == 1) {
				quotameseC = primaquotaC * meseSiNo[i];
				quotameseD = primaquotaD * meseSiNo[i];
			} else {
				quotameseC = quotaarrotC * meseSiNo[i]
				quotameseD = quotaarrotD * meseSiNo[i];
			}

			if (meseSiNo[i] == "1" ) {primaquotaCk = 0;}
			if (!$("#ckConcordataNo").is(":checked")) { $("#"+i+'C'+ID_alu).val(quotameseC);} //va applicata solo se non è selezionata la ckbox
			$("#"+i+'D'+ID_alu).val(quotameseD); //impostazione rate di default
		}



									// let mesi = [9, 10, 11, 12, 1, 2, 3, 4, 5, 6, 7, 8];
									

									// for (j = 0; j < 12; j++) { //metto gli zeri che mancano per completare l'anno
									// 	console.log (mesi[j]+'D'+ID_alu+"---"+QuotaMese);
									// 	console.log (mesi[j]+'C'+ID_alu+"---"+QuotaMeseConcordata);
									// 	$("#"+mesi[j]+'D'+ID_alu).val(0); //impostazione rate di default
									// 	if ($("#ckConcordataNo").is(":checked")) {} else { $("#"+mesi[j]+'C'+ID_alu).val(0);} //va applicata solo se non è selezionata la ckbox
									// }

									// if (treratetrimestrali_ck) { 
									// 	$("#10D"+ID_alu).val(QuotaMese); //impostazione rate di default
									// 	$("#1D"+ID_alu).val(QuotaMese); //impostazione rate di default
									// 	$("#4D"+ID_alu).val(QuotaMese); //impostazione rate di default
									// 	if ($("#ckConcordataNo").is(":checked")) {} else { 
									// 		$("#10C"+ID_alu).val(QuotaMeseConcordata); 
									// 		$("#1C"+ID_alu).val(QuotaMeseConcordata); 
									// 		$("#4C"+ID_alu).val(QuotaMeseConcordata); 
									// 	} //va applicata solo se non è selezionata la ckbox
									// } else {
									// //il seguente metodo va bene solo per scrivere 'le prime n rate'. Non funziona bene per le rate trimestrali.
									// 	for (i = 0; i < (Rate); i++) {
									// 		//console.log (mesi[i]+'D'+ID_alu+"---"+QuotaMese);
									// 		//console.log (mesi[i]+'C'+ID_alu+"---"+QuotaMeseConcordata);
									// 		$("#"+mesi[i]+'D'+ID_alu).val(QuotaMese); //impostazione rate di default
									// 		if ($("#ckConcordataNo").is(":checked")) {} else { $("#"+mesi[i]+'C'+ID_alu).val(QuotaMeseConcordata); } //va applicata solo se non è selezionata la ckbox
									// 	}
									// }
		//in precedenza era così: inserivo gli zeri sulle rate che già non avevo compilato. Ora invece prima li azzero tutti e poi scrivo le rate calcolate
		//for (j = 0; i < 12; i++) { //metto gli zeri che mancano per completare l'anno
			//console.log (mesi[i]+'D'+ID_alu+"---"+QuotaMese);
			//console.log (mesi[i]+'C'+ID_alu+"---"+QuotaMeseConcordata);
		//	$("#"+mesi[i]+'D'+ID_alu).val(0); //impostazione rate di default
		//	if ($("#ckConcordataNo").is(":checked")) {} else { $("#"+mesi[i]+'C'+ID_alu).val(0);} //va applicata solo se non è selezionata la ckbox
		//}

		
		salvaRetteCalcolate(ID_alu);
		$('#modalMostraQuoteCalcolate').modal('hide');
		$("#Rate").val(10);
		$('#treratetrimestrali_ck').prop('checked', false);
		$("#ckConcordataNo").prop('checked', false);
	}
	
	function salvaRetta(ID_ret, id_DOM, tipo, mese_ret, ID_alu_ret) {

		importo = $("#"+id_DOM).val();
		postData = { ID_ret : ID_ret, importo: importo, tipo : tipo};
		console.log ("04qry_Rette.php - salvaRetta: postData a 04qry_updateQuotaSingola.php");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "04qry_updateQuotaSingola.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				//numpag = $('#numeroPagina').val();
				//requery(numpag);
				console.log ("04qry_Rette.php - salvaRetta: ritorno (test) da 04qry_updateQuotaSingola.php");
				console.log (data.test);
				checkColore(mese_ret, ID_alu_ret);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '04qry_Rette ##salvaRetta##'");      
			}
		});
	}

	function checkColore(mese_ret, ID_alu_ret) {
		//questa funzione colora opportunamente la retta concordata e quella pagata aggiungendo o togliendo la classe warnconcordato e warnpagato ai rispettivi
		Rdefault = $('#'+mese_ret+'D'+ID_alu_ret).val();
		Rconcordato = $('#'+mese_ret+'C'+ID_alu_ret).val();
		Rpagato = $('#'+mese_ret+'P'+ID_alu_ret).val();

		console.log (Rdefault, Rconcordato, Rpagato);
		if (Rconcordato < Rdefault) {
			$('#'+mese_ret+'C'+ID_alu_ret).addClass('warnconcordato');
		} else {
			$('#'+mese_ret+'C'+ID_alu_ret).removeClass('warnconcordato');
		}
		
		if (Rpagato < Rconcordato) {
			$('#'+mese_ret+'P'+ID_alu_ret).addClass('warnconcordato');
		} else {
			$('#'+mese_ret+'P'+ID_alu_ret).removeClass('warnconcordato');
		}



	};


	function salvaRetteCalcolate(ID_alu_ret){
		//questa funzione viene usata ora SOLAMENTE dall'applicazione e salvataggio di rette default e concordate
		//il salvataggio delle rette concordate e default 
		let postData = [];
		postData.push( {name: "prova", value: "prova"}  );
		let annoscolastico_ret = $("#selectannoscolastico").val();
		//let pagato_pga = $("#"+annoscolastico_ret+"I"+ID_alu_ret).val();
		//let datapagato_pga = $("#"+annoscolastico_ret+"a"+ID_alu_ret).val();
		// postData1 = { ID_alu_ret: ID_alu_ret, annoscolastico_pga : annoscolastico_ret, pagato_pga : pagato_pga, datapagato_pga: datapagato_pga};
		// console.log(postData1);
		// $.ajax({
		// 	type: 'POST',
		// 	url: "04qry_updateIscrizione.php",
		// 	data: postData1,
		// 	dataType: 'json',
		// 	success: function(data){
		// 		//console.log(data.sql);
		// 	},
		// 	error: function(){
		// 		alert("Errore: contattare l'amministratore fornendo il codice di errore '04qry_Rette ##fname##'");      
		// 	}
		// });
		//ciclo for per postare #Daluret, #Paluret e #Paluret
		
		for (i = 1; i <= 12; i++) {
			postData.push( {name: i+"D", value: $("#"+i+"D"+ID_alu_ret).val()}  );
			postData.push( {name: i+"C", value: $("#"+i+"C"+ID_alu_ret).val()}  );
			postData.push( {name: i+"P", value: $("#"+i+"P"+ID_alu_ret).val()}  );
			postData.push( {name: i+"Date", value: $("#"+i+"a"+ID_alu_ret).val()}  );
		}

		// for (i = 9; i <= 12; i++) {
		// 	postData.push( {name: i+"D", value: $("#"+i+"D"+ID_alu_ret).val()}  );
		// 	postData.push( {name: i+"C", value: $("#"+i+"C"+ID_alu_ret).val()}  );
		// 	postData.push( {name: i+"P", value: $("#"+i+"P"+ID_alu_ret).val()}  );
		// 	postData.push( {name: i+"Date", value: $("#"+i+"a"+ID_alu_ret).val()}  );
		// }

		// for (i = 1; i <= 8; i++) {
		// 	postData.push( {name: i+"D", value: $("#"+i+"D"+ID_alu_ret).val()}  );
		// 	postData.push( {name: i+"C", value: $("#"+i+"C"+ID_alu_ret).val()}  );
		// 	postData.push( {name: i+"P", value: $("#"+i+"P"+ID_alu_ret).val()}  );
		// 	postData.push( {name: i+"Date", value: $("#"+i+"a"+ID_alu_ret).val()}  );
		// }
		postData.push( {name: "ID_alu_ret", value: ID_alu_ret} );
		postData.push( {name: "annoscolastico_ret", value: annoscolastico_ret} );
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "04qry_updateQuote.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				//console.log (data.D);
				//console.log (data.sql);
				//console.log (data.dt);
				//$("#imgsave"+ID_alu_ret).css('color', '#ccc');
				$("#imgsave"+ID_alu_ret).attr("src", "assets/img/Icone/save-regular-grey.svg");
				numpag = $('#numeroPagina').val();
				requery(numpag);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '04qry_Rette ##fname##'");      
			}
		});


		
	}

	function showModalPagamenti(tipo, ID_ret, ID_alu) {
		//se si tratta di una retta allora uso ID_ret in 04qry_getPagamenti e con quello estraggo tutto (ID_alu, nome e cognome alunno ecc.)

		//se si tratta di altri pagamenti allora devo passare a 04qry_getPagamenti:
	
		//ID_alu_pag con cui mi estrarrò nome e cognome
		//anno scolastico
		annoscolastico = $("#selectannoscolastico").val();


		postData = {ID_ret: ID_ret, ID_alu: ID_alu, annoscolastico: annoscolastico};
		console.log ("04qry_Rette.php - showModalPagamenti postData a 04qry_getPagamenti.php")
        console.log (postData);

        //vado a popolare la tabella nel modal Pagamenti a patire da ID_ret
        $.ajax({
            type: 'POST',
            url: "04qry_getPagamenti.php",
            data: postData,
            dataType: 'html',
            success: function(html){
				if (ID_ret != 0) { 
					$("#titoloModalPagamenti").html('Pagamenti Retta'); 
				} else {
					$("#titoloModalPagamenti").html('Altri Pagamenti a.s. '+ annoscolastico); 
				}
                $("#TabellaPagamenti").html(html);
				$('#alertModalPagamenti').removeClass('alert-danger');
                $('#alertModalPagamenti').addClass('alert-success');
                $("#alertModalPagamenti").hide();
				$("#btn_CancelModalPagamenti").html('Annulla');
                $("#btn_OKModalPagamenti").show();
				// if (ID_ret == 0) {
				// 	$('#btn_OKModalPagamenti').attr('onClick', "salvaNuovoPagamento('retta');");
				// } else {
				// 	$('#btn_OKModalPagamenti').attr('onClick', "salvaNuovoPagamento('altropagamento');");
				// }

				$("#remove-contentModalPagamenti").show();
                $('#modalPagamenti').modal({show: 'true'});
            },
            error: function(){
                alert("Errore: contattare l'amministratore fornendo il codice di errore '04qry_Rette ShowModalPagamenti'");      
            }
        });


		
	}



</script>