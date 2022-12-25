
<?	
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	$annoscolastico  = $_POST['annoscolastico_cla'];
	$dbA = $_SESSION['databaseA'];
	$dbB = $_SESSION['databaseB'];
	//estraggo il valore dei singoli campi: serve per eseguire la query estraendo i campi in maniera dinamica
	//sulla base delle selezioni effettuate
	for ($x = 1; $x <= 6; $x++) {
		if (isset ($_POST['campo'.$x])) {
			$campoName[$x] = $_POST['campo'.$x];
			$campoNamePerSql[$x] = ", ".$campoName[$x];
		}
	}
	// ora costruisco la clasuola ORDER BY sulla base di tutti i valori di ord
	
	$ordOrd = ["idle", 1, 3, 4, 2, 5, 6];
		for ($x = 1; $x <= 6; $x++) {
			$y = $ordOrd[$x];
			if (isset ($_POST['ord'.$y]))
			{
				$ord[$y] = $_POST['ord'.$y];
				$ordsql = orderbysql( $ord[$y], $campoName[$y], $ordsql);
			}
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
		$ordsql =  " ORDER BY tab_classialunni.classe_cla, tab_classialunni.sezione_cla, ".$_SESSION['databaseA'].".tab_anagraficaalunni.cognome_alu ";
	} else {
		$ordsql = ' ORDER BY ' .  substr($ordsql, 2) ;
	}


	
	// ora costruisco la clasuola FILTER BY sulla base di tutti i valori di fil
	for ($x = 1; $x <= 4; $x++) {
	if (isset ($_POST['fil'.$x]))
		{
			$fil[$x] = $_POST['fil'.$x];
			$filsql = filterbysql( $fil[$x], $campoName[$x], $filsql);
		}
	}
	function filterbysql ($fil, $campo, $filsq) {
		switch ($fil) {
			case '' :
				break;
		
			default :
				//Se viene inserito un = altrimenti è un LIKE
				if (substr($fil,0,1) == '=') {
				$filsq = $filsq . " AND ". $campo. " = \"". substr($fil, 1) ."\" ";
				} else {
				$filsq = $filsq . " AND ". $campo. " LIKE \"%". $fil ."%\" ";
				}
				break;
		}
		return $filsq;
	}

	$whereannocorrente = "WHERE tab_classialunni.annoscolastico_cla = '".$_POST['annoscolastico_cla']."'  ";
	
	$listaattesa = $_POST['listaattesa'];
	if ($listaattesa != "All") {
		$wherelistaattesa = " AND tab_classialunni.listaattesa_cla = ".$listaattesa." ";
	} else {
		$wherelistaattesa = " ";
	}
	//nella seguente sql inserisco anche una serie di campi fissi perchè la stringa sql la scrivo in un campo hidden e la riutilizzo per il download filtrato

	$sqlbasecount = "SELECT DISTINCT ".
	"ID_alu FROM ((tab_anagraficaalunni LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) ".
	" LEFT JOIN ".$dbA.".tab_famiglie ON ID_fam_alu = ".$dbA.".tab_famiglie.ID_fam) ".
	" LEFT JOIN ".$dbB.".tab_famiglie ON ID_fam_alu = ".$dbB.".tab_famiglie.ID_fam ".
	$whereannocorrente.$wherelistaattesa.$filsql;
	//QUERY PARAMETRICA DA FARE - DIFFICILE
	$whereclause = array();
	$sqlA = array();
	$stmtA = array();
	$completatoA= array();
	$percent = array();
	$percent[1] = "100";
	$percent[2] = "80";
	$percent[3] = "60";
	$percent[4] = "40";
	$percent[5] = "20";
	$percent[6] = "0";
	

	// //per fare dei test
	// echo("
	// <tr>
	// <td colspan='6'>".
	// $sqlbasecount
	// ."</td>
	// </tr>"
	// );




	// $whereclause[2] = " AND ".$dbB.".tab_famiglie.iscrizionecompleta_fam = 80 ";
	// $whereclause[3] = " AND ".$dbB.".tab_famiglie.iscrizionecompleta_fam = 60 ";
	// $whereclause[4] = " AND ".$dbB.".tab_famiglie.iscrizionecompleta_fam = 40 ";
	// $whereclause[5] = " AND ".$dbB.".tab_famiglie.iscrizionecompleta_fam = 20 ";
	// $whereclause[6] = " AND ".$dbB.".tab_famiglie.iscrizionecompleta_fam = 0 ";
	$tot = 0;
	$string = "<div class=\'col-md-6 col-md-offset-3\' style=\'align-text: center; margin-bottom: 20px;\'><table class=\'table table-bordered\'><tr><td>Iscrizione completa al </td><td>per alunni</td></tr>";

	for ($x = 1; $x <= 6; $x++) {
		$whereclause[$x] = " AND ".$dbB.".tab_famiglie.iscrizionecompleta_fam = ".$percent[$x]." ";
		$sqlA[$x] = $sqlbasecount.$whereclause[$x];
		$stmtA[$x] = mysqli_prepare($mysqli, $sqlA[$x]);
		//mysqli_stmt_bind_param($stmt1, "sssi",....);
		mysqli_stmt_execute($stmtA[$x]);
		mysqli_stmt_bind_result($stmtA[$x], $ID_alu);
		mysqli_stmt_store_result($stmtA[$x]);
		$n = 0;
		while (mysqli_stmt_fetch($stmtA[$x])) {
			$n++;
		}
		//$completatoA[$x] = mysqli_stmt_num_rows ($stmtA[$i]);
		$completatoA[$x] = $n;
		$tot = $tot + $n;
		$string = $string." <tr><td>".$percent[$x]." % </td><td>".$n."</td></tr>";
	}
	$string = $string."</table></div>";

	
	//la seguente SELECT non la posso impostare all'inizio in SetSessionParameters in quanto si deve poter modificare "al volo"
	//quindi è necessario pescare all'ultimo momento il valore del parametro spedisciAGenitori
	$sqlp = "SELECT val_par FROM ".$dbA.".tab_parametri WHERE parname_par = 'spedisciAGenitori';";
	$stmtp = mysqli_prepare($mysqli, $sqlp);
	mysqli_stmt_execute($stmtp);
	mysqli_stmt_bind_result($stmtp, $spedisciAGenitori);
	while (mysqli_stmt_fetch($stmtp))
	{}

	?>
	<tr>
		<td colspan="5">
		</td>
		<td><button id="btn_debugOGenitori" style="font-size: 10px; width: 100%; <?if ($spedisciAGenitori == 1) {echo('color: red;');}?>  " onclick="DebugOGenitori(<?=$spedisciAGenitori?>);"><?if ($spedisciAGenitori == 1) {echo('AI GENITORI!');} else {echo('A DEBUG');}?></button></td>
		<td colspan="5"></td>
		<td><button style="font-size: 10px; width: 100%;" onclick="modalShowStatus('<?=$string?>');">STATUS</button></td>
		<!--<td><span style="font-size: 9px" title=" <?//echo($string);?>">[STATUS]</span></td>-->
		
	</tr>
	
	<?
	$sql = "SELECT DISTINCT ".
	$dbA.".tab_anagraficaalunni.ID_alu, ".
	$dbA.".tab_anagraficaalunni.ID_fam_alu, ".
	$dbA.".tab_anagraficaalunni.nome_alu, ".
	$dbA.".tab_anagraficaalunni.cognome_alu, ".
	$dbA.".tab_classialunni.listaattesa_cla, ".
	$dbA.".tab_famiglie.emailpadre_fam, ".
	$dbA.".tab_famiglie.emailmadre_fam, ".
	$dbA.".tab_classialunni.classe_cla, ".
	$dbA.".tab_classialunni.sezione_cla, ".
	$dbA.".tab_classialunni.annoscolastico_cla, ".

	$dbB.".tab_famiglie.mailinviate_fam, ".
	$dbB.".tab_famiglie.promemoriainviati_fam, ".
	$dbB.".tab_famiglie.loginusata_fam, ".
	$dbB.".tab_famiglie.iscrizionecompleta_fam, ".
	$dbB.".tab_famiglie.iscrizioneinviata_fam, ".
	$dbB.".tab_famiglie.datirecuperati_fam, ".
	"altripag.TotIscrizione, ".
	$dbB.".tab_anagraficaalunni.noniscritto_alu, ".
	$dbB.".tab_users.ID_usr, ".
	$dbB.".tab_users.login_usr, ".
	$dbB.".tab_users.bloccato_usr, ".
	$dbB.".tab_famiglie.annopreiscrizione_fam ".

	
	" FROM ".$dbA.".tab_anagraficaalunni ".
	" LEFT JOIN ".$dbA.".tab_classialunni ON 		".$dbA.".tab_anagraficaalunni.ID_alu = ".$dbA.".tab_classialunni.ID_alu_cla ".
	" LEFT JOIN ".$dbA.".tab_famiglie ON 			".$dbA.".tab_anagraficaalunni.ID_fam_alu = ".$dbA.".tab_famiglie.ID_fam ".
	" LEFT JOIN ".$dbB.".tab_famiglie ON 			".$dbA.".tab_anagraficaalunni.ID_fam_alu = ".$dbB.".tab_famiglie.ID_fam ".
		//  Con questa limito le informazioni che "aggancio" sulla dx alle sole iscrizioni per l'anno selezionato
		" AND ".$dbB.".tab_famiglie.annopreiscrizione_fam = '".$_POST['annoscolastico_cla']."' ". 

	//estraggo le info del dbB, in particolare se è non iscritto
	" LEFT JOIN ".$dbB.".tab_anagraficaalunni ON 	".$dbB.".tab_anagraficaalunni.ID_alu = " .$dbA.".tab_anagraficaalunni.ID_alu ".




	" LEFT JOIN ".$dbB.".tab_users ON 				".$dbB.".tab_famiglie.ID_usr_fam = " .$dbB.".tab_users.ID_usr ".

	// " LEFT JOIN (SELECT ".$dbB.".tab_users.login_usr, ".$dbB.".tab_users.bloccato_usr  FROM ".$dbB.".tab_users 
	// LEFT JOIN ".$dbB.".tab_classialunni ON " .$dbB.".tab_classialuni.ID_alu_cla =  ".$dbA.".tab_classialunni.ID_alu_cla AND "
	// .$dbB.".tab_classialuni.annoscolastico_cla = ".$dbA.".tab_classialuni.annoscolastico_cla
	// LEFT JOIN ".$dbB.".tab_famiglie ON " .$dbB.".tab_users.ID_usr =  ".$dbA.".tab_famiglie.ID_usr_fam
	// ) ON ".$dbB.".tab_famiglie.ID_usr_fam = " .$dbB.".tab_users.ID_usr ".


	//potrebbero esserci stati diversi pagamenti per l'iscrizione, quindi va eseguita la SUM di quelli (causale_pag = 2) in GROUP BY su alunno e annoscolastico_pag e poi di quella va fatta la JOIN in questa sql
	 "LEFT JOIN ( SELECT ID_alu_pag, annoscolastico_pag , SUM(importo_pag) as TotIscrizione FROM ".$dbA.".tab_pagamenti WHERE causale_pag = 2 GROUP BY ID_alu_pag, annoscolastico_pag ) AS altripag ON altripag.ID_alu_pag = ID_alu_cla AND altripag.annoscolastico_pag = ".$dbA.".tab_classialunni.annoscolastico_cla ".
	

	$whereannocorrente.$wherelistaattesa.$filsql.$ordsql;

	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	
	mysqli_stmt_bind_result($stmt, $ID_alu, $ID_fam_alu, $nome_alu, $cognome_alu, $listaattesa_cla, $emailpadre_fam, $emailmadre_fam, $campo3value, $campo4value, $campo5value, $mailinviate_fam, $promemoriainviati_fam, $loginusata_fam, $iscrizionecompleta_fam, $iscrizioneinviata_fam, $datirecuperati_fam, $TotIscrizione, $noniscritto_alu, $ID_usr, $login_usr, $bloccato_usr, $annopreiscrizione_fam);
	//id_asc è l'indice che corrisponde in tabella anniscolastici all'annoscolastico del record selezionato. Lo estraggo per metterlo nell'attributo name del campo tipo checkbox perchè serve
	//a effettuare le promozioni: con il codice id_asc si può accedere alla tabella anniscolastici ed estrarre l'anno scolastico "+1". Va salvato "padded" nel name della checkbox per poterlo poi estrarre.
	
	$riga =  0;

	$ID_famA = [];
	?>
	<!-- <tr>
		<td>
			<?//=$sql?>	
		</td>
	</tr> -->
	<?
	while (mysqli_stmt_fetch($stmt)) {

		//Devo creare un array ID_famA di tutti gli ID_fam inclusi UNA SOLA VOLTA CIASCUNO
		//quindi verifico se l'ID_fam corrente c'è e se non c'è lo aggiungo
		//questo array verrà passato con una serialize a downloadModuloIscrizione nel solo caso in cui si debbano generare TUTTI in un solo pdf:
		//verrà ricevuto da downloadModuloIscrizione che ne fa il deserilize per ritrasformarlo in un array e poi usarlo.
		if (!in_array($ID_fam_alu, $ID_famA)){
			array_push($ID_famA,$ID_fam_alu);
		} 
		$mails=0;
		if ($emailpadre_fam !="") {$mails++;}
		if ($emailmadre_fam !="") {$mails++;}
		if ($listaattesa_cla == 1) { $cllistaattesa = "cllistaattesa";} else {$cllistaattesa = ""; }
		//if ($emailpadre_fam!="") {$emailtotale =  $emailtotale.",".$emailpadre_fam;}
		//if ($emailmadre_fam!="") {$emailtotale =  $emailtotale.",".$emailmadre_fam;}
		$riga++;
		?>


		<tr>
			<td oncontextmenu="rightClickAlu(event, <?=$ID_alu?>)" style="position:relative">
				<? if ($mails!=0 && $datirecuperati_fam!=0) {?>
					<!-- <div id="rightmenualu<?//=$ID_alu?>" class="rightmenu fs12" style="position: absolute; left: 30px; top: -3px; display: none;" onclick="rightClicked(<?=$ID_fam_alu?>, '<?=$_POST['annoscolastico_cla']?>')">
						<img href="" title="Invia Mail" style="position: absolute; left: 5px; width: 23px; " src='assets/img/Icone/envelope-regular-white.svg'>
						<input class="rightmenuinputalu w160px" style="text-align: right" id="rightmenuinputalu<?=$ID_alu?>"	value="invia mail di Promemoria" readonly>
					</div> -->
				<?}?>

				<input class="" type="text"  id="ID_alu_riga_<?=$riga?>" name="aluriga_<?=$riga?>" value = "<?=$ID_alu?>" 		hidden>
				<input class="" type="text"  id="ID_fam_riga_<?=$riga?>" name="famriga_<?=$riga?>" value = "<?=$ID_fam_alu?>" 	hidden>


				<button  class="<? if ($ritirato_cla ==1 ) {echo ('alunnoritirato');} elseif ($classeprec_cla == ""){echo ('alunnonuovo');} ?>"id="goto<?=$ID_alu?>" ondblclick="postToSchedaAlunno(<?=$ID_alu?>, '<?=addslashes($nome_alu)?>', '<?=addslashes($cognome_alu);?>');" style="width: 40px; font-size:12px;"><?=$riga?></button>
			</td>
			<td>
				<input 
				class="tablecell6 disab val<?=$ID_alu?> <?=$cllistaattesa?>" type="text"  
				id="nome_alu<?=$ID_alu?>" name="nome_alu" value = "<?=$nome_alu?>" 
				style="width:120px" disabled>
			</td>
			<td>
				<input
				class="tablecell6 disab val<?=$ID_alu?> <?=$cllistaattesa?>" type="text"
				id="cognome_alu<?=$riga?>" name="cognome_alu" value = "<?=$cognome_alu?>"
				style="width:120px" disabled>
			</td>
			<td>
				<input
				class="tablecell6 disab val<?=$ID_alu?> <?=$cllistaattesa?>" type="text" 
				value = "<?=$campo3value?>" 
				style="width: 90px;" disabled>
			</td>
			<td>
				<input 
				class="tablecell6 disab val<?=$ID_alu?> <?=$cllistaattesa?> w50px" type="text"
				value = "<?=$campo4value?>" disabled>
			</td>
			<!-- <td>
				<input
				class="tablecell6 disab val<?//=$ID_alu?> <?//=$cllistaattesa?>" type="text"
				value = "<?//=$campo5value?>"
				style="width: 90px;" disabled>
			</td> -->
			<td>
				<? if ($mails!=0) {?>
					<button style="width: 90px; padding: 0px; height: 24px; " onclick="CheckBeforeSendEmail(<?=$riga?>, <?=$ID_fam_alu?>, '<?=$_POST['annoscolastico_cla']?>');">
					<img href="" title="Invia Mail" style="width: 23px; cursor: pointer" src='assets/img/Icone/envelope-regular.svg'>
					<? if ($mails==2) {?>
					<img href="" title="Invia Mail" style="width: 24px; cursor: pointer" src='assets/img/Icone/envelope-regular.svg'><?}?>
					</button>
				<?} ?>
			</td>
			<td>
				<img title="Cancella procedura iscrizione della famiglia" style="   <?if($mailinviate_fam==0 || $mailinviate_fam=='') { echo ('visibility: hidden; ');}?>    width: 20px; cursor: pointer" class="hideonsmalldevices" src='assets/img/Icone/times-circle-solid.svg' onclick="showModalDeleteThisRecord(<?= $ID_fam_alu?>, &#34;<?=$nome_alu?>&#34;, &#34<?=$cognome_alu?>&#34 );">
			</td>
			<td>
				<input id="mailinviate_fam_<?=$riga?>" class="tablecell6 val<?=$ID_alu?> <?=$cllistaattesa?>" type="text" value = "<?=$mailinviate_fam?>" style="<?if($mailinviate_fam!=0 && $mailinviate_fam!=''){ echo('background-color: #07ff00;');}?> width: 80px;" disabled>
			</td>
			<td class="w100px">
				<button id="btn_login" class="val<?=$ID_alu?> <?=$cllistaattesa?> w100px" style="<?if($login_usr ==''){ echo('display: none;');}?> font-size: 10px; padding: 0px; height: 24px; " onclick="apriPortaleIscrizioni('<?=$login_usr?>');" title="vai a Portale iscrizioni"><?=$login_usr?></button>
			</td>
			<td class="w60px">
			<button id="btn_login" class="val<?=$ID_alu?> <?=$cllistaattesa?> w60px" style="<?if($login_usr ==''){ echo('display: none;');}?> font-size: 10px; padding: 0px; height: 24px; text-decoration: underline" onclick="showModalChgPsw(<?=$ID_usr?>, '<?=$login_usr?>');" title="imposta la Password">***</button>

			</td>
			<td>
				<img title="Blocca accesso della famiglia" style="  <?if($mailinviate_fam==0 || $mailinviate_fam=='') { echo ('visibility: hidden; ');}?> width: 20px; cursor: pointer" class="hideonsmalldevices" src='assets/img/Icone/<?if($bloccato_usr==1){echo('lock.svg');} else {echo('unlock.svg');}?>'
				onclick="bloccaSbloccaUtente('<?=$login_usr?>');">
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_alu?> <?=$cllistaattesa?>" type="text" value = "<?if ($loginusata_fam== 0) {echo("NO");}else{echo("SI");}?>" style="<?if($loginusata_fam!=0 && $loginusata_fam!=''){ echo('background-color: #07ff00;');}?> width: 90px;" disabled>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_alu?> <?=$cllistaattesa?>" type="text" value = "<?if($iscrizionecompleta_fam !="") {echo($iscrizionecompleta_fam."%");} else {echo("-");}?>" style="width: 90px; <?if($iscrizionecompleta_fam==100){ echo('background-color: #07ff00;');}?>" disabled>
			</td>
			<td style="width: 60px;">
				<? if($iscrizionecompleta_fam==100) {?>
					<button style="width: 60px; padding: 0px; height: 24px;  <? if ($noniscritto_alu ==1) {echo("background-color: red;");} ?>" onclick="downloadModuloIscrizione(<? echo($ID_fam_alu) ?>);">
					<img title="Stampa Modulo" style="width: 23px; cursor: pointer" src='assets/img/Icone/EmissioneDocumentiBlack.svg'>
					</button>
				<?} else {?>
					<input class="tablecell6 disab" type="text" value = "-" style="width: 60px; " disabled>
				<?}?>
			</td>
			<td>
				<? if($iscrizionecompleta_fam==100){?> <button style="width: 80px; padding: 0px; height: 24px; " data-toggle="modal" onclick="RecuperaDati(<? echo($ID_fam_alu) ?>);">
					<img href="" title="Recupera Dati" style="width: 40px; cursor: pointer" src='assets/img/Icone/recover.svg'>
					
					</button>
				<?} else {?>
					<input class="tablecell6 disab" type="text" value = "-" style="width: 80px; " disabled>
				<?}?>
			</td>
			<td>
				<input class="tablecell6 disab val<?=$ID_alu?> <?=$cllistaattesa?>" type="text" value = "<?if ($datirecuperati_fam == 0) {echo("-");}else{echo("OK");}?>" style="<?if($datirecuperati_fam !=0 && $datirecuperati_fam!=''){ echo('background-color: #07ff00;');}?> width: 80px;" disabled>
			</td>

			<td>
				<input class="tablecell6 disab val<?=$ID_alu?> <?=$cllistaattesa?>" type="text" value = "<?=intval($TotIscrizione)?>" style="width: 80px;" disabled>	
			</td>
			<td>
				
				<button style="    <? if ($mails==0 || $datirecuperati_fam==0) {echo("visibility: hidden;");}?>   width: 25px; padding: 0px; height: 24px;  <? if ($noniscritto_alu ==1) {echo("background-color: red;");} ?>" onclick="inviaPromemoriaImpegni(<?=$ID_fam_alu?>, '<?=$annoscolastico?>' );">
					<img title="Invia Promemoria" style="width: 22px; cursor: pointer" src='assets/img/Icone/BellPromemoria.svg'>
				</button>
				<input class="tablecell6 disab val<?=$ID_alu?> <?=$cllistaattesa?>" type="text" value = "<?=$promemoriainviati_fam?>" style="<?if($datirecuperati_fam !=0 && $datirecuperati_fam!=''){ echo('background-color: #07ff00;');}?> width: 40px;" disabled>
			</td>

			<!--<td>
				<input class="tablecell6 val<?=$ID_alu?> <?=$cllistaattesa?>" type="text" value = "<?//if ($iscrizioneinviata_fam== 0) {echo("NO");}else{echo("SI");}?>" style="width: 90px;" disabled>
			</td>-->
			<!--<td>
				<input style="width: 20px;" class="tablecell6 val<?//=$ID_alu?>" type="checkbox" name="<? //echo(sprintf("%'.04d\n", $ID_asc)); ?><?//=$annoscolastico_cla?>-ck-<? //echo(sprintf("%'.04d\n", $ID_alu)); ?>-cls-<?//=$ord_cls?><?//=$sezione_cla?>" id="<?//=$riga?>ck">
			</td>-->
		</tr>
	<?}?>
	<tr>
		<td>
			<input id="contarecord_hidden" value = "<?=$riga?>" hidden>
		</td>
		<td>
			<input id="sql_hidden" value = "<?=$sql?>" hidden>
		</td>
		<td>
			<input type="text"  id="emailtotalehidden" value = "<?=$emailtotale?>" hidden>
		</td>
		<td>
			<input type="text"  id="ID_fam_alu_hidden" value = "" hidden>
		</td>

	</tr>
	


<script>
	
	$(document).ready(function(){
		let listaemails = $('#emailtotalehidden').val();
		listaemails = listaemails.slice(1);
		listaemails = "mailto:"+listaemails;
		$("#mailtotutti").attr("href", listaemails );
		//UniformaColonne();
	});
	
	
	function coloraRighe(ID_alu){
		//pulisco colore delle celle di tutte le righe
		$('#tabellaAnagraficaIscrizioni tr:even td .tablecell6').css('background-color', '#e0e0e0').css('color', '#474747');
		$('#tabellaAnagraficaIscrizioni tr:odd td .tablecell6').css('background-color', '#fff').css('color', '#474747');
		$('.val'+ID_alu).css('background-color', '#289bce').css('color', '#fff');
	}
		
	//function UniformaColonne () {
	//	const thElements = document.getElementsByTagName('th');
	//	const tdElements = document.getElementsByTagName('td');
	//	for (let i = 0; i < 5; i++) {
	//		const widerElement = thElements[i].offsetWidth > tdElements[i].offsetWidth ? thElements[i] : tdElements[i], //? sta per condizione ? se vera : se falsa
	//			width        = window.getComputedStyle(widerElement).width;
	//	  thElements[i].style.width = tdElements[i].style.width = width;
	//	}
	//}
	
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
	
	




	// function CheckBeforeSendEmailStep2OLD (riga, annoscolastico) {
	// 	//PRIMA DI SPEZZARLA: DA TENERE
	// 	ID_alu = $('#ID_alu_riga_'+riga).val();
	// 	ID_fam_alu = $('#ID_fam_riga_'+riga).val();
	// 	$('#ID_fam_alu_hidden').val(ID_fam_alu);
	// 	postData1 = { ID_fam_alu : ID_fam_alu, annoscolastico : annoscolastico };
	// 	//1. verifica che ci sia il cognome_fam in DB altrimenti la user id e tutto il resto non funzionano bene
	// 	// console.log ("19qry_Iscrizioni.php - CheckBeforeSendEmail - postData a 19qry_checkCognomefam");
	// 	// console.log (postData1);

	// 	$.ajax({
	// 		type: 'POST',
	// 		url: "19qry_checkCognomefam.php",
	// 		data: postData1,
	// 		dataType: 'json',
	// 		success: function(data){
	// 			//  console.log ("19qry_Iscrizioni.php - CheckBeforeSendEmail - ritorno da 19qry_checkCognomefam");
	// 			//  console.log (data.cognome_fam);
	// 			if (data.cognome_fam == "") {
	// 				$('#titolo01Msg_OK').html('INVIO EMAIL');
	// 				$('#msg01Msg_OK').html("Manca nel database il cognome della famiglia.<br>Non si può procedere in quanto non si può generare la user id.");
	// 				$('#modal01Msg_OK').modal('show');
	// 			} else {
	// 				//  console.log ("19qry_Iscrizioni.php - CheckBeforeSendEmail - postData a 19qry_checkSeQuota");
	// 				//  console.log (postData1);
	// 				// 19qry_checkSeQuota verifica se c'è la quota indicata in tutti o se almeno uno dei fratelliha quota annua posta a zero 
	// 				$.ajax({
	// 					type: 'POST',
	// 					url: "19qry_checkSeQuota.php",
	// 					data: postData1,
	// 					dataType: 'json',
	// 					success: function(data2){
	// 						//  console.log ("19qry_Iscrizioni.php CheckBeforeSendemail - verifica se almeno un fratello ha quote concordate tutte nulle per l'anno selezionato - se sì ci si ferma")
	// 						//  console.log (data2.almenounaquotaannuazero);
	// 						if (data2.almenounaquotaannuazero) {
	// 							$('#titolo01Msg_OK').html('INVIO EMAIL');
	// 							$('#msg01Msg_OK').html("Manca nel database almeno una quota annuale concordata per uno dei figli della famiglia "+data.cognome_fam+" <br>Oltre ad iscrivere i figli all'anno scolastico, è necessario valorizzare le quote.<br>altrimenti la famiglia riceverebbe nel modulo di iscrizione una quota pari a zero.");
	// 							$('#modal01Msg_OK').modal('show');
	// 						} else {
	// 							//  console.log ("19qry_Iscrizioni.php - CheckBeforeSendEmail - postData a 19qry_checkSeCompilato");
	// 							//  console.log (postData1);
	// 							$.ajax({
	// 								type: 'POST',
	// 								url: "19qry_checkSeCompilato.php",
	// 								data: postData1,
	// 								dataType: 'json',
	// 								success: function(data3){
	// 									//  console.log ("19qry_Iscrizioni.php CheckBeforeSendemail - verifica se per caso la famiglia ha già compilato, per mandare in quel caso un warning in modo che non si vada a cancellare qualcosa di già compilato");
	// 									  //console.log (data3.giapresenteegiacompilato);
	// 									  //console.log(data3.records);
	// 									  //console.log(data3.iscrizionecompleta_fam);
	// 									if (data3.giapresenteegiacompilato == 1) {
	// 										$('#titolo02Msg_OKCancel').html('NUOVO INVIO EMAIL');
	// 										$('#msg02Msg_OKCancel').html("La famiglia "+data.cognome_fam+" ha già modificato i dati nel database esterno.<br>L'invio della nuova mail CANCELLERA' i dati già inseriti e salvati dalla famiglia<br><br>Una nuova mail crea ed invia una nuova password.<br>La user id invece resta la stessa già inviata con la prima mail.<br>Si desidera continuare?");
	// 										$("#btn_OK02Msg_OKCancel").html("Invia");
	// 										$("#btn_OK02Msg_OKCancel").attr("onclick","inviamail();"); //ATTENZIONE: ORA SERVE ID_fam e annoscolastico!!! questa è vecchia
	// 										$('#modal02Msg_OKCancel').modal('show');

	// 										//$('#modalCheckBeforeSendEmail').modal('show');
	// 									} else {
	// 										//se tutto ok allora procedo con l'invio della mail
	// 										inviamail();  //ATTENZIONE: ORA SERVE ID_fam e annoscolastico!!! questa è vecchia
	// 									}
	// 								},
	// 								error: function(){
	// 									alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##fname##'");     
	// 								}
	// 							});
	// 						}
	// 					},
	// 					error: function(){
	// 						alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##fname##'");     
	// 					}
	// 				});
	// 			}
	// 		},
	// 		error: function(){
	// 			alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##fname##'");     
	// 		}
	// 	});
	// }

//******************************TENTATIVO DI SPEZZARE************************** */
	function showModalInviaMailATutti(){
		debugOGenitori = $('#btn_debugOGenitori').html();
		console.log (debugOGenitori);
		$('#msg03Msg_OKCancelPsw').html("Questa routine è molto RISCHIOSA in quanto<br>invia una mail a tutte le famiglie (NB: non una per alunno).<br>L'invio avverrà SOLO verso le famiglie alle quali non è già stata inviata.<br><br>L'invio è attualmente impostato '"+debugOGenitori+"'<br> digitare la password di MASSIMO livello e confermare");
		$("#btn_OK03Msg_OKCancelPsw").attr("onclick","InviaMailaTutti();");
		$("#btn_OK03Msg_OKCancelPsw").show();
		$("#titolo03Msg_OKCancelPsw").html('FUNZIONE SPERIMENTALE, A VOSTRO RISCHIO<br>INVIO EMAIL PRE-ISCRIZIONE A TUTTE LE FAMIGLIE');
		$("#btn_cancel03Msg_OKCancelPsw").html('Annulla');
		$("#remove-content03Msg_OKCancelPsw").show();
		$("#alertCont03Msg_OKCancelPsw").removeClass('alert-success');
		$("#alertCont03Msg_OKCancelPsw").addClass('alert-danger');
		$("#alertCont03Msg_OKCancelPsw").hide();
		$("#passwordDelete").val("");
		$('#modal03Msg_OKCancelPsw').modal('show');
	}	

	function InviaMailaTutti() {
		let psw = $("#passwordDelete").val();
		let pswOperazioni0 = $("#pswOperazioni0").val();
		if (psw == null || psw == "" || psw !=pswOperazioni0 ) {
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		}	else  {
			$('#modal03Msg_OKCancelPsw').modal('hide');
			//questa funzione invia una mail a TUTTI quelli che ANCORA non l'hanno ricevuta
			//per questo non serve il check di quante mail inviate
			//che il singolo invio fa nella routine CheckBeforeSendEmail
			//se ci sono già stati invii non ne fa altri

			// $('#titolo01Msg_OK').html('INVIO MAIL A TUTTI');
			// $('#msg01Msg_OK').html("Funzione in corso di sviluppo");
			// $('#modal01Msg_OK').modal('show');
			// return;
			let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
			//let annoscolastico_cla = $( "#annoscolastico" ).val();
			let numerorighe = $('#contarecord_hidden').val();
			ID_famInviateA = []; //voglio inviare una sola mail per famiglia, non più di una
			invii = 0;
			for (riga = 1; riga <= parseInt(numerorighe); riga++) {
				ID_fam_alu = $('#ID_fam_riga_'+riga).val();
				$('#ID_fam_alu_hidden').val(ID_fam_alu);
				mailinviate = $('#mailinviate_fam_'+riga).val();
				if (mailinviate == '') {
					if ( ! ID_famInviateA.includes (ID_fam_alu)){
						ID_famInviateA.push(ID_fam_alu);
						//console.log('invio a fam', ID_fam_alu, " - riga:", riga, " - annoscolastico: ", annoscolastico_cla);
						CheckBeforeSendEmailStep2(ID_fam_alu, annoscolastico_cla);
						invii++;
					} else {
						//console.log ("invio a famiglia "+ID_fam_alu+" già avvenuto in questa routine")
					}
				} else {
					//console.log ("invio a famiglia "+ID_fam_alu+" già avvenuto in precedenza")
				}
			}
			$('#titolo01Msg_OK').html('INVII');
			$('#msg01Msg_OK').html(invii+" invii eseguiti");
			$('#modal01Msg_OK').modal('show');
		}

	}

	function CheckBeforeSendEmail (riga, ID_fam_alu, annoscolastico) {
		//verifico se già presente in database B
		//una volta potevo verificare direttamente se mailinviate_fam era <> ''
		//in verità quel che è da fare è guardare dentro il database B in quanto mailinviate potrebbe essere ='' solo perchè la famiglia è iscritta a un altro anno
		//let mailinviate = $('#mailinviate_fam_'+riga).val();
		let cognome_alu = $('#cognome_alu'+riga).val();
		postData1 = {ID_fam_alu: ID_fam_alu};
		console.log("19qry_Iscrizioni.php - CheckBeforeSendEmail postData a 19qry_checkIfInDBB", postData1);

		$.ajax({
			type: 'POST',
			url: "19qry_checkIfInDBB.php",
			data: postData1,
			dataType: 'json',
			success: function(data){
				// console.log("19qry_Iscrizioni.php - CheckBeforeSendEmail ritorno da 19qry_checkIfInDBB", data);
				if (data.annopreiscrizione_fam != "" && data.annopreiscrizione_fam != null) {
					$('#titolo02Msg_OKCancel').html('NUOVO INVIO EMAIL');
					$('#msg02Msg_OKCancel').html("Sono state già inviate email alla famiglia di riga "+riga+" e cognome "+cognome_alu+" per l'anno "+data.annopreiscrizione_fam+". <br><br>Una nuova mail crea ed invia una nuova password.<br>La user id invece resta la stessa già inviata con la prima mail.<br>Si desidera continuare?");
					$("#btn_OK02Msg_OKCancel").html("Invia");
					$("#btn_OK02Msg_OKCancel").attr("onclick","CheckBeforeSendEmailStep2("+ID_fam_alu+", '"+annoscolastico+"');");
					$('#modal02Msg_OKCancel').modal('show');
				} else {
					CheckBeforeSendEmailStep2(ID_fam_alu, annoscolastico);
				}
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##checkCognomeFam##'");

			}
		});

	}


	function checkCognomeFam(postData1) {
		//console.log("19qry_Iscrizioni.php - checkCognomeFam postData a 19qry_CheckCognome", postData1);
		return new Promise((res,rej) => {
			$.ajax({
				type: 'POST',
				url: "19qry_checkCognomefam.php",
				data: postData1,
				dataType: 'json',
				success: function(data){
					if (data.cognome_fam == "" || data.cognome_fam == null) {
						$('#titolo01Msg_OK').html('INVIO EMAIL');
						$('#msg01Msg_OK').html("Manca nel database il cognome della famiglia.<br>Non si può procedere in quanto non si può generare la user id.");
						$('#modal01Msg_OK').modal('show');
						rej("no cognome fam");
					} else {
						
						//se tutto ok allora procedo con l'invio della mail	
						res(data);
						//res("OK");
					}
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##checkCognomeFam##'");
					rej ("errore estrazione cognome");
				}
			});
		});
	}



	function checkSeQuota(postData1) {
		console.log("19qry_Iscrizioni.php - checkSeQuota postData a 19qry_checkSeQuota", postData1);
		return new Promise((res, rej) => {
			$.ajax({
				type: 'POST',
				url: "19qry_checkSeQuota.php",
				data: postData1,
				dataType: 'json',
				success: function(data2){
					console.log (data2);
					
					if (data2.almenounaquotaannuazero) {
						$('#titolo01Msg_OK').html('INVIO EMAIL');
						$('#msg01Msg_OK').html("Manca nel database almeno una quota annuale concordata per uno dei figli della famiglia "+postData1.cognome_fam+" <br>Oltre ad iscrivere i figli all'anno scolastico, è necessario valorizzare le quote.<br>altrimenti la famiglia riceverebbe nel modulo di iscrizione una quota pari a zero.");
						$('#modal01Msg_OK').modal('show');
						rej("quota non presente");
					} else {
						res (data2);
					}
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##checkSeQuota##'");
					rej ("errore estrazione quota");
				}
			});
		});
	}

	function checkSeCompilato(postData1) {
		//console.log("19qry_Iscrizioni.php - checkSeCompilato postData a 19qry_checkSeCompilato", postData1);
		return new Promise((res, rej) => {
			$.ajax({
				type: 'POST',
				url: "19qry_checkSeCompilato.php",
				data: postData1,
				dataType: 'json',
				success: function(data3){

					if (data3.giapresenteegiacompilato == 1) {
						$('#titolo02Msg_OKCancel').html('NUOVO INVIO EMAIL');
						$('#msg02Msg_OKCancel').html("La famiglia "+data3.cognome_fam+" ha già modificato i dati nel database esterno.<br>L'invio della nuova mail CANCELLERA' i dati già inseriti e salvati dalla famiglia<br><br>Una nuova mail crea ed invia una nuova password.<br>La user id invece resta la stessa già inviata con la prima mail.<br>Si desidera continuare?");
						$("#btn_OK02Msg_OKCancel").html("Invia");
						$("#btn_OK02Msg_OKCancel").attr("onclick","inviamail("+postData1.ID_fam_alu+",'"+postData1.annoscolastico+"');"); //ATTENZIONE: ORA SERVE ID_fam e annoscolastico!!! questa è vecchia
						$('#modal02Msg_OKCancel').modal('show');
						
						//di qui non passa mai, nemmeno quando si preme cancel...
						//l'apertura del modal blocca il processo
						rej("già presente e già compilato"); 
					} else {
						//se tutto ok allora procedo con l'invio della mail	
						res("OK");
					}
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##checkSeCompilato##'");
					rej("errore su checkSeCompilato");
				}
			});
		});
	}


	function CheckBeforeSendEmailStep2 (ID_fam_alu, annoscolastico) {
		
		postData1 = { ID_fam_alu : ID_fam_alu, annoscolastico : annoscolastico};
		//console.log("19qry_Iscrizioni.php - CheckBeforeSendEmailStep2 postData1 a checkCognomeFam", postData1);

		checkCognomeFam(postData1)
		//la return rende disponibile per la then successiva il valore di data
		.then	((data)=> {		
			console.log("19qry_Iscrizioni.php - CheckBeforeSendEmailStep2 ritorno da checkCognomeFam", data);
			return data;
			}) //data.cognome_fam contiene il cognome_fam? no, contiene "OK"
		.then	((data)=> {
			postData1 = { ID_fam_alu : ID_fam_alu, annoscolastico : annoscolastico, cognome_fam: data.cognome_fam };
			//console.log("19qry_Iscrizioni.php - CheckBeforeSendEmailStep2 postData1 a checkSeQuota", postData1);
			checkSeQuota(postData1)
			.then	((data2)=>{
				return (data2)
				}) //data 2 contiene il check quota
			.then	((data2)=>{
				postData1 = { ID_fam_alu : ID_fam_alu, annoscolastico : annoscolastico};
				//console.log("19qry_Iscrizioni.php CheckBeforeSendEmailStep2 - postData a checkSeCompilato:",  postData1);
				checkSeCompilato(postData1)
				.then ((data3)=>{
					if (data3= "OK") {
						inviamail(ID_fam_alu, annoscolastico);
					}
				})
				.catch((message)=> console.log(message));
			})	
			.catch((message)=> console.log(message));
		})
		.catch	((message)=> console.log(message));

	}
//*************************************************************************************** */

	
	

	function inviamail (ID_fam_alu, annoscolastico_cla) {
		
		//ID_fam_alu = $('#ID_fam_alu_hidden').val();
		postData1 = { ID_fam_alu : ID_fam_alu, annoscolastico_cla : annoscolastico_cla };
		//console.log ("19qry_Iscrizioni.php - inviamail - postData a 19copiainDBB_fam");
		//console.log (postData1);
		//copia in DB B la famiglia se già non c'è
		$.ajax({
			type: 'POST',
			url: "19copiainDBB_fam.php",
			data: postData1,
			dataType: 'json',
			success: function(data1){
				//console.log ("19qry_Iscrizioni.php - inviamail - ritorno test da 19copiainDBB_fam");
				//console.log (data1.test2);
				
				//let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
				//let annoscolastico_cla = $( "#annoscolastico" ).val();
				//serve anche annocorrente per trovare se ci sono fratelli in questo anno e ricopiare anche loro
				postData2 = { ID_fam_alu : ID_fam_alu, annoscolastico_cla : annoscolastico_cla };
				//copia in DB B tutti gli alunni della famiglia se già non ci sono
				// console.log ("19qry_Iscrizioni.php - inviamail - postData a 19copiainDBB_alu");
				// console.log (postData2);
				$.ajax({
					type: 'POST',
					url: "19copiainDBB_alu.php",
					data: postData2,
					dataType: 'json',
					success: function(data2){
						//  console.log ("19qry_Iscrizioni.php - inviamail - risultati di copia in DBB_alu");
						//  console.log (data2.test);
						//ora devo inserire le quote calcolate per default per ogni ID_alu

						ArrayAlunni = data2.alunniA;
						// console.log ("19qry_Iscrizioni.php - inviamail - ritorno da 19copiainDBB_alu", data2.alunniA);
						for (k = 0; k < ArrayAlunni.length; k++) {
							aggiornaQuote(ArrayAlunni[k]);
						}
						
						postData = { ID_fam_alu : ID_fam_alu };
						// console.log ("19qry_Iscrizioni.php - inviamail - postData a 19generatepsw_fam.php", postData);
						// console.log (postData);

						$.ajax({
							type: 'POST',
							url: "19generatepsw_fam.php",
							data: postData,
							dataType: 'json',
							success: function(data){
								let login =  data.login;
								let psw = data.psw;
								// console.log ("19qry_Iscrizioni.php - inviamail - ritorno da 19generatepsw_fam login, psw e test");
								// console.log (login);
								// console.log (psw);
								// console.log ("TEST:"+data.test);
								let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
								//let annoscolastico_cla = $( "#annoscolastico" ).val();

								postData = { ID_fam_alu : ID_fam_alu, annoscolastico_cla: annoscolastico_cla, login: login, psw: psw };
								//  console.log ("19qry_Iscrizioni.php - inviamail - postData a 19sendemail_fam");
								//  console.log (postData);
								$.ajax({
									type: 'POST',
									url: "19sendemail_fam.php",
									data: postData,
									dataType: 'json',
									success: function(data){
										//  console.log ("19qry_Iscrizioni.php - inviamail - ritorno da 19sendemail_fam");
										//  console.log (data.result);
										//  console.log ("from",		data.from);
										//  console.log ("subject", 	data.subject);
										//  console.log ("to", 		data.to);
										//  console.log ("content", 	data.content);


										//$('#modalmailinviata').modal('show');
										requery();
										
									},
									error: function(){
										alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##19sendemail_fam##'");     
									}
								});
							},
							error: function(){
								alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##19generatepsw_fam##'");     
							}
						});
					},
					error: function(){
						alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##19copiainDBB_alu##'");     
					}
				});
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##19copiainDBB_fam##'");     
			}
		});
	
	}


	function inviaPromemoriaImpegni(ID_fam_alu, annoscolastico){
		postData = { ID_fam_alu : ID_fam_alu, annoscolastico_cla: annoscolastico };
		// console.log ("19qry_Iscrizioni.php - inviaPromemoriaImpegni - postData a 19sendemailPromemoriaImpegni_fam");
		// console.log (postData);
		$.ajax({
			type: 'POST',
			url: "19sendemailPromemoriaImpegni_fam.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log ("19qry_Iscrizioni.php - inviaPromemoriaImpegni - ritorno da 19sendemail_fam");
				 console.log (data.result);
				//$('#modalmailinviata').modal('show');
				if (data.check == 'inviato'){
					console.log ("19qry_Iscrizioni.php - inviaPromemoriaImpegni - postData a 19qry_updatePromemoriaInviati");
					console.log (postData);
					$.ajax({
						type: 'POST',
						url: "19qry_updatePromemoriaInviati.php",
						data: postData,
						dataType: 'json',
						success: function(data){
							console.log ("19qry_Iscrizioni.php - inviaPromemoriaImpegni - ritorno da 19qry_updatePromemoriaInviati");
							console.log (data.test);
							requery();
							
						},
						error: function(){
							alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##inviaPromemoriaImpegni##'");     
						}
					});
		
				}
				
				
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##19sendemail_fam##'");     
			}
		});
	}


	function OKInviata() {
		requery();
	}
	
	function aggiornaQuote (ID_alu){


		let annoscolastico_ret = $( "#selectannoscolastico option:selected" ).val();
		//let annoscolastico_ret = $( "#annoscolastico" ).val();
		postData3 = { ID_alu : ID_alu, annoscolastico_ret : annoscolastico_ret };
		// console.log ("19qry_Iscrizioni - aggiornaQuote postData a 19qry_updateQuote.php ");
		// console.log (postData3);
		$.ajax({
			type: 'POST',
			url: "19qry_updateQuote.php",
			data: postData3,
			dataType: 'json',
			//async: false,
			success: function(data3){
				// console.log ("19qry_Iscrizioni - aggiornaQuote ritorno da 19qry_updateQuote.php ");

				// console.log("ID_alu:"+data3.ID_alu);
				// console.log ("quota già impostata per gemello in database B: "+data3.quotapromessa_alu_gemello);
				// console.log ("quotacalcolataMese: "+data3.quotacalcolataMese);
				// console.log(".......");
				// console.log("sql:"+data3.sql);
				// console.log("quota trovata in databaseA: "+data3.concordato_retTOT);
				// console.log("quota impostata:"+data3.impostata);
				// console.log("======");
				// console.log("ID_fam_alu:"+data3.ID_fam_alu);
				// console.log("annoscolastico_ret:"+data3.annoscolastico_ret);

				//console.log("sql:"+data3.sql);

				// console.log("nome_alu:"+data3.nome_alu);
				// console.log("cognome_alu:"+data3.cognome_alu);
				// console.log("maggiore:"+data3.maggiore);
				// console.log("datanascita_alu:"+data3.datanascita_alu);
				// console.log("ultimadatanascita_fratello:"+data3.datanascita_fratello);
				// console.log("fratelli:"+data3.numfratelli);
				// console.log("classe:"+data3.classe_cla);
				// console.log("quotadefault inserita:"+data3.quotacalcolata);
				// console.log("quota concordata 1/0: "+data3.quotaconcordata);
				// console.log("concordatoretTOT: "+data3.concordatoretTOT);
				
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##fname##'");     
			}

		});
	}
	
	
	
	
	function RecuperaDati (ID_fam_alu) {

		//Prima di mostrarre il modale di recupero dei dati verifichiamo che il socio non sia cambiato, ossia che il padre (o la madre) fosse socio ed ora in importazione non sia stato tolto
		//o viceversa che non sia stato inserito e prima non c'era. In tutti e due i casi è necessario decidere come comportarsi.
		//questo si fa utilizzando le stesse routine già inserite sia in 06SchedaAlunno che in 08Schedamaestro
		//infatti a questo punto sarà bene spostare queste routine (showModalAffiliazione, hideAffiliazione, eliminaAffiliazione, aggiornaAffiliazione, inserisciAffiliazione)
		//ed il modale relativo in un file da includere che chiameremo 06Inc_Affiliazione

		postData = { ID_fam_alu : ID_fam_alu};
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "19qry_checkSoci.php",
			data: postData,
			dataType: 'json',
			success: function(data){

				//console.log(data);
				if (data.socioMadreChanged) {
					console.log ("socioMadreChanged", data.socioMadreChanged)
					let subtitleDuringImport1 = "";
					let subtitleDuringImport2 = "";
					if (data.socioMadreDa == 1) {subtitleDuringImport2="La madre è attualmente socia e la famiglia ha indicato di disiscriverla.<br>";}
					else {subtitleDuringImport2="La madre non è attualmente socia, e nel modulo è stato chiesto di associarla<br>";}
					
					let subtitleDuringImport3 = "Scegliere qui come procedere.<br>Se si annulla tutto resterà come attualmente.<br>ATTENZIONE: LA PROCEDURA DI IMPORTAZIONE DOVRA'ESSERE RIPETUTA<br><br>";

					$('#subtitleDuringImport').html(subtitleDuringImport1+subtitleDuringImport2+subtitleDuringImport3);
					
					showModalAffiliazione(ID_fam_alu, 'madre', data.nomemadre_fam, data.cognomemadre_fam);
					return;
				}
				if (data.socioPadreChanged) {
					console.log ("socioPadreChanged", data.socioPadreChanged)

					let subtitleDuringImport1 = "";
					let subtitleDuringImport2 = "";

					if (data.socioPadreDa == 1) {subtitleDuringImport2="Il padre è attualmente socio e la famiglia ha indicato di disiscriverlo.<br>";}
					else {subtitleDuringImport2="Il padre non è attualmente socio, e nel modulo è stato chiesto di associarlo<br>";}
					
					let subtitleDuringImport3 = "Scegliere qui come procedere.<br>Se si annulla tutto resterà come attualmente.<br><br>ATTENZIONE: LA PROCEDURA DI IMPORTAZIONE DOVRA'ESSERE RIPETUTA<br><br>";

					$('#subtitleDuringImport').html(subtitleDuringImport1+subtitleDuringImport2+subtitleDuringImport3);
					

					showModalAffiliazione(ID_fam_alu, 'padre', data.nomepadre_fam, data.cognomepadre_fam);
					return;
				}
				EstraiDatiEMostraModal(ID_fam_alu);


			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##RecuperaDati##'");     
			}
		});
	}
	function EstraiDatiEMostraModal (ID_fam_alu) {
		//devo estrarre tutti i dati di tab_famiglieB, tab_anagraficalunniB e tab_composizionefamB e portarli in db A
		//o meglio confrontarli con gli omologhi in db A e "proporli" all'utente
		//scelgo di creare un form modale dove inserisco TUTTI i campi delle tre tabelle. In questi campi vado a scrivere i dati estratti.
		//Poi NASCONDERO' i dati che sono uguali in Db B e Db A (non serve proporre quelli)
		//e quelli che sono vuoti in Db A (un dato in più va sempre bene).
		//Metterò un flag a fianco a ciascun dato che resta visibile affinchè l'utente possa dire "importa questo, questo no".
		//alla fine verranno importati tutti quelli flaggati + quelli per i quali in db A non c'è nulla.
		//Non importerò quelli vuoti e non importerò quelli non flaggati
		postData = { ID_fam_alu : ID_fam_alu};
		// console.log (postData);
		$.ajax({
			type: 'POST',
			url: "19qry_GetFromDBB.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log(data.sql);
				//console.log(data.fromDBB);
				//console.log(data.fromDBA);
				$("#importazioneeconfronto").html(html);
				$("#remove-contentImportazione").show();
				$("#alertaggiungiImportazione").addClass('alert-danger');
				$("#alertaggiungiImportazione").removeClass('alert-success');
				$("#alertmsgImportazione").html("Si è verificato qualche problema durante l'importazione!");
				$("#alertaggiungiImportazione").hide();
				$("#btn_cancel1Importazione").addClass('pull-left');
				$("#btn_cancel1Importazione").html('Annulla');
				$("#btn_OK1Importazione").show();
				Visibilita();
				$('#modalImportazione').modal('show');
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##fname##'");     
			}
		});
	}

	
	function downloadModuloIscrizione(ID_fam) {
		let url = "iscrizioni/downloadModuloIscrizione.php";

		let annoscolastico = $( "#selectannoscolastico option:selected" ).val();
		
		let form = $('<form id="tmpform" action="' + url + '"method="post">' + 
		'<input type="text" name ="ID_fam" value ='+ID_fam+' >'+
		'<input type="text" name ="annoscolastico" value ='+annoscolastico+' >'+
		'</form>');
		$('body').append(form);
		form.submit();
		var element =  document.getElementById('tmpform');
		element.remove();
	}

	function downloadModuliAnno() {
		let url = "iscrizioni/downloadModuloIscrizione.php";

		let annoscolastico = $( "#selectannoscolastico option:selected" ).val();

		let form = $('<form id="tmpform" target="_blank" action="' + url + '"method="post">' + 
		'<input type="text" name ="ID_fam" value ="0" >'+
		'<input type="text" name ="ID_famA" value ="<?=serialize($ID_famA)?>" >' +
		'<input type="text" name ="annoscolastico" value ='+annoscolastico+' >'+
		'</form>');
		
		$('body').append(form);
		form.submit();
		var element =  document.getElementById('tmpform');
		element.remove();
	}


	function bloccaSbloccaUtente (login_usr) {

		postData = { login_usr : login_usr};
		// console.log (postData);
		$.ajax({
			type: 'POST',
			url: "19qry_BloccaSblocca_fam.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				// console.log(data.test);
				requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##fname##'");     
			}
		});

	}

	function DebugOGenitori (stato) {
		//passo a 19qry_SetToggle il valore corrente in modo che quella pagina lo possa invertire
		postData = { stato : stato};
		// console.log("19qry_iscrizioni - DebugOGenitori - postaData a 19qry_Toggle.php")	
		// console.log (postData);
		$.ajax({
			type: 'POST',
			url: "19qry_SetToggle.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				if (stato == 0) {
					$('#titolo01Msg_OK').html('INVIO EMAIL');
					$('#msg01Msg_OK').html("D'ora in avanti le email verranno inviate ai Genitori.<br>Premendo nuovamente è possibile continuare ad inviare all'email di debug.");
					$('#modal01Msg_OK').modal('show');
				}
				
				requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '19qry_Iscrizioni ##fname##'");     
			}
		});
	}


	function apriPortaleIscrizioni(login){

		//Ho messo il valore del parametro URLiscrizioni nella input nascosta: URLiscrizioni_hidden
		URLiscrizioni = $('#URLiscrizioni_hidden').val();
		var dummyContent = login;
		//creo una input e ci metto il valore della login e lo seleziono
		var dummy = $("<input id='tmplink'>").val(dummyContent).appendTo('body').select()
		//copio il valore
		document.execCommand('copy')
		//apro URL previsto in modo che io possa incollarci il valore della login
		window.open(URLiscrizioni, '_blank');
		//elimino la input creata temporaneamente
		var element =  document.getElementById('tmplink');
		element.remove();
		
	}

	function rightClickAlu(e, ID_alu) {
		$(".rightmenu").hide();
		console.log(ID_alu);
		e.preventDefault();
		msg = "Invia mail promemoria ai genitori";
		$("#rightmenuinputalu").val(msg);
		$("#rightmenualu"+ID_alu).show();
	}

	function rightClicked (ID_fam_alu, annoscolastico) {
		hideRightMenuAlu();
		inviaPromemoriaImpegni(ID_fam_alu, annoscolastico);
	}

	function hideRightMenuAlu(){
	 	$(".rightmenu").hide();
	}

	$(window).click(function() {
  		//nascondi il menu;
		  hideRightMenuAlu();
	});

	$('.rightmenu').click(function(event){
		//serve ad evitare
  		event.stopPropagation();
	});




//RIGHT CLICK FATTO DA ME: molto figo
	// function rightClick(e) {
	// 	e.preventDefault();
	// 	console.log (getPosition(e));
	// 	msg = "Invia mail promemoria ai genitori";
	// 	$("#rightmenuinput").val(msg);
	// 	// $("#rightmenuinput").css( {width: (msg.length * 7 +"px")});
	// 	$("#rightmenu").show();
	// 	$("#rightmenu").css({ left: getPosition(e).x +10 });
	// 	$("#rightmenu").css({ top: (getPosition(e).y -10) });
	// }

	// function hideRightMenu(){
	// 	$("#rightmenu").hide();
	// }

	// function getPosition(e) {
	// 	var posx = 0;
	// 	var posy = 0;
	// 	if (!e) var e = window.event;
	// 	if (e.pageX || e.pageY) {
	// 		posx = e.pageX;
	// 		posy = e.pageY;
	// 	} else if (e.clientX || e.clientY) {
	// 		posx = e.clientX + document.body.scrollLeft + 
	// 						document.documentElement.scrollLeft;
	// 		posy = e.clientY + document.body.scrollTop + 
	// 						document.documentElement.scrollTop;
	// 	}
	// 	return {
	// 		x: posx,
	// 		y: posy
	// 	}
	// }

	// $(window).click(function() {
  	// 	//nascondi il menu;
	// 	  hideRightMenu();
	// });

	// $('#rightmenu').click(function(event){
	// 	//serve ad evitare
  	// 	event.stopPropagation();
	// });


</script>
