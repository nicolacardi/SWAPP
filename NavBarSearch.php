<?include_once("database/databaseii.php");
$input = $_POST['input'];

// RICERCA IN tab_anagraficaalunni e tab_famiglie
$sql = "SELECT DISTINCT ID_alu, ID_fam ";
$campidesc = array(
				"nome_alu"=>"Nome Alunno",
				"cognome_alu"=>"Cognome Alunno",
				"indirizzo_alu"=>"Indirizzo di Residenza",
				"citta_alu"=>"Comune di Residenza",
				"paese_alu"=>"Paese di Residenza",
				"comunenascita_alu"=>"Comune di Nascita",
				"paesenascita_alu"=>"Paese di Nascita",
				"cognomemadre_fam"=>"Cognome Madre",
				"nomemadre_fam"=>"Nome Madre",
				"nomepadre_fam"=>"Nome Padre",
				"telefonomadre_fam"=>"Telefono Madre",
				"altrotelmadre_fam"=>"Altro Tel. Madre",
				"telefonopadre_fam"=>"Telefono Padre",
				"altrotelpadre_fam"=>"Altro Tel. Padre",
				"emailpadre_fam"=>"e-mail Padre",
				"emailmadre_fam"=>"e-mail Madre",
				"paesenascitapadre_fam"=>"Paese di nascita Padre",
				"paesenascitamadre_fam"=>"Paese di nascita Madre",
				"profmadre_fam"=>"Professione Madre",
				"profpadre_fam"=>"Professione Padre"
			   
			   );
$campi = array("nome_alu",
			   "cognome_alu",
			   "indirizzo_alu",
			   "citta_alu",
			   "paese_alu",
			   "comunenascita_alu",
			   "paesenascita_alu",
			   "cognomemadre_fam",
			   "nomemadre_fam",
			   "nomepadre_fam",
			   	"telefonomadre_fam",
				"altrotelmadre_fam",
				"telefonopadre_fam",
				"altrotelpadre_fam",
				"emailpadre_fam",
				"emailmadre_fam",
				"paesenascitapadre_fam",
				"paesenascitamadre_fam",
				"profmadre_fam",
				"profpadre_fam");

$ncampi = count($campi);

for ($x = 0; $x <= $ncampi - 1; $x++) {
		$sql =$sql.", ". $campi[$x];
}

//$sql = $sql. " FROM (`tab_famiglie` JOIN `tab_anagraficaalunni` ON `ID_fam_alu` = `ID_fam`)  WHERE ";

$sql = $sql. " FROM ((`tab_famiglie` JOIN `tab_anagraficaalunni` ON `ID_fam_alu` = `ID_fam`)  LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) WHERE annoscolastico_cla = '".$_SESSION['anno_corrente']."'  AND listaattesa_cla = 0 ";
//QUERY PARAMETRICA DA FARE

for ($x = 0; $x <= $ncampi - 1; $x++) {
		$sqlOR =$sqlOR. "OR ". $campi[$x]. " LIKE ? ";
}

$sqlOR  = substr ($sqlOR, -(strlen($sqlOR)-2));

$sql = $sql. "AND ( ".$sqlOR. " );";


$xinputx = '%'.$input.'%';

//$stmt = mysqli_prepare($mysqli, $sql);
//mysqli_stmt_execute($stmt);
//mysqli_stmt_bind_result($stmt, $ID_alu, $ID_fam, $nome, $cognome);
//mysqli_stmt_bind_param($stmt, "ss",$xinputx , $xinputx); 
//mysqli_stmt_bind_result($stmt, $ID_alu, $ID_fam, $campi_ris[1], $campi_ris[2]);

$stmt = mysqli_prepare($mysqli, $sql);

for ($x = 1; $x <= $ncampi; $x++) {
	$strss= $strss."s";	
}

for ($x = 0; $x < $ncampi; $x++) {
	$fields_bind_param[$x] = $xinputx;
}
mysqli_stmt_bind_param($stmt, $strss, ...$fields_bind_param);



// ERA COSI'
// $fields_bind_param = array(&$stmt, $strss);
// for ($x = 1; $x <= $ncampi; $x++) {
// 		$fields_bind_param[$x+1] = $xinputx;
// 	}
// call_user_func_array('mysqli_stmt_bind_param', $fields_bind_param);





mysqli_stmt_execute($stmt);

$campi_ris = array();
$fields_bind_result= array(&$stmt, &$ID_alu, &$ID_fam);
for ($x = 1; $x <= $ncampi; $x++) {
	$fields_bind_result[$x+2] = & $campi_ris[$x];
}
call_user_func_array ("mysqli_stmt_bind_result", $fields_bind_result);
$n = 0;
$nn = 0;
while (mysqli_stmt_fetch($stmt)) {
	$nn++;
}
mysqli_stmt_execute($stmt);
call_user_func_array ("mysqli_stmt_bind_result", $fields_bind_result);
?>
<div class="col-md-10 col-md-offset-1">Parola cercata: '<?=$input?>'</div>
<div class="col-md-12" style="height: 500px; overflow-y: auto;">
	<table id="tabellaRisultati" style="margin-top: 10px; display: inline-block;">
		<thead>
			<tr>
				<th colspan="4" style="text-align: center;">
					- Risultati della ricerca nelle anagrafiche alunni FREQUENTANTI L'ANNO CORRENTE -
				</th>
			</tr>
			<tr>
				<th colspan="4" style="text-align: center;">
					- Trovate <?=$nn?> corrispondenze -
				</th>
			</tr>
			<tr>
				<th style="width: 70px;">
					<input class="tablelabel0" style="width: 70px;" type="text" value = "LINK" disabled>
				</th>
				<th style="width: 120px;">
					<input class="tablelabel0" style="width: 120px;" type="text" value = "NOME" disabled>
				</th>
				<th style="width: 120px;">
					<input class="tablelabel0" style="width: 120px;" type="text" value = "COGNOME" disabled>
				</th>
				<th style="width: 208px;" >
					<input class="tablelabel0"  style="width: 208px;" type="text" value = "Trovato il valore cercato in:" disabled>
				</th>
				
			</tr>
		</thead>
		<tbody>
			
			<?while (mysqli_stmt_fetch($stmt)) {
				$n++;?>
				<tr style="border-bottom: 1px solid grey;">
					<td style="width: 70px;">
						<button style="width: 30px; margin-top: 5px; margin-bottom: 5px; padding: 0px; height: 24px; " onclick="postToSchedaAlunno(<?=$ID_alu?>, &#34;<?=$campi_ris[1]?>&#34;, &#34;<?=$campi_ris[2]?>&#34;);">
							<img title="Vai a Scheda Alunno" class="iconaStd" src='assets/img/Icone/grey/06SchedaAlunno.svg' >
						</button>
						<button style="width: 30px; margin-top: 5px; margin-bottom: 5px; padding: 0px; height: 24px; " onclick="postToRette('<?=$_SESSION['anno_corrente']?>', &#34;<?=$campi_ris[2]?>&#34;);">
							<img title="<?echo("Vai a Quote Alunno per l'ANNO CORRENTE (".$_SESSION['anno_corrente'].")");?>" class="iconaStd" src='assets/img/Icone/grey/04Rette.svg' >     
						</button>
						
					</td>
					<td style="text-align: left; width: 120px;">
						<?echo ($campi_ris[1]);?>
					</td>
					<td style="text-align: left; width: 120px;">
						<?echo ($campi_ris[2]);?>
					</td>
					<td style="text-align: left; max-width: 208px;">
						<?for ($x = 1; $x <= $ncampi; $x++) {
							if (stripos($campi_ris[$x], $input) !== false) {
								$highlighted = str_ireplace ($input, "<span style='color: black; background-color: yellow;'>$input</span>", $campi_ris[$x]);
								echo (" [".$campidesc[$campi[$x-1]]." = ". $highlighted."] <br>");
							}
						}
						?>
					</td>
				</tr>
			<?}?>
			<?if ($n ==0) {?>
				<tr style="border-bottom: 1px solid grey;">
					<td style="text-align: center;" colspan="4">
						La ricerca non ha prodotto alcun risultato
					</td>
				</tr>
			<?}?>
		</tbody>
		
		
	</table>
	
	
<?
$sqlB = "SELECT DISTINCT ID_alu, ID_fam ";
for ($x = 0; $x <= $ncampi - 1; $x++) {
		$sqlB =$sqlB.", ". $campi[$x];
}
$sqlB = $sqlB. " FROM ((`tab_famiglie` JOIN `tab_anagraficaalunni` ON `ID_fam_alu` = `ID_fam`)  LEFT JOIN tab_classialunni ON ID_alu = ID_alu_cla) WHERE listaattesa_cla = 1 ";
$sqlB = $sqlB. "AND ( ".$sqlOR. " );";


$stmtB = mysqli_prepare($mysqli, $sqlB);

for ($x = 1; $x <= $ncampi; $x++) {
	$strssB= $strssB."s";	
}

for ($x = 0; $x < $ncampi; $x++) {
	$fields_bind_paramB[$x] = $xinputx;
}
mysqli_stmt_bind_param($stmtB, $strssB, ...$fields_bind_paramB);

mysqli_stmt_execute($stmtB);

$campi_risB = array();
$fields_bind_resultB= array(&$stmtB, &$ID_alu, &$ID_fam);
for ($x = 1; $x <= $ncampi; $x++) {
	$fields_bind_resultB[$x+2] = & $campi_risB[$x];
}
call_user_func_array ("mysqli_stmt_bind_result", $fields_bind_resultB);
$n = 0;
$nn = 0;
while (mysqli_stmt_fetch($stmtB)) {
	$nn++;
}
mysqli_stmt_execute($stmtB);
call_user_func_array ("mysqli_stmt_bind_result", $fields_bind_resultB);
?>
	
	
	
	<table id="tabellaRisultati2" style="margin-top: 10px; display: inline-block;">
		<thead>
			<tr>
				<th colspan="4" style="text-align: center;">
					- Risultati della ricerca nelle anagrafiche alunni IN LISTA D'ATTESA -
				</th>
			</tr>
			<tr>
				<th colspan="4" style="text-align: center;">
					- Trovate <?=$nn?> corrispondenze -
				</th>
			</tr>
			<tr>
				<th style="width: 70px;">
					<input class="tablelabel0" style="background-color: #467477; width: 70px;" type="text" value = "LINK" disabled>
				</th>
				<th style="width: 120px;">
					<input class="tablelabel0" style="background-color: #467477; width: 120px" type="text" value = "NOME" disabled>
				</th>
				<th style="width: 120px;">
					<input class="tablelabel0" style="background-color: #467477; width: 120px" type="text" value = "COGNOME" disabled>
				</th>
				<th style="width: 208px;">
					<input class="tablelabel0" style="background-color: #467477; width: 208px;" type="text" value = "Trovato il valore in:" disabled>
				</th>
				
			</tr>
		</thead>
		<tbody>
			
			<?while (mysqli_stmt_fetch($stmtB)) {
				$n++;?>
				<tr style="border-bottom: 1px solid grey;">
					<td style="width: 70px;">
						<button style="width: 30px; margin-top: 5px; margin-bottom: 5px; padding: 0px; height: 24px; " onclick="postToSchedaAlunno(<?=$ID_alu?>, &#34;<?=$campi_risB[1]?>&#34;, &#34;<?=$campi_risB[2]?>&#34;);">
						<img title="Vai a Scheda Alunno" class="iconaStd" src='assets/img/Icone/grey/06SchedaAlunno.svg' >
						</button>
						
					</td>
					<td style="text-align: left; width: 120px;">
						<?echo ($campi_risB[1]);?>
					</td>
					<td style="text-align: left; width: 120px;">
						<?echo ($campi_risB[2]);?>
					</td>
					<td style="text-align: left; max-width: 208px;">
						<?for ($x = 1; $x <= $ncampi; $x++) {
							if (stripos($campi_risB[$x], $input) !== false) {
								$highlighted = str_ireplace ($input, "<span style='color: black; background-color: yellow;'>$input</span>", $campi_risB[$x]);
								echo (" [".$campidesc[$campi[$x-1]]." = ". $highlighted."] <br>");
							}
						}
						?>
					</td>
				</tr>
			<?}?>
			<?if ($n ==0) {?>
				<tr style="border-bottom: 1px solid grey;">
					<td style="text-align: center;" colspan="4">
						La ricerca non ha prodotto alcun risultato
					</td>
				</tr>
			<?}?>
		</tbody>
		
		
	</table>

<?
$sqlC = "SELECT DISTINCT ID_alu, ID_fam ";
for ($x = 0; $x <= $ncampi - 1; $x++) {
		$sqlC =$sqlC.", ". $campi[$x];
}
$sqlC = $sqlC. " FROM ((`tab_famiglie` JOIN `tab_anagraficaalunni` ON `ID_fam_alu` = `ID_fam`))  WHERE ";
$sqlC = $sqlC. " ( ".$sqlOR. " );";

$stmtC = mysqli_prepare($mysqli, $sqlC);

for ($x = 1; $x <= $ncampi; $x++) {
	$strssC= $strssC."s";	
}

for ($x = 0; $x < $ncampi; $x++) {
	$fields_bind_paramC[$x] = $xinputx;
}
mysqli_stmt_bind_param($stmtC, $strssC, ...$fields_bind_paramC);

mysqli_stmt_execute($stmtC);

$campi_risC = array();
$fields_bind_resultC= array(&$stmtC, &$ID_alu, &$ID_fam);
for ($x = 1; $x <= $ncampi; $x++) {
	$fields_bind_resultC[$x+2] = & $campi_risC[$x];
}
call_user_func_array ("mysqli_stmt_bind_result", $fields_bind_resultC);
$n = 0;
$nn = 0;
while (mysqli_stmt_fetch($stmtC)) {
	$nn++;
}
mysqli_stmt_execute($stmtC);
call_user_func_array ("mysqli_stmt_bind_result", $fields_bind_resultC);
?>
	
	
	
	<table id="tabellaRisultati2" style="margin-top: 10px; display: inline-block;">
		<thead>
			<tr>
				<th colspan="4" style="text-align: center;">
					- Risultati della ricerca in tutte le anagrafiche alunni -
				</th>
			</tr>
			<tr>
				<th colspan="4" style="text-align: center;">
					- Trovate <?=$nn?> corrispondenze -
				</th>
			</tr>
			<tr>
				<th style="width: 70px;">
					<input class="tablelabel0" style="background-color: #c6ac12; width: 70px;" type="text" value = "LINK" disabled>
				</th>
				<th style="width: 120px;">
					<input class="tablelabel0" style="background-color: #c6ac12; width: 120px" type="text" value = "NOME" disabled>
				</th>
				<th style="width: 120px;">
					<input class="tablelabel0" style="background-color: #c6ac12; width: 120px" type="text" value = "COGNOME" disabled>
				</th>
				<th style="width: 208px;">
					<input class="tablelabel0" style="background-color: #c6ac12; width: 208px;" type="text" value = "Trovato il valore in:" disabled>
				</th>
				
			</tr>
		</thead>
		<tbody>
			
			<?while (mysqli_stmt_fetch($stmtC)) {
				$n++;?>
				<tr style="border-bottom: 1px solid grey;">
					<td style="width: 70px;">
						<button style="width: 30px; margin-top: 5px; margin-bottom: 5px; padding: 0px; height: 24px; " onclick="postToSchedaAlunno(<?=$ID_alu?>, &#34;<?=$campi_risC[1]?>&#34;, &#34;<?=$campi_risC[2]?>&#34;);">
						<img title="Vai a Scheda Alunno" class="iconaStd" src='assets/img/Icone/grey/06SchedaAlunno.svg' >
						</button>
						
					</td>
					<td style="text-align: left; width: 120px;">
						<?echo ($campi_risC[1]);?>
					</td>
					<td style="text-align: left; width: 120px;">
						<?echo ($campi_risC[2]);?>
					</td>
					<td style="text-align: left; max-width: 208px;">
						<?for ($x = 1; $x <= $ncampi; $x++) {
							if (stripos($campi_risC[$x], $input) !== false) {
								$highlighted = str_ireplace ($input, "<span style='color: black; background-color: yellow;'>$input</span>", $campi_risC[$x]);
								echo (" [".$campidesc[$campi[$x-1]]." = ". $highlighted."] <br>");
							}
						}
						?>
					</td>
				</tr>
			<?}?>
			<?if ($n ==0) {?>
				<tr style="border-bottom: 1px solid grey;">
					<td style="text-align: center;" colspan="4">
						La ricerca non ha prodotto alcun risultato
					</td>
				</tr>
			<?}?>
		</tbody>
		
		
	</table>
	
	<?// RICERCA IN tab_anagraficamaestri
	$sqlm = "SELECT ID_mae ";
	$campidescm = array(
					"nome_mae"=>"Nome Personale",
					"cognome_mae"=>"Cognome Personale",
					"indirizzo_mae"=>"Indirizzo di Residenza",
					"citta_mae"=>"Comune di Residenza",
					"paese_mae"=>"Paese di Residenza",
					"comunenascita_mae"=>"Comune di Nascita",
					"paesenascita_mae"=>"Paese di Nascita",
					"telefono_mae"=>"Telefono",
					"email_mae"=>"e-mail",
				   );
	$campim = array("nome_mae",
				   "cognome_mae",
				   "indirizzo_mae",
				   "citta_mae",
				   "paese_mae",
				   "comunenascita_mae",
				   "paesenascita_mae",
					"telefono_mae",
					"email_mae"
					);
	
	$ncampim = count($campim);
	
	for ($x = 0; $x <= $ncampim - 1; $x++) {
			$sqlm =$sqlm.", ". $campim[$x];
	}
	
	$sqlm = $sqlm. " FROM tab_anagraficamaestri WHERE ";
	
	for ($x = 0; $x <= $ncampim - 1; $x++) {
			$sqlORm =$sqlORm. "OR ". $campim[$x]. " LIKE ? ";
	}
	
	$sqlORm  = substr ($sqlORm, -(strlen($sqlORm)-2));
	
	$sqlm = $sqlm. $sqlORm. ";";
	
	// echo $sqlm;
	
	//$stmt = mysqli_prepare($mysqli, $sql);
	//mysqli_stmt_execute($stmt);
	//mysqli_stmt_bind_result($stmt, $ID_alu, $ID_fam, $nome, $cognome);
	//mysqli_stmt_bind_param($stmt, "ss",$xinputx , $xinputx); 
	//mysqli_stmt_bind_result($stmt, $ID_alu, $ID_fam, $campi_ris[1], $campi_ris[2]);
	
	$stmtm = mysqli_prepare($mysqli, $sqlm);

	for ($x = 1; $x <= $ncampim; $x++) {
		$strssm= $strssm."s";	
	}

	for ($x = 0; $x < $ncampim; $x++) {
		$fields_bind_paramm[$x] = $xinputx;
	}
	mysqli_stmt_bind_param($stmtm, $strssm, ...$fields_bind_paramm);

	mysqli_stmt_execute($stmtm);



	
	$campi_rism = array();
	$fields_bind_resultm= array(&$stmtm, &$ID_mae);
	for ($x = 1; $x <= $ncampim; $x++) {
		$fields_bind_resultm[$x+1] = & $campi_rism[$x];
	}
	call_user_func_array ("mysqli_stmt_bind_result", $fields_bind_resultm);
	$n = 0;
	
	$nn = 0;
	while (mysqli_stmt_fetch($stmtm)) {
		$nn++;
	}
	mysqli_stmt_execute($stmtm);
	call_user_func_array ("mysqli_stmt_bind_result", $fields_bind_resultm);
	?>
	
	
	<table id="tabellaRisultati" style="margin-top: 10px; display: inline-block;">
		<thead>
			<tr>
				<th colspan="4" class="center">
					- Risultati della ricerca nelle anagrafiche del Personale -
				</th>
			</tr>
			<tr>
				<th colspan="4" style="text-align: center;">
					- Trovate <?=$nn?> corrispondenze -
				</th>
			</tr>
			<tr>
				<th style="width: 70px;">
					<input class="tablelabel0" style="background-color: #8e0000; width: 70px;" type="text" value = "LINK" disabled>
				</th>
				<th style="width: 120px;">
					<input class="tablelabel0" style="background-color: #8e0000; width: 120px" type="text" value = "NOME" disabled>
				</th>
				<th style="width: 120px;">
					<input class="tablelabel0" style="background-color: #8e0000; width: 120px" type="text" value = "COGNOME" disabled>
				</th>
				<th style="width: 208px;">
					<input class="tablelabel0" style="background-color: #8e0000; width: 208px;" type="text" value = "Trovato il valore in:" disabled>
				</th>
				
			</tr>
		</thead>
		<tbody>
			
			<?while (mysqli_stmt_fetch($stmtm)) {
				$n++;?>
				<tr style="border-bottom: 1px solid grey;">
					<td style="width: 70px;">
						<button style="width: 30px; margin-top: 5px; margin-bottom: 5px; padding: 0px; height: 24px; " onclick="postToSchedaMaestro(<?=$ID_mae?>, '<?=$campi_rism[1]?>', '<?=$campi_rism[2]?>');">
						<img title="Vai a Scheda Maestro" class="iconaStd" src='assets/img/Icone/grey/08SchedaMaestro.svg' >
						</button>   
						
					</td>
					<td style="text-align: left; width: 120px;">
						<?echo ($campi_rism[1]);?>
					</td>
					<td style="text-align: left; width: 120px;">
						<?echo ($campi_rism[2]);?>
					</td>
					<td style="text-align: left; max-width: 208px;">
						<?for ($x = 1; $x <= $ncampi; $x++) {
							if (stripos($campi_rism[$x], $input) !== false) {
								$highlighted = str_ireplace ($input, "<span style='color: black; background-color: yellow;'>$input</span>", $campi_rism[$x]);
								echo (" [".$campidescm[$campim[$x-1]]." = ". $highlighted."] <br>");
							}
						}
						?>
					</td>
				</tr>
			<?}?>
			<?if ($n ==0) {?>
				<tr style="border-bottom: 1px solid grey;">
					<td style="text-align: center;" colspan="4">
						La ricerca non ha prodotto alcun risultato
					</td>
				</tr>
			<?}?>
		</tbody>
		
		
	</table>
</div>








<script>
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

	
	function postToRette(annoscolastico, cognome) {
		//non sarebbe corretto postare il cognome_alu, perchè questo è il cognomepadre_alu. Se c'è il caso di una famiglia in cui il cognome del padre non coincide con quello del figlio?
		//ad esempio se c'è una vedova...o se un figlio ha il cognome di un padre che non è quello "attuale" (vedi caso Kopeikina Pretto), ma sono casi limite
		
		let form = $(document.createElement('form'));
		$(form).attr("action", "04Rette.php");
		$(form).attr("method", "POST");
		$(form).css("display", "none");
		
		let input_annoscolastico = $("<input>")
		.attr("type", "text")
		.attr("name", "annoscolasticoDaRettePerFamiglia")
		.val(annoscolastico); //questo lo passo alla presente routine o lo pesco dalla combobox?
		$(form).append($(input_annoscolastico));

		let input_cognome = $("<input>")
		.attr("type", "text")
		.attr("name", "cognomeDaRettePerFamiglia")
		.val(cognome);
		$(form).append($(input_cognome));
		
		form.appendTo( document.body );
		$(form).submit();
	}
	
	function postToSchedaMaestro(ID, nome, cognome) {
		let form = $(document.createElement('form'));
		$(form).attr("action", "08SchedaMaestro.php");
		$(form).attr("method", "POST");
		$(form).css("display", "none");
	
		let input_IDmae = $("<input>")
		.attr("type", "text")
		.attr("name", "ID_maeDaAltraPag")
		.val(ID);
		$(form).append($(input_IDmae));
		
		let input_nomemae = $("<input>")
		.attr("type", "text")
		.attr("name", "nome_maeDaAltraPag")
		.val(nome);
		$(form).append($(input_nomemae));
		
		let input_cognomemae = $("<input>")
		.attr("type", "text")
		.attr("name", "cognome_maeDaAltraPag")
		.val(cognome);
		$(form).append($(input_cognomemae));
		
		form.appendTo( document.body );
		
		$(form).submit();
	}
</script>