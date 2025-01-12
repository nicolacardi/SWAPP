<?	include_once("database/databaseii.php");
	include_once("classi/alunni.php");

	$campodata = $_POST['campodata'];
	$annoscolastico_cla = $_POST['annoscolastico_cla'];
	//per costruire le coroncine
	$data_limite_re = $_POST['data_limite_re'];
	$primo_giorno_re = $_POST['primo_giorno_re'];
	$annorecorrente = 0;
	$annoreprossimo = 0;

	$emailtotaleA = array();
	if ($annoscolastico_cla !="all")
	{
		$annorecorrente = substr($annoscolastico_cla,0,4) - 6;
		$annoreprossimo = substr($annoscolastico_cla,0,4) - 5;
	}
	$riga =  0;?>

	<?
	
	for ($x = 1; $x <= 9; $x++) {
		$campo[$x] = $_POST['campo'][$x];
		//se il campo è del tipo tab_classialunni.classe_cla devo estrarre solo la seconda parte
		if (strpos($campo[$x], '.')) {$campo[$x] = substr($campo[$x], strrpos($campo[$x], '.') + 1);}
	}
	
	?>
	 
	<tr>
	<td>
		<?
		// for ($x = 1; $x <= 9; $x++) {
		// 	$_POST['fil'][$x] = addslashes($_POST['fil'][$x]);
		// 	$filsql = filterbysqlexplode( $_POST['fil'][$x], $_POST['campo'][$x], $filsql);
		// }
		// echo ($filsql);
			
			?>
		<?//echo(json_encode(GetAlunniPerAnno ($_POST['campo'], 9, $_POST['ord'], $_POST['fil'], $_POST['annoscolastico_cla'], $_POST['listaattesa'])))?>
		<?//echo(json_encode($_POST['fil']))?>
		<?//echo(GetAlunniPerAnno($_POST['campo'], $_POST['ord'], $_POST['fil']));?>
		<?//=$annoreprossimo;?>
	</td>
	</tr>
	<?
	/*GetAlunniPerAnno è una routine nella classe alunni
	riceve
	1. $_POST['campo'] che è un array con l'elenco dei campi che sono selezionati nelle combo
		p.e. ["","nome_alu","cognome_alu","tab_classialunni.classeprec_cla","tab_classialunni.sezione_cla","tab_classialunni.aselme_cla","indirizzo_alu","citta_alu","comunenascita_alu","datanascita_alu"]
	2. il numero dei campi (9 in qs caso)
	3. $_POST['ord'] che è un array che dice quale sia l'ordinamento 
		p.e. ["","--","--","az","--","--","--","--","--","--"]
	4. $_POST['fil'] che è un array che dice quali siano i filtri da applicare
		p.e. ["","","","","","EL","","","",""]
	5. $_POST['annoscolastico_cla']
	6. $_POST['listaattesa']
	e restituisce un array di record filtrati e ordinati in base a quelle selezioni
	
	*/
	?>
	<?foreach (GetAlunniPerAnno ($_POST['campo'], 9, $_POST['ord'], $_POST['fil'], $_POST['annoscolastico_cla'], $_POST['listaattesa']) as $alunno) {
		
		//Ora stabilisco se va mostrata la coroncina per questo record
		$recorrente = 0;
		$reprossimo = 0; 
		//if ($aselme_cla = "AS" && (($datanascita_alu >= ($annorecorrente."-06-01")) && ($datanascita_alu <= ($annorecorrente."-12-31")) )) {$recorrente = 1;}
		if ($alunno->aselme_cla == "AS" && (($alunno->datanascita_alu <= ($annorecorrente."-12-31")) )) {$recorrente = 1;}
		//if ($aselme_cla == "AS" && (($datanascita_alu >= ($annoreprossimo."-06-01")) && ($datanascita_alu <= ($annoreprossimo."-12-31")) )) {$reprossimo = 1;}
		if ($alunno->aselme_cla == "AS" && (($alunno->datanascita_alu >= ($annoreprossimo.$primo_giorno_re)) && ($alunno->datanascita_alu <= ($annoreprossimo."-12-31")) )) {$reprossimo = 1;}
		if ($alunno->listaattesa_cla == 1) { $cllistaattesa = "cllistaattesa";} else {$cllistaattesa = ""; }
		//ora solo se un indirizzo email già non fa parte dell'array emailtotaleA vado ad aggiungerlo.
		//questo array produrrà in ultima riga (invisibile) tramite una implide la scrittura di un valore
		//che poi viene dinamicamente associato a <a href="">Invia Mail</a>
		if ($alunno->emailpadre_fam!="") {if (!in_array($alunno->emailpadre_fam, $emailtotaleA)) { array_push ($emailtotaleA, $alunno->emailpadre_fam);}}
		if ($alunno->emailmadre_fam!="") {if (!in_array($alunno->emailmadre_fam, $emailtotaleA)) { array_push ($emailtotaleA, $alunno->emailmadre_fam);}}
		$alunno->datanascita_alu = timestamp_to_ggmmaaaa($alunno->datanascita_alu);
		$riga++;
	?>
	<tr>
		<td style="width:38px;">
			<button  class="<? if ($alunno->ritirato_cla ==1 ) {echo ('alunnoritirato');} elseif ($alunno->classeprec_cla == ""){echo ('alunnonuovo');} ?>"id="goto<?=$alunno->ID_alu?>" ondblclick="postToSchedaAlunno(<?=$alunno->ID_alu?>, '<?=addslashes($alunno->nome_alu)?>', '<?=addslashes($alunno->cognome_alu);?>');" onclick="coloraRighe(<?=$alunno->ID_alu?>);" style="width: 38px; font-size:12px;"><?=$riga?></button>
		</td>
		<td style="width:137px;">
			<input class="tablecell6 disab val<?=$alunno->ID_alu?> <?=$cllistaattesa?>" type="text"  id="nome_alu<?=$alunno->ID_alu?>" name="nome_alu" value = "<?=$alunno->nome_alu?>" disabled>
		</td>
		<td style="width:138px;">
			<input class="tablecell6 disab val<?=$alunno->ID_alu?> <?=$cllistaattesa?>" type="text" id="cognome_alu<?=$alunno->ID_alu?>" name="cognome_alu" value = "<?=$alunno->cognome_alu?>" disabled>
		</td>

		<td style="width:145px; position:relative;">
			<input class="tablecell6 disab val<?=$alunno->ID_alu?> <?=$cllistaattesa?>" type="text" value = "<?=$alunno->{$campo[3]}?>" disabled>
			<?if(($campodata==3)&&($recorrente ==1)) {?><img class="imgCrown" title="Anno del Re attuale" src='assets/img/Icone/crown.svg'><?}?>
			<?if(($campodata==3)&&($reprossimo ==1)) {?><img class="imgCrown" title="Anno del Re Prossimo" src='assets/img/Icone/crown2.svg'><?}?>
		</td>
		<td style="width:145px; position:relative;">
			<input class="tablecell6 disab val<?=$alunno->ID_alu?> <?=$cllistaattesa?>" type="text" value = "<?=$alunno->{$campo[4]}?>" disabled>
			<?if(($campodata==4)&&($recorrente ==1)) {?><img class="imgCrown" title="Anno del Re attuale" src='assets/img/Icone/crown.svg'><?}?>
			<?if(($campodata==4)&&($reprossimo ==1)) {?><img class="imgCrown" title="Anno del Re Prossimo" src='assets/img/Icone/crown2.svg'><?}?>
		</td>
		<td style="width:145px; position:relative;">
			<input class="tablecell6 disab val<?=$alunno->ID_alu?> <?=$cllistaattesa?>" type="text" value = "<?=$alunno->{$campo[5]}?>" disabled>
			<?if(($campodata==5)&&($recorrente ==1)) {?><img class="imgCrown" title="Anno del Re attuale" src='assets/img/Icone/crown.svg'><?}?>
			<?if(($campodata==5)&&($reprossimo ==1)) {?><img class="imgCrown" title="Anno del Re Prossimo" src='assets/img/Icone/crown2.svg'><?}?>
		</td>
		<td style="width:145px; position:relative;">
			<input class="tablecell6 disab val<?=$alunno->ID_alu?> <?=$cllistaattesa?>" type="text" value = "<?=$alunno->{$campo[6]}?>" disabled>
			<?if(($campodata==6)&&($recorrente ==1)) {?><img class="imgCrown" title="Anno del Re attuale" src='assets/img/Icone/crown.svg'><?}?>
			<?if(($campodata==6)&&($reprossimo ==1)) {?><img class="imgCrown" title="Anno del Re Prossimo" src='assets/img/Icone/crown2.svg'><?}?>
		</td>
		<td style="width:145px; position:relative;">
			<input class="tablecell6 disab val<?=$alunno->ID_alu?> <?=$cllistaattesa?>" type="text" value = "<?=$alunno->{$campo[7]}?>" disabled>
			<?if(($campodata==7)&&($recorrente ==1)) {?><img class="imgCrown" title="Anno del Re attuale" src='assets/img/Icone/crown.svg'><?}?>
			<?if(($campodata==7)&&($reprossimo ==1)) {?><img class="imgCrown" title="Anno del Re Prossimo" src='assets/img/Icone/crown2.svg'><?}?>
		</td>
		<td style="width:145px; position:relative;">
			<input class="tablecell6 disab val<?=$alunno->ID_alu?> <?=$cllistaattesa?>" type="text" value = "<?=$alunno->{$campo[8]}?>" disabled>
			<?if(($campodata==8)&&($recorrente ==1)) {?><img class="imgCrown" title="Anno del Re attuale" src='assets/img/Icone/crown.svg'><?}?>
			<?if(($campodata==8)&&($reprossimo ==1)) {?><img class="imgCrown" title="Anno del Re Prossimo" src='assets/img/Icone/crown2.svg'><?}?>
		</td>
		<td style="width:145px; position:relative;">
			<input class="tablecell6 disab val<?=$alunno->ID_alu?> <?=$cllistaattesa?>" type="text" value = "<?=$alunno->{$campo[9]}?>" disabled>
			<?if(($campodata==9)&&($recorrente ==1)) {?><img class="imgCrown" title="Anno del Re attuale" src='assets/img/Icone/crown.svg'><?}?>
			<?if(($campodata==9)&&($reprossimo ==1)) {?><img class="imgCrown" title="Anno del Re Prossimo" src='assets/img/Icone/crown2.svg'><?}?>
			<?if(($campodata==9)&&($alunno->scalino_cla ==1)) {?><img class="imgCrown" title="Scalino" src='assets/img/Icone/scalino.svg'><?}?>

		</td>
		<td>
			<input style="width: 20px;" class="tablecell6 val<?=$alunno->ID_alu?>" type="checkbox" name="<? echo(sprintf("%'.04d\n", $alunno->ID_asc)); ?><?=$alunno->annoscolastico_cla?>-ck-<? echo(sprintf("%'.04d\n", $alunno->ID_alu)); ?>-cls-<?echo(sprintf("%'.02d\n",$alunno->ord_cls));?><?=$alunno->sezione_cla?>" id="<?=$riga?>ck">
		</td>
	</tr>
	<?}?>
	<tr>
		<td>
			<input id="contarecord_hidden" 	value = "<?=$riga?>" 			hidden>
		</td>
		<td>
			<input id="sql_hidden" 			value = "<?=$alunno->where?>" 	hidden>
		</td>
		<td>
			<input id="ord_hidden" 			value = "<?=$alunno->ord?>" 	hidden>
		</td>
		<td>
			<input id="emailtotalehidden" 	value = "<?echo(implode(',', $emailtotaleA));?>" 	hidden>
			<?//=$emailtotale?>
		</td>
	</tr>

<script>
	
	$(document).ready(function(){
		let listaemails = $('#emailtotalehidden').val();
		//listaemails = listaemails.slice(1);
		listaemails = "mailto:"+listaemails;
		$("#mailtotutti").attr("href", listaemails );
		//UniformaColonne();
	});
	

	function copyEmailsToTutti() {

		var dummyContent = $('#emailtotalehidden').val();
		//creo una input e ci metto il valore della login e lo seleziono
		//console.log (dummyContent);
		var dummy = $("<input id='tmplink'>").val(dummyContent).appendTo('body').select();
		//copio il valore
		document.execCommand('copy');
		
		//elimino la input creata temporaneamente
		var element =  document.getElementById('tmplink');
		element.remove();

	}
	
	function coloraRighe(ID_alu){
		//pulisco colore delle celle di tutte le righe
		$('#tabellaAnagraficaPerAnno tr:even td .tablecell6').css('background-color', '#e0e0e0').css('color', '#474747');
		$('#tabellaAnagraficaPerAnno tr:odd td .tablecell6').css('background-color', '#fff').css('color', '#474747');
		$('.val'+ID_alu).css('background-color', '#289bce').css('color', '#fff');
	}
		
	// function UniformaColonne () {
	// 	const thElements = document.getElementsByTagName('th');
	// 	const tdElements = document.getElementsByTagName('td');
	// 	for (let i = 0; i < 10; i++) {
	// 		const widerElement = thElements[i].offsetWidth > tdElements[i].offsetWidth ? thElements[i] : tdElements[i], //? sta per condizione ? se vera : se falsa
	// 			width        = window.getComputedStyle(widerElement).width;
	// 	  thElements[i].style.width = tdElements[i].style.width = width;
	// 	}
	// }
	
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

</script>
