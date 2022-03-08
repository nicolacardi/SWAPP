<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
	$role_usr = $_SESSION['role_usr'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Scheda Maestro</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="assets/img/faviconbook.png" type="image/icon">
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
   	<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">-->
	<link rel="stylesheet" href="assets/croppie/croppie.css" />
	<script src="assets/croppie/croppie.js"></script>
	<link href="assets/datetimepicker/datepicker.css" rel="stylesheet" type="text/css" />
	<script src="assets/moment/moment.js" type="text/javascript"></script>
	<script src="assets/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
	<script src="assets/functions/functionsJS.js"></script>
	<? $_SESSION['page'] = "Scheda Maestro";?>
</head>

<body>
	<? include("NavBar.php");?>
	<div id="main" >
		<div class="upper">
			<div class="titoloPagina" >
				Scheda Singolo Maestro o Dipendente
				<input id="role_usr" name="role_usr" value= "<?=$role_usr?>" hidden>
			</div>
			<div class="row">
				<div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-12 col-md-offset-0" style="text-align: center; font-size: 16px;">
					<div class="col-xs-12 col-sm-4 col-sm-offset-2 col-md-2 col-md-offset-4 itemSchedaAnagrafica">
						<div class="row">
							Nome
						</div>
						<div class="row">
							<input style="text-align: center;" class="search-box tablecell2" type="text"  id="nome_mae" name="nome_mae" <? if (isset ($_POST['nome_maeDaAltraPag'])) {echo ("value ='".$_POST['nome_maeDaAltraPag']."'");} ?> onchange="requery();">
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-2 itemSchedaAnagrafica">
						<div class="row">
							Cognome
						</div>
						<div class="row">
							<input style="text-align: center;" class="search-box tablecell2" type="text"  id="cognome_mae" name="cognome_mae" <?	if (isset ($_POST['cognome_maeDaAltraPag'])) { echo ("value ='".$_POST['cognome_maeDaAltraPag']."'");}?> onchange="requery();">
						</div>
					</div>
					<div class=" col-md-12 col-xs-12 itemSchedaAnagrafica" style=" margin-top: -5px; z-index: 15;">
						<div class="col-xs-12 col-md-4 col-md-offset-4" style="position: absolute;  left: 0px; text-align: center; padding:0px; ">
							<div id="showresult" style="text-align: center; cursor: default; z-index: 15;" ></div>
						</div>
					</div>
					<input id="ID_mae_det_hidden" name="ID_mae_det_hidden" <? 	if (isset ($_POST['ID_maeDaAltraPag'])) {echo ("value ='".$_POST['ID_maeDaAltraPag']."'");}?> hidden>
					<input id="pagtoshow_hidden" name="pagtoshow_hidden" value="<? if ($role_usr == 3) { echo ("Classi");} else {echo ("DatiAnagrafici");}?>" hidden>
				</div>
            </div>
			<div class="scroll" id="SchedaMaestro_det">
			</div>
		</div>
	</div>
</body>
</html>
<script>
	$(document).ready(function(){
		requery();
	});
		
	$('.search-box').on("keyup input", function(){
		// Get input value on change
		let role_usr = $('#role_usr').val();
		let inputVal = $(this).val();
		let resultDropdown = $("#showresult");
		if(inputVal.length){
			campo = $(this).attr("name");
				$.get("08qry_DropDown.php", {inputVal: inputVal, campo: campo, role_usr: role_usr}).done(function(data){
				// Display the returned data in browser
				resultDropdown.html(data);
				});
		} else {
			resultDropdown.empty();
		}
	});
	
	$(document).on("click", "#showresult p", function(){
		//quando si fa clic sulla dropdown che compare, accade questo
		//si pesca l'ID dalla stringa (che è nascosto)
		//si pesca il nome (prima di -)
		//si pesca il cognome (dopo -)
		selected = $(this).text();
		ID_mae = selected.substr(0,selected.indexOf("+"));
		nome_mae = $("#nomeselected"+ID_mae).val();
		cognome_mae = $("#cognomeselected"+ID_mae).val();
		$("#nome_mae").val(nome_mae);
		$("#cognome_mae").val(cognome_mae);
		$("#ID_mae_det_hidden").val(ID_mae); 
		$(this).parent("#showresult").empty();
		requery();
		//$("#pagtoshow_hidden").val("DatiAnagrafici");

		
	});
	
	$(document).on("click", ".showcomune p", function(){
		//campo = this.name;
		campo = $(this).parent().attr("name");
		selected = $(this).text();
		ID_cap = selected.substr(0,selected.indexOf("+"));
		comuneselected = $("#comuneselected"+ID_cap).val();
		provselected = $("#provselected"+ID_cap).val();
		paeseselected = "Italia";
		CAPselected = $("#CAPselected"+ID_cap).val();
		switch (campo) {
			case "showComuneNascita_new":
				$("#comunenascita_mae_new").val(comuneselected);
				$("#provnascita_mae_new").val(provselected);
				$("#paesenascita_mae_new").val(paeseselected);
			break;
			case "showComuneResidenza_new":
				$("#citta_mae_new").val(comuneselected);
				$("#prov_mae_new").val(provselected);
				$("#paese_mae_new").val(paeseselected);
				$("#CAP_mae_new").val(CAPselected);
			break;
			case "showComuneNascita_det":
				$("#comunenascita_mae_det").val(comuneselected);
				$("#provnascita_mae_det").val(provselected);
				$("#paesenascita_mae_det").val(paeseselected);
			break;
			case "showComuneResidenza_det":
				$("#citta_mae_det").val(comuneselected);
				$("#prov_mae_det").val(provselected);
				$("#paese_mae_det").val(paeseselected);
				$("#CAP_mae_det").val(CAPselected);
			break;
		}
			$(this).parent().empty();
	});
	
	function requery(){
		let ID_mae = $("#ID_mae_det_hidden").val(); 
		postData = { ID_mae : ID_mae };
		$.ajax({
			type: 'POST',
			url: "08qry_SchedaMaestro.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#SchedaMaestro_det").html(html);
				$("#conteggiorecord").html( $("#contarecord_hidden").val());
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '08SchedaMaestro ##fname##'");      
			}
		});
	}
	
</script>
