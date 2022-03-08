<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
	include_once("classi/alunni.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Quote Per Famiglia</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="assets/img/faviconbook.png" type="image/icon">
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
	<? $_SESSION['page'] = "Quote Annuali per Famiglia";?>
</head>

<body style="overflow-y: auto;">
	<? include("NavBar.php"); ?>
	<div id="main">
		<? include_once("assets/functions/lowreswarning.html"); ?>
		<div class="upper highres">	
			<div id="titolopagina" class="titoloPagina" >
				Quote annuali per Famiglia
			</div>

			<div class="frameXlDownload">
				<div class="row center">
					download excel
				</div>
				<div>
					<select class="selectXl" id="selectDownloadExcel">
						<option value="DownloadExcelRettePerFamiglia">Rette per Famiglia</option>
					</select>
					<img onclick="DownloadExcel()" class="miniButtonXl" src='assets/img/Icone/logoexcel2019.svg'>
				</div>
			</div>
			<div class="sottotitoloPagina">
				(Esclusa lista d'attesa)
			</div>
			<div class="frameTopLeft">
				<div class="row mt5">
						<select name="selectannoscolastico" style="width: 140px" id="selectannoscolastico" onchange="requery(1);">
						<?foreach (GetArrayAnniScolasticiFrequentati() as $alunno) {
							?> <option value="<? echo ($alunno->annoscolastico_cla) ?>"
							<?
							if (isset ($_POST['annoscolasticoDaCruscotto'])) {
								if ($alunno->annoscolastico_cla == $_POST['annoscolasticoDaCruscotto']) { echo 'selected';}
							} else if ($alunno->annoscolastico_cla == $_SESSION['anno_corrente']) { echo 'selected';}	?>><? echo ($alunno->annoscolastico_cla) ?></option><?
							}?>
						</select>
					a.s.
				</div>
			</div>
			<div class="col-md-12" style="text-align: center;">
				<table id="tabellaRettePerFamiglia" style="margin-top: 20px; margin-left: 40px; ">
					<thead>
						<tr>
							<th style="width: 2%;">
							</th>
							<th style="width: 5%;">

							</th>
							<th style="width: 120px">

							</th>
							<th>
							</th>
							<th>
							</th>
							<th>
								<input class="tablelabel0" id="SuperTOTD" style="color: grey; background-color: white;" type="text" >
							</th>
							<th>
								<input class="tablelabel0" id="SuperTOTC" style="color: grey; background-color: white;" type="text" >
							</th>
							<th>
								<input class="tablelabel0" id="SuperTOTD_C" style="color: grey; background-color: white;" type="text" >
							</th>
							<th>
								<input class="tablelabel0" id="SuperTOTP" style="color: grey; background-color: white;" type="text" >
							</th>
							<th>
								<input class="tablelabel0" id="SuperTOTC_P" style="color: grey; background-color: white;" type="text" >
							</th>
							<th>
							</th>
							<th>
							</th>
						</tr>
						<tr>
							<th>
							</th>
							<th >
								<input class="tablelabel0" type="text" value = "COGNOMI" disabled>
							</th>
							<th style="width: 120px;">
								<input class="tablelabel0"  style="width: 90%;" type="text" value = "FRATELLI" disabled>
							</th>
							<th>
							</th>
							<th>
							</th>
							<th>
								<input class="tablelabel0" type="text" value = "DEFAULT (D)" disabled>
							</th>
							<th>
								<input class="tablelabel0" type="text" value = "CONCORDATE (C)" disabled>
							</th>
							<th>
								<input class="tablelabel0" type="text" value = "Agevolazione (D-C)" disabled>
							</th>
							<th>
								<input class="tablelabel0" type="text" value = "PAGATE (P)" disabled>
							</th>
							<th>
								<input class="tablelabel0" type="text" value = "Dovuto (C-P)" disabled>
							</th>
							<th style="width: 25%;">
								<input style="width: 98%;" class="tablelabel0" type="text" value = "Note" disabled>
							</th>
							<th>
							</th>
						</tr>
						<tr>
							<th>
							</th>
							<th>
								<button id="ordinacampo1" class="ordinabutton" onclick="ordina(1);" style="font-size:8px">--</button>
								<input style="width: 70%;" class="tablecell filtercell" type="text"  onchange="requery();" id="filter1" name="filter1">	
							</th>
							<th style="width: 120px;">
								<button id="ordinacampo2" class="ordinabutton" onclick="ordina(2);" style="font-size:8px">--</button>
							</th>
							<th>
							</th>
							<th>
							</th>
							<th>
								<button id="ordinacampo3" class="ordinabutton" onclick="ordina(3);" style="font-size:8px">--</button>
							</th>
							<th>
								<button id="ordinacampo4" class="ordinabutton" onclick="ordina(4);" style="font-size:8px">--</button>
							</th>
							<th>
								<button id="ordinacampo5" class="ordinabutton" onclick="ordina(5);" style="font-size:8px">--</button>
							</th>
							<th>
								<button id="ordinacampo6" class="ordinabutton" onclick="ordina(6);" style="font-size:8px">--</button>
							</th>
							<th>
								<button id="ordinacampo7" class="ordinabutton" onclick="ordina(7);" style="font-size:8px">--</button>
							</th>
						</tr>
					</thead>
					<tbody class="scroll" id="maintable"  >
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!--<div class="lower">
		<hr style="height: 12px;   border: 0;   box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5); margin-bottom: 0px; margin-top: 0px;">
		<div id="alunnodettaglio">
		</div>
	</div>-->
	
</body>
</html>

<script>

	$(document).ready(function(){
		resetResolution();
		requery();
	});
	
	function resetResolution () {
		let offset = $("#tabellaRettePerFamiglia > tbody").offset();
		$('#tabellaRettePerFamiglia > tbody').css('max-height', (($(window).height())-offset.top-30)+'px');
	}
	
	function ordina(x) {
		let az_za_ord = $('#ordinacampo'+x).text();
		if (az_za_ord == 'az') { $('#ordinacampo'+x).text('za'); }
		if (az_za_ord == 'za') { $('#ordinacampo'+x).text('--'); }
		if (az_za_ord == '--') { $('#ordinacampo'+x).text('az'); }
		requery();
	}
	
	function requery(){
		let ord1 = $('#ordinacampo1').text();
		let ord2 = $('#ordinacampo2').text();
		let ord3 = $('#ordinacampo3').text();
		let ord4 = $('#ordinacampo4').text();
		let ord5 = $('#ordinacampo5').text();
		let ord6 = $('#ordinacampo6').text();
		let ord7 = $('#ordinacampo7').text();
		
		let fil1 = $('#filter1').val();
		let annoscolastico_ret = $( "#selectannoscolastico option:selected" ).val();
		postData = { campo1 : "cognomi", annoscolastico_ret: annoscolastico_ret, ord1: ord1, ord2: ord2, ord3: ord3, ord4: ord4, ord5: ord5, ord6: ord6, ord7: ord7, fil1: fil1};
		// console.log ("05RettePerFamiglia.php - requery - postData a 05qry_RettePerFamiglia.php");
		// console.log (postData);		   
		$.ajax({
			type: 'POST',
			url: "05qry_RettePerFamiglia.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log (html);
				$("#maintable").html(html);
				$("#conteggiorecord").html( $("#contarecord_hidden").val());
				numRecord = parseInt($("#conteggiorecord").html());
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '05RettePerFamiglia ##fname##'");      
			}
		});
	}

	function DownloadExcel() {
		let downloadType = $( "#selectDownloadExcel option:selected" ).val();
		window[downloadType]();
	}

	function DownloadExcelRettePerFamiglia() {
		let annoscolastico_ret = $("#selectannoscolastico").val();
		window.location.href='05downloadRettePerFamiglia.php?annoscolastico_cla='+annoscolastico_ret;
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
	
</script>
