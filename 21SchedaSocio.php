<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
	$role_usr = $_SESSION['role_usr'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Scheda Socio</title>
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
	<? $_SESSION['page'] = "Scheda Socio";?>
</head>

<body>
	<? include("NavBar.php");?>
	<div id="main" >
		<div class="upper">
			<div class="titoloPagina" >
				Scheda Singolo Socio
				<input id="role_usr" name="role_usr" value= "<?=$role_usr?>" hidden>
			</div>
			<div class="row">
				<div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-12 col-md-offset-0" style="text-align: center; font-size: 16px;">
					<div class="col-xs-12 col-sm-4 col-sm-offset-2 col-md-2 col-md-offset-4 itemSchedaAnagrafica">
						<div class="row">
							Nome
						</div>
						<div class="row">
							<input style="text-align: center;" class="search-box tablecell2" type="text"  id="nome_soc" name="nome_soc" <? if (isset ($_POST['nome_socDaAltraPag'])) {echo ("value ='".$_POST['nome_socDaAltraPag']."'");} ?> onchange="requery();">
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-2 itemSchedaAnagrafica">
						<div class="row">
							Cognome
						</div>
						<div class="row">
							<input style="text-align: center;" class="search-box tablecell2" type="text"  id="cognome_soc" name="cognome_soc" <?	if (isset ($_POST['cognome_socDaAltraPag'])) { echo ("value ='".$_POST['cognome_socDaAltraPag']."'");}?> onchange="requery();">
						</div>
					</div>
					<div class=" col-md-12 col-xs-12 itemSchedaAnagrafica" style=" margin-top: -5px; z-index: 15;">
						<div class="col-xs-12 col-md-4 col-md-offset-4" style="position: absolute;  left: 0px; text-align: center; padding:0px; ">
							<div id="showresult" style="text-align: center; cursor: default; z-index: 15;" ></div>
						</div>
					</div>
					<input id="ID_soc_det_hidden" name="ID_soc_det_hidden" <? 	if (isset ($_POST['ID_socDaAltraPag'])) {echo ("value ='".$_POST['ID_socDaAltraPag']."'");}?> hidden>
					<input id="pagtoshow_hidden" name="pagtoshow_hidden" value="<? if ($role_usr == 3) { echo ("Classi");} else {echo ("DatiAnagrafici");}?>" hidden>
				</div>
            </div>
			<div class="scroll" id="SchedaSocio_det">
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
				$.get("21qry_DropDown.php", {inputVal: inputVal, campo: campo, role_usr: role_usr}).done(function(data){
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
		ID_soc = selected.substr(0,selected.indexOf("+"));
		nome_soc = $("#nomeselected"+ID_soc).val();
		cognome_soc = $("#cognomeselected"+ID_soc).val();
		$("#nome_soc").val(nome_soc);
		$("#cognome_soc").val(cognome_soc);
		$("#ID_soc_det_hidden").val(ID_soc); 
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
				$("#comunenascita_soc_new").val(comuneselected);
				$("#provnascita_soc_new").val(provselected);
				$("#paesenascita_soc_new").val(paeseselected);
			break;
			case "showComuneResidenza_new":
				$("#citta_soc_new").val(comuneselected);
				$("#prov_soc_new").val(provselected);
				$("#paese_soc_new").val(paeseselected);
				$("#CAP_soc_new").val(CAPselected);
			break;
			case "showComuneNascita_det":
				$("#comunenascita_soc_det").val(comuneselected);
				$("#provnascita_soc_det").val(provselected);
				$("#paesenascita_soc_det").val(paeseselected);
			break;
			case "showComuneResidenza_det":
				$("#citta_soc_det").val(comuneselected);
				$("#prov_soc_det").val(provselected);
				$("#paese_soc_det").val(paeseselected);
				$("#CAP_soc_det").val(CAPselected);
			break;
		}
			$(this).parent().empty();
	});
	
	function requery(){
		let ID_soc = $("#ID_soc_det_hidden").val(); 
		postData = { ID_soc : ID_soc };
		$.ajax({
			type: 'POST',
			url: "21qry_SchedaSocio.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#SchedaSocio_det").html(html);
				$("#conteggiorecord").html( $("#contarecord_hidden").val());
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '21SchedaSocio ##requery##'");      
			}
		});
	}
	
</script>
