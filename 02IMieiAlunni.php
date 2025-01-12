<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
	include_once("classi/alunni.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>I Miei Alunni</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="assets/img/faviconbook.png" type="image/icon">
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
	<link href="assets/datetimepicker/datepicker.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="assets/bootstrap-select/bootstrap-select.css">
	<script src="assets/bootstrap-select/bootstrap-select.js"></script>
	<? $_SESSION['page'] = "I miei Alunni";?>
	<script src="assets/moment/moment.js" type="text/javascript"></script>
	<script src="assets/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
	<script src="assets/functions/functionsJS.js"></script>
</head>

<body>
	<? include("NavBar.php"); ?>
	<div id="main">
		<? include_once("assets/functions/lowreswarning.html"); ?>
		<div class="split left highres">
			<div id="combomaestri" class="mb20 absolute pull-right" >
				
			</div>
			<div class="frameTopLeft" style="padding-left: 20px;">
				<div class="row mt5">
					<select name="selectannoscolastico"  style="width: 140px;"  id="selectannoscolastico" onchange="ChangeAnnoScolastico();">
						<?foreach (GetArrayAnniScolasticiFrequentati() as $alunno) {
							?>
							<option value="<? echo ($alunno->annoscolastico_cla) ?>"  <? if ($alunno->annoscolastico_cla == $_SESSION["anno_corrente"]) { echo 'selected';}	?>><? echo ($alunno->annoscolastico_cla) ?></option><?
						}?>
					</select>
					<input class="tablecell5" type="text"  id="databaseA_hidden" name="databaseA" value = "<?=$_SESSION['databaseA']?>" hidden>
					a.s.
				</div>
				<div class="row mt5">
					<a id="mailtotutti" ><img href="" title="Invia Mail a tutti gli alunni selezionati" style="width: 25px; cursor: pointer" src='assets/img/Icone/envelope-regular.svg'></a>Invia mail 
				</div>
			</div>

			<? //include("assets/functions/combomaestro.php"); ?>
			<div class="mt30" style="text-align: right; margin-right: 5px; font-size: 24px; color: #3c3c3c;" >
				I Miei Alunni 
			</div>
			<table id="tabellaIMieiAlunni" style="margin-left: 50px; margin-top: 20px; margin-right: 5px;">
				<thead>
					<tr>
						<td>
							<input id="tipopagellaEL_hidden" style="width: 30px;" value = "1" hidden>
							<input id="tipopagellaME_hidden" style="width: 30px;" value = "1" hidden>
						</td>
					</tr>
					<tr>
						<td>
						</td>
						<td style="width:120px;">
							<input class="tablelabel0 w100" type="text" id="nome_alu" name="nome_alu" value = "NOME" disabled>
						</td>
						<td style="width:120px;">
							<input class="tablelabel0 w100" type="text" id="cognome_alu" name="cognome_alu" value = "COGNOME" disabled>
						</td>
						<td style="width:120px;">
							<input class="tablelabel0 w100" type="text" id="classe_alu" name="classe_alu" value = "Classe" disabled>
						</td>
						<td style="width:60px;">
							<input class="tablelabel0 w100" type="text" id="sezione_alu" name="sezione_alu" value = "Sez" disabled>
						</td>
						
					</tr>
					<tr>
						<td>
						</td>
						<td style="max-width:120px;">
							<button id="ordinacampo1" class="ordinabutton" onclick="ordina(1);" >--</button>
							<input class="tablecell3 filtercell" style="width: 70%;" type="text" onchange="requery();" id="filter1" name="filter1">				
						</td>
						<td style="max-width:120px;">
							<button id="ordinacampo2" class="ordinabutton" onclick="ordina(2);" >--</button>
							<input class="tablecell3 filtercell" style="width: 70%;" type="text" onchange="requery();" id="filter2" name="filter2">				
						</td>
						<td>
							<button id="ordinacampo3" class="ordinabutton" onclick="ordina(3);" >--</button>
							<input class="tablecell3 filtercell" style="width: 70%;" type="text" onchange="requery();" id="filter3" name="filter3">				
						</td>
						<td>
							<button id="ordinacampo4" class="ordinabutton" onclick="ordina(4);" >--</button>
							<input class="tablecell3 filtercell" style="width: 50%;" type="text" onchange="requery();" id="filter4" name="filter4">				
						</td>
					</tr>
				</thead>
				<tbody id="maintable">
				</tbody>
			</table>
		</div>
		<div class="split right highres" style="overflow-y: scroll;">
			<div id="alunnodettaglio" >
			</div>
		</div>
	</div>
</body>
</html>

<script>

	let consentiRunAway = true;

	$(document).ready(function(){
		
		ChangeAnnoScolastico();
		copyToHiddenAndSetSession();
		aggiornaComboMaestri();  //Attenzione: si porta dietro anche 	<input id="hidden_ID_mae" type="text" value ='<?//=$_SESSION['ID_mae'];?>' hidden>
		//requery();


		window.onbeforeunload = function(e) {
			if (!consentiRunAway) {
				return "ALERT"

			}
		}


	});




	
	function aggiornaComboMaestri() {
		annoscolastico_cma = $( "#selectannoscolastico option:selected" ).val();
		IDmaeTMP = $("#hidden_ID_mae").val();
		postData = { annoscolastico_cma: annoscolastico_cma, IDmaeTMP : IDmaeTMP};
		//console.log ("02IMieiAlunni.php- aggiornaComboMaestri - postData a 02qry_getComboMaestri.php");
		//console.log (postData);
		$.ajax({
			async: false,
			type: 'POST',
			url: "02qry_getComboMaestri.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log (html);
				$("#combomaestri").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02IMieiAlunni ##fname##'");      
			}
			
		});
	}
	
	function ordina(x) {
		let az_za_ord = $('#ordinacampo'+x).text();
		if (az_za_ord == 'az') { $('#ordinacampo'+x).text('za'); }
		if (az_za_ord == 'za') { $('#ordinacampo'+x).text('--'); }
		if (az_za_ord == '--') { $('#ordinacampo'+x).text('az'); }
		requery();
	}
	
	function requery(){

		const campo = [];
		const ord = [];
		const fil = [];

		campo[1] = "nome_alu";
		campo[2] = "cognome_alu";
		campo[3] = "tab_classialunni.classe_cla";
		campo[4] = "tab_classialunni.sezione_cla";
		//Valore del Filtro
		for (i = 1; i <= 4; i++) {
			ord[i] = $('#ordinacampo'+i).text();
		}
		for (i = 1; i <= 4; i++) {
			fil[i] = $('#filter'+i).val();
		}

		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		let ID_mae = $('#hidden_ID_mae').val();
		postData = { campo: campo, ord: ord, fil: fil, ID_mae: ID_mae, annoscolastico_cla: annoscolastico_cla};
		//console.log ("02IMieiAlunni.php- requery - postData a 02qry_IMieiAlunni.php");
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "02qry_IMieiAlunni.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				// console.log ("02IMieiAlunni.php- requery - ritorno da 02qry_IMieiAlunni.php");
				// console.log (html);
				$("#maintable").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02IMieiAlunni ##fname##'");      
			}
		});



	}
	

	function requerySetDocumenti(){
		let ord1 = $('#ordinacampo1Doc').text();
		let ord2 = $('#ordinacampo2Doc').text();
		let ord3 = $('#ordinacampo3Doc').text();
		let ord4 = $('#ordinacampo4Doc').text();
		let ID_alu_doc = $("#hidden_ID_alu").val();
		postData = {ord1: ord1, ord2: ord2, ord3: ord3, ord4:ord4, ID_alu_doc: ID_alu_doc};
		$.ajax({
			type: 'POST',
			url: "15qry_SetDocumenti.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintableDoc").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02inc_UploadFile ##requerySetDocumenti##'");     
			}
		});
	}

	function coloraRighe(ID_alu){
		//pulisco colore delle celle di tutte le righe
		$('#tabellaIMieiAlunni tbody tr:even td .tablecell3').css('background-color', '#e0e0e0').css('color', '#474747');
		$('#tabellaIMieiAlunni tbody tr:odd td .tablecell3').css('background-color', '#fff').css('color', '#474747');
		$('.val'+ID_alu).css('background-color', '#289bce').css('color', '#fff');
	}
	
	function copyToHiddenAndSetSession () {
		//console.log ($('#selectmaestro').val());
		let ID_mae = $('#selectmaestro').val();
		$('#hidden_ID_mae').val(ID_mae);
		//console.log ("02IMieiAlunni.php - copyToHiddenAndSetSession - hidden_ID_mae");
		//console.log ($('#hidden_ID_mae').val());
		postData = { ID_mae : ID_mae };
		$.ajax({
			type: 'POST',
			url: "11qry_SetSessionID_mae.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				//console.log ("02IMieiAlunni.php - copyToHiddenAndSetSession - ritorno da 11qry_SetSessionID_mae");
				//console.log (data.test);
				requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02IMieiAlunni ##fname##'");      
			}
		});
		
	}
	
	function ChangeAnnoScolastico(){

		let annoscolastico = $('#selectannoscolastico').val();
		postData = { annoscolastico : annoscolastico };
		//console.log ("02IMieiAlunni.php - ChangeAnnoScolastico - postData to 02qry_getTipoPagella.php");
		//console.log(postData);
		$.ajax({
			type: 'POST',
			url: "02qry_getTipoPagella.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				//console.log ("02IMieiAlunni.php - ChangeAnnoScolastico - ritorno da 02qry_getTipoPagella.php");
				//console.log(data.tipopagellaEL);
				//devo predisporre due campi, nei quali scrivere le due possibilità per EL e ME in quanto i led sono colorati poi in base alla selezione
				//di un alunno che non si sa, a priori, se sia di EL o ME.
				//accederò dunque a una o l'altra di queste due a seconda dell'alunno, e potrebbero essercene SIA di EL e SIA di ME
				$('#tipopagellaEL_hidden').val(data.tipopagellaEL);
				$('#tipopagellaME_hidden').val(data.tipopagellaME);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02IMieiAlunni ##fname##'");      
			}
		});

		$("#alunnodettaglio").html("");
		aggiornaComboMaestri();
		requery();
	}
	
</script>