<?	include_once("database/databaseii.php");		
	include_once("assets/functions/functions.php");
/*costruisco la clasuola ORDER BY sulla base di tutti i valori di ord */

	if (isset ($_POST['ord1']))
	{
		$ord1 = $_POST['ord1'];
		$ordsql = orderbysql( $ord1, 'cognomi', $ordsql);
	} 
	if (isset ($_POST['ord2']))
	{
		$ord2 = $_POST['ord2'];
		$ordsql = orderbysql( $ord2, 'fratelli', $ordsql);
	} 
	if (isset ($_POST['ord3']))
	{
		$ord3 = $_POST['ord3'];
		$ordsql = orderbysql( $ord3, 'TOTD', $ordsql);
	} 
	if (isset ($_POST['ord4']))
	{
		$ord4 = $_POST['ord4'];
		$ordsql = orderbysql( $ord4, 'TOTC', $ordsql);
	} 
	if (isset ($_POST['ord5']))
	{
		$ord5 = $_POST['ord5'];
		$ordsql = orderbysql( $ord5, 'TOTD_C', $ordsql);
	} 
	if (isset ($_POST['ord6']))
	{
		$ord6 = $_POST['ord6'];
		$ordsql = orderbysql( $ord6, 'TOTP', $ordsql);
	} 
	if (isset ($_POST['ord7']))
	{
		$ord7 = $_POST['ord7'];
		$ordsql= orderbysql( $ord7, 'TOTC_P', $ordsql);
	} 
	

	function orderbysql ($ordF, $campo, $ordsqF) {
		switch ($ordF) {
			case '--' :
				break;
			case 'az' :
				$ordsqF = $ordsqF . ' , '. $campo. ' '. 'ASC ' ;
				break;
			case 'za':
				$ordsqF = $ordsqF . ' , '. $campo. ' '. 'DESC ' ;
				break;
		}
		return $ordsqF;
	}
		
	if ($ordsql == '') {
		$ordsql = ' ORDER BY TOTD_C DESC, cognomi ASC ';
	} else {
		$ordsql = ' ORDER BY ' .  substr($ordsql, 2) ;
	}
		
	// costruisco la clasuola FILTER BY sulla base di tutti i valori di fil
	if (isset ($_POST['fil1']))
	{
		$fil1 = addslashes($_POST['fil1']);
		$filsql = filterbysql( $fil1, 'CONCAT(cognomepadre_fam, "-", cognomemadre_fam)', $filsql);
	} 
	

	function filterbysql ($fil, $campo, $filsq) {
		switch ($fil) {
			case '' :
				break;
			default :
				//Se viene inserito un = altrimenti è un LIKE
				if (substr($fil,0,1) == '=') {
				$filsq = $filsq . " AND ". $campo. " = '". substr($fil, 1) ."' ";
				} else {
				$filsq = $filsq . " AND ". $campo. " LIKE '%". $fil ."%' ";
				}
				break;
		}
		return $filsq;
	}

	$annoscolastico_ret = $_POST['annoscolastico_ret'];
	//$sql = "SELECT cognomepadre_fam, ID_fam, COUNT(ID_alu)/12 as fratelli, SUM(default_ret) as TOTD, SUM(concordato_ret) as TOTC, SUM(pagato_ret) as TOTP, (SUM(default_ret) - SUM(concordato_ret)) as TOTD_C, (SUM(concordato_ret) - SUM(pagato_ret)) as TOTC_P, commento_com , SUM(case when default_ret <> 0 then 1 else 0 end)/(COUNT(ID_alu)/12) as RATE FROM (((tab_anagraficaalunni LEFT JOIN tab_famiglie ON ID_fam = ID_fam_alu) LEFT JOIN tab_mensilirette ON ID_alu = ID_alu_ret) LEFT JOIN tab_compensazionifamiglie ON ID_fam = ID_fam_com AND annoscolastico_ret = annoscolastico_com) WHERE annoscolastico_ret = ? ".$filsql."GROUP BY ID_fam_alu ".$ordsql;
	
	$sql = "SELECT CONCAT(cognomepadre_fam, '-',cognomemadre_fam) as cognomi, cognomepadre_fam, ID_fam, COUNT(ID_alu)/12 as fratelli, SUM(default_ret) as TOTD, SUM(concordato_ret) as TOTC, SUM(pagato_ret) as TOTP, (SUM(default_ret) - SUM(concordato_ret)) as TOTD_C, (SUM(concordato_ret) - SUM(pagato_ret)) as TOTC_P, commento_com , SUM(case when default_ret <> 0 then 1 else 0 end)/(COUNT(ID_alu)/12) as RATE FROM ((((tab_anagraficaalunni LEFT JOIN tab_famiglie ON ID_fam = ID_fam_alu) LEFT JOIN tab_mensilirette ON ID_alu = ID_alu_ret) LEFT JOIN tab_compensazionifamiglie ON ID_fam = ID_fam_com AND annoscolastico_ret = annoscolastico_com) LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla AND annoscolastico_cla = annoscolastico_ret) WHERE annoscolastico_ret = ? AND listaattesa_cla = 0 ".$filsql."GROUP BY ID_fam_alu, commento_com ".$ordsql;
	

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
	mysqli_stmt_bind_param($stmt, "s", $annoscolastico_ret);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	mysqli_stmt_bind_result($stmt, $cognomi, $cognomepadre_fam, $ID_fam, $fratelli, $TOTD, $TOTC, $TOTP, $TOTD_C, $TOTC_P, $commento_com, $RATE); 
	$riga = 0; //riga equivale al numero del record che si sta guardando della tabella rette
	$j = 0; //j è un numero che cresce di una unità ogni volta che scrivo un alunno.
	$SuperTOTD = 0;
	$SuperTOTC = 0;
	$SuperTOTP = 0;
	while (mysqli_stmt_fetch($stmt)) {
		$riga++;
		$SuperTOTC = $SuperTOTC + $TOTC;
		$SuperTOTD = $SuperTOTD + $TOTD;
		$SuperTOTP = $SuperTOTP + $TOTP;
		$j = $j+1;
		?>
		<tr>		
			<td style="width: 2%;">
				<?=$riga?>
			</td>
			<td style="width: 5%;">
				<input class="tablecell3 disab" type="text" value = "<?=$cognomi?>" disabled>
			</td>
			<td style="width: 120px;">
				<?
					$cognomifigli = '';
					$sql1 = "SELECT cognome_alu FROM tab_anagraficaalunni WHERE id_fam_alu = ?";
					$stmt1 = mysqli_prepare($mysqli, $sql1);
					mysqli_stmt_bind_param($stmt1, "s", $ID_fam);
					mysqli_stmt_execute($stmt1);
					mysqli_stmt_bind_result($stmt1, $cognome_alu);
					while (mysqli_stmt_fetch($stmt1)) {
						//$cognomifigli = $cognomifigli.",".$cognome_alu; //non vanno in verità concatenati ma sostituiti a ogni giro...
						$cognomifigli = $cognome_alu;
					}
					//$cognomifigli = substr($cognomifigli, 1);
				?>
				<input class="tablecell3 disab" style="width: 50%; text-align: center;" type="text" value = "<? echo(intval($fratelli)) ?>" disabled>
				<button class="h24px" title="Mostra sulla base del cognome del padre" onclick="postToRette('<? echo ($annoscolastico_ret); ?>', '<? echo (addslashes($cognomifigli)) ?>');"><img class="iconaStd" src='assets/img/Icone/search-plus-solid.svg'></button>
			</td>
			<td style="width: 1%;">
				<button class="h24px" title="Report Pagamenti della famiglia per l'anno selezionato" onclick="reportPagamentiFam('<? echo ($annoscolastico_ret); ?>', '<?echo ($ID_fam);?>');"><img class="iconaStd2" src='assets/img/Icone/pdf.svg'></button>
			</td>
			<td style="width: 1%;">
				<input class="tablecell3 disab" style="width: 20px; font-size:10px; text-align: center;" type="text" value = "<?=intval($RATE)?>" disabled>
			</td>

			<td style="width: 4%;">
				<input class="tablecell3 disab" style="text-align: center;" type="text" value = "<?=$TOTD?>" disabled>
			</td>
			<td style="width: 4%;">
				<input class="tablecell3 disab <?if ($TOTC<$TOTD) { echo ('warnconcordato');} ?>" style="text-align: center;" type="text" value = "<?=$TOTC?>" disabled>
			</td>
			<td style="width: 4%;">
				<input class="tablecell3 disab <?if ($TOTC<$TOTD) { echo ('warnconcordato');} ?>"  style="text-align: center;" type="text" value = "<?=$TOTD_C?>" disabled>
			</td>
			<td style="width: 4%;">
				<input class="tablecell3 disab <?if ($TOTP<$TOTC) { echo ('warnpagato');} ?>"  style="text-align: center;" type="text" value = "<?=$TOTP?>" disabled>
			</td>
			<td style="width: 4%;">
				<input class="tablecell3 disab <?if ($TOTP<$TOTC) { echo ('warnpagato');} ?>"  style="text-align: center;" type="text" value = "<?=$TOTC_P?>" disabled>
			</td>
			<td>
				<input style="width: 98%;" class="tablecell3"  maxlength = "100" id="commento_com<?echo ($ID_fam);?>"  style="text-align: center;" type="text" value = "<?=$commento_com?>">
			</td>
			<td>
				<img title="Salva Nota" class="iconaStd" src='assets/img/Icone/save-regular.svg' onclick="salva('<?echo ($ID_fam."', '".$annoscolastico_ret) ;?>');">
			</td>
		</tr>
	<?}?>
	<input id="contarecord_hidden" value = "<?=$riga?>" hidden>

<script>


	$(document).ready(function(){

		let formatter = new Intl.NumberFormat('it-IT', {
		style: 'currency',
		currency: 'EUR',
		minimumFractionDigits: 1,
		// the default value for minimumFractionDigits depends on the currency
		// and is usually already 2
		});


		//scrivo i SuperTOT nei campi corrispondenti
		$('#SuperTOTD').val(formatter.format(<? echo $SuperTOTD; ?>));
		$('#SuperTOTC').val(formatter.format(<? echo $SuperTOTC; ?>));
		$('#SuperTOTP').val(formatter.format(<? echo $SuperTOTP; ?>));
		$('#SuperTOTD_C').val(formatter.format(<? echo ($SuperTOTD-$SuperTOTC); ?>));
		$('#SuperTOTC_P').val(formatter.format(<? echo ($SuperTOTC-$SuperTOTP); ?>));
		UniformaColonne();
	});

	function UniformaColonne () {
		const thElements = document.getElementsByTagName('th');
		const tdElements = document.getElementsByTagName('td');
		for (let i = 0; i < thElements.length; i++) {
			const widerElement = thElements[i].offsetWidth > tdElements[i].offsetWidth ? thElements[i] : tdElements[i], //? sta per condizione ? se vera : se falsa
			width = window.getComputedStyle(widerElement).width;
			//console.log ("i "+i+"-width "+width);
			thElements[i].style.width = tdElements[i].style.width = width;
		}
	}

	function salva(ID_fam, annoscolastico_ret) {
		//console.log (	$('#commento_com'+ID_fam).val());
		let postData = [];
		postData.push( {name: "ID_fam", value: ID_fam}  );
		postData.push( {name: "annoscolastico_com", value: annoscolastico_ret}  );
		postData.push( {name: "commento_com", value: $('#commento_com'+ID_fam).val()}  );
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "05qry_updateCommentoCompensazioniFamiglie.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				//console.log (data.sql); 
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '05qry_RettePerFamiglia ##fname##'");     
			}
		});
	}


	function reportPagamentiFam(annoscolastico, ID_fam) {

		url = "05downloadPagamentiSingolaFamiglia.php";
		let form = $('<form action="' + url + '"method="post"></form>');
		
		let input_annoscolastico = $("<input>")
		.attr("type", "text")
		.attr("name", "annoscolastico")
		.val(annoscolastico);
		$(form).append($(input_annoscolastico));
		
		let input_ID_fam = $("<input>")
		.attr("type", "text")
		.attr("name", "ID_fam")
		.val(ID_fam);
		$(form).append($(input_ID_fam));
		
		form.appendTo( document.body );
		
		$(form).submit();
	}

</script>