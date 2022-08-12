<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
	include_once("classi/alunni.php");?>
<!DOCTYPE html>
<html>
<head>
	<title>Cruscotto</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="assets/img/faviconbook.png" type="image/icon">
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
	<link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
	<? $_SESSION['page'] = "Cruscotto";?>
</head>
<body style="overflow-x: auto;">
	<? include("NavBar.php"); ?>
	<div id="main">
		<div class="upper" style="overflow-y: auto !important;">
			<div class="titoloPagina" >
				Cruscotto
			</div>
			<input class="ml50" id="usr" 					value = "<?=$_SESSION ['ID_usr'];?>"		 	hidden>
			<input class="ml50" id="role_usr_hidden" 		value = "<?=$_SESSION['role_usr']?>" 			hidden>
			<input class="ml50" id="data_limite_re_hidden" 	value = "<?=$_SESSION['data_limite_re']?>" 		hidden>
			<input class="ml50" id="primo_giorno_re_hidden" value = "<?=$_SESSION['primo_giorno_re']?>" 	hidden>
			<input class="ml50" id="nido" 					value = "<?=$_SESSION['nido']?>" 				hidden>
			<input class="ml50" id="materna" 				value = "<?=$_SESSION['materna']?>" 			hidden>
			<input class="ml50" id="elementari" 			value = "<?=$_SESSION['elementari']?>" 			hidden>
			<input class="ml50" id="medie" 					value = "<?=$_SESSION['medie']?>" 				hidden>
			<input class="ml50" id="superiori" 				value = "<?=$_SESSION['superiori']?>" 			hidden>


			<div class="frameTopCenter" style="padding-left: 20px;">
				<div class="row mt5">
						<select name="selectannoscolastico"  style="width: 140px;  margin-left: 0px"  id="selectannoscolastico" onchange="requery();">
							<?foreach (GetArrayAnniScolasticiFrequentati() as $alunno) {
								?> <option value="<? echo ($alunno->annoscolastico_cla) ?>"  <? if ($alunno->annoscolastico_cla == $_SESSION['anno_corrente']) { echo 'selected';}	?>><? echo ($alunno->annoscolastico_cla) ?></option><?
							}?>
						</select>
					a.s.
				</div>

				<div class="row mt5">
					<select name="selectlistaattesa"  style="width: 140px;  margin-left: 0px"  id="selectlistaattesa" onchange="requery();">	
						<option value="1">Solo Lista D'Attesa</option>
						<option value="0" selected>Nascondi Lista D'attesa</option>
						<option value="All">Mostra Tutti</option>
					</select>
				</div>

			</div>

			<div class="col-md-12" style="margin-top: 5px; text-align: center;">
				<div class="<? if ($role_usr <= 1 || $role_usr ==4) { echo 'col-md-1 col-sm-1 ';} else {echo 'col-md-3';}?> hidden-sm-1 hidden-xs hidden-" style="">
					<!--Colonna per Famiglie e numero alunni per classe-->
				</div>
				<div class="<? if ($role_usr <= 1 || $role_usr ==4) { echo 'col-md-4 col-sm-10 ';} else {echo 'col-md-6';}?> col-xs-12" >
					<!--Colonna per Famiglie e numero alunni per classe-->
					<div>
						<table class="table" style="margin: auto; background-color: rgba(255,255,255, 0.6)">
							<tbody>
								<tr style="border: 1px solid grey;">
									<td style="border: 0px;"> Numero Famiglie*</td>
									<td style="border: 0px;" id="NFamiglie"></td>
								</tr>
							</tbody>
						</table>
						<table id="tabellaAlunniCruscotto" class="table" style="margin: auto; margin-top: 10px; ">
							<thead>
								<tr style= "height: 60px; border: 1px solid grey; background-image: url('assets/img/backgroundcell.jpg') !important; ">
									<th scope="col" style="width: 40%;"></th>
									<th scope="col">Alunni*</th>
									<th scope="col">M</th>
									<th scope="col">F</th>
									<th scope="col" style="font-size: 11px;">Prima a.s. +1**</th>
									<th scope="col" style="font-size: 11px;">a.s. +1**<img href="" title="" style="width: 12px; position:absolute; margin-left: -17px; margin-top: -30px; " src='assets/img/Icone/crown3.svg'></th>
									<th scope="col" class="hideonlessthan1280" style="font-size: 11px;">Prima a.s. +2**</th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<span style="font-size: 10px;">(*sono esclusi gli alunni ritirati in corso d'anno)</span><br>
					<span style="font-size: 10px;">(**calcolati dalla data di nascita)</span>
				</div>
				<div class="col-md-2 col-sm-1 hidden-xs hidden-"> <!--Colonna vuota-->
				</div>
				<? if ($role_usr <= 1 || $role_usr ==4) { ?>
				<div class="col-md-4 col-sm-12 col-xs-12 col-12" style=" margin: auto;"> <!--Colonna per Intestazioni rette, rette nominali, concordate, pagate-->
					<table id="tabellaRetteCruscotto" class="table" style="margin-top: 0px;  " >
						<thead>
							<tr style= "border: 1px solid grey; background-image: url('assets/img/backgroundcell.jpg') !important; ">
								<th scope="col"></th>
								<th scope="col" class="hideonlessthan1280" >Quote Teoriche</th>
								<th scope="col">Quote Concordate</th>
								<th scope="col">Quote Pagate</th>
								<th scope="col">Quote Pagate (Fin.)</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<?}?>
			</div>
		</div>
	</div>


	<?include_once("11modalNews.php");?>



</body>
</html>

<script>




	$(document).ready(function(){
		requery();


		let role_usr = $("#role_usr_hidden").val();
		let ID_usr = $("#usr").val();
		postData = {ID_usr: ID_usr};
		//console.log ("11ilmioRegistro.php - document ready - postData to 11qry_getNonMostrarePiu");
		//console.log (postData);
		$.ajax({
			async: false,
			type: 'POST',
			url: "11qry_getNonMostrarePiu.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				//console.log ("11ilmioRegistro.php - document ready - ritorno da 11qry_getNonMostrarePiu");
				//console.log(data);
				nonmostrarepiu_usr = data.nonmostrarepiu_usr;
				//in questa pagina mostro le news ai non maestri (role_usr != 2 && != 3)
				if (nonmostrarepiu_usr == 0 && role_usr != 2 && role_usr != 3) {
					$('#modalNews').modal({show: 'true'});
				}
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '11Ilmioregistro ##fname##'");      
			}
		});



	});


	function SalvaNonMostrarePiu() {
		let cknonmostrarepiu_usr = $('#cknonmostrarepiu_usr').is(':checked');
		let ID_usr = $("#usr").val();
		if (cknonmostrarepiu_usr) {
			postData = {cknonmostrarepiu_usr: 1, ID_usr: ID_usr};
			//console.log (postData);
			
			$.ajax({
				url : "11qry_updateNonMostrarePiu.php",
				type: "POST",
				data : postData,
				dataType: "json",
				success:function(){
					//console.log (data.test);
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '11Ilmioregistro ##fname##'");      
				}
			});
		}
	}


	


	function requery(){


		console.log("09Cruscotto.php: entro in requery");
		var viewportWidth = $(window).width();
		if (viewportWidth < 1280) { hide = '; display:none;'; } else { hide = ""; }
		
	//recupero valori per numero famiglie e Alunni per ogni classe
		$("#tabellaAlunniCruscotto").find("tr:gt(0)").remove();
		$("#tabellaRetteCruscotto").find("tr:gt(0)").remove();

		let annoscolastico = $("#selectannoscolastico").val();
		let selectlistaattesa = document.getElementById("selectlistaattesa");
		let listaattesa = selectlistaattesa.options[selectlistaattesa.selectedIndex].value;
		let data_limite_re = $('#data_limite_re_hidden').val();
		let primo_giorno_re = $('#primo_giorno_re_hidden').val();
		postData = { annoscolastico : annoscolastico, listaattesa: listaattesa, data_limite_re: data_limite_re, primo_giorno_re: primo_giorno_re};
		//console.log("09Cruscotto.php - requery : postData a 09qry_CruscottoAlunniFamiglie");
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "09qry_CruscottoAlunniFamiglie.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				//console.log("09Cruscotto.php - requery : ritorno da 09qry_CruscottoAlunniFamiglie");
				//console.log(data.test);
				numeroFamiglie = data.numerofamiglie;
				$('#NFamiglie').html(numeroFamiglie);
				numeroClassi = data.numeroclassi;
				nomeSezione = data.nomesezione;
				numeroAlunni = data.numeroalunni;
				numeroMaschi = data.numeromaschi;
				numeroFemmine = data.numerofemmine;
				numeroAlunniPrima = data.numeroalunniprima;
				numeroAlunniPrima_2 = data.numeroalunniprima_2;
				numeroAlunniAnnoRe = data.numeroalunniannore;
				nomeClasse = data.nomeclasse;
				aselme = data.aselme;
				TotAlunni = 0 ;
				TotMaschi = 0 ;
				TotFemmine = 0 ;
				TotAlunniPrima = 0;
				TotAlunniPrima_2 = 0;
				TotAlunniAnnoRe = 0;
				TotAlunniNI = 0;
				TotAlunniAS = 0;
				TotAlunniEL = 0;
				TotAlunniME = 0;
				TotAlunniSU = 0;
				TotAlunniMaschiNI = 0;
				TotAlunniMaschiAS = 0;
				TotAlunniMaschiEL = 0;
				TotAlunniMaschiME = 0;
				TotAlunniMaschiSU = 0;
				TotAlunniFemmineNI = 0;
				TotAlunniFemmineAS = 0;
				TotAlunniFemmineEL = 0;
				TotAlunniFemmineME = 0;
				TotAlunniFemmineSU = 0;
				let role_usr = $('#role_usr_hidden').val();
				//console.log("09Cruscotto.php: role_usr"+ role_usr);
				for (i = 0; i < (numeroClassi+1); i++) {
					// console.log("09Cruscotto.php: nomeClasse + nomeSezione ("+i+")");
						console.log(nomeClasse[i]+nomeSezione[i]);
					// console.log("09Cruscotto.php: numeroAlunni("+i+")");
					 console.log(numeroAlunni[i]);
					// console.log("09Cruscotto.php: numeroAlunniPrima("+i+")");
					// console.log(numeroAlunniPrima[i]);
					// console.log("-------------------------------------------");

					// console.log ("09Cruscotto.php - requery: vado a scrivere: <tr><td style='text-align: left; '>"+nomeClasse[i]+' '+nomeSezione[i]+"</td><td style='text-align: center;'>"+numeroAlunni[i]+"</td><td style='text-align: center;'>"+numeroMaschi[i]+"</td><td style='text-align: center;'>"+numeroFemmine[i]+"</td><td style='text-align: center;'>"+numeroAlunniPrima[i]+"</td><td style='text-align: center;'>"+numeroAlunniAnnoRe[i]+"</td><td style='text-align: center;"+hide+"'>"+numeroAlunniPrima_2[i]+"</td><td style='"+hide+"'><button  onclick=\"postToAnagraficaPerAnno('"+listaattesa+"', '"+annoscolastico+"', '', '="+nomeClasse[i]+"', '"+nomeSezione[i]+"');\"><img style='width: 16px; cursor: pointer' src='assets/img/Icone/search-plus-solid.svg'></button></td></tr>");

					if (role_usr <= 1 || role_usr ==4) {
						$('#tabellaAlunniCruscotto tr:last').after("<tr><td style='text-align: left; '>"+nomeClasse[i]+' '+nomeSezione[i]+"</td><td style='text-align: center;'>"+numeroAlunni[i]+"</td><td style='text-align: center;'>"+numeroMaschi[i]+"</td><td style='text-align: center;'>"+numeroFemmine[i]+"</td><td style='text-align: center;'>"+numeroAlunniPrima[i]+"</td><td style='text-align: center;'>"+numeroAlunniAnnoRe[i]+"</td><td style='text-align: center;"+hide+"'>"+numeroAlunniPrima_2[i]+"</td><td style='"+hide+"'><button  onclick=\"postToAnagraficaPerAnno('"+listaattesa+"', '"+annoscolastico+"', '', '="+nomeClasse[i]+"', '"+nomeSezione[i]+"');\"><img style='width: 16px; cursor: pointer' src='assets/img/Icone/search-plus-solid.svg'></button></td></tr>");
					} else {
						$('#tabellaAlunniCruscotto tr:last').after("<tr><td style='text-align: left; '>"+nomeClasse[i]+' '+nomeSezione[i]+"</td><td style='text-align: center;'>"+numeroAlunni[i]+"</td><td style='text-align: center;'>"+numeroMaschi[i]+"</td><td style='text-align: center;'>"+numeroFemmine[i]+"</td><td style='text-align: center;'>"+numeroAlunniPrima[i]+"</td><td style='text-align: center;'>"+numeroAlunniAnnoRe[i]+"</td><td style='text-align: center;"+hide+"'>"+numeroAlunniPrima_2[i]+"</td><td></td></tr>");
					}
					TotAlunni = TotAlunni + numeroAlunni[i];
					TotMaschi = TotMaschi + numeroMaschi[i];
					TotFemmine = TotFemmine + numeroFemmine[i];
					TotAlunniPrima = TotAlunniPrima + numeroAlunniPrima[i];
					TotAlunniAnnoRe = TotAlunniAnnoRe + numeroAlunniAnnoRe[i];
					TotAlunniPrima_2 = TotAlunniPrima_2 + numeroAlunniPrima_2[i];
					switch (aselme[i]) {
						case "NI":
							TotAlunniNI = TotAlunniNI + numeroAlunni [i];
							TotAlunniMaschiNI = TotAlunniMaschiNI + numeroMaschi [i];
							TotAlunniFemmineNI = TotAlunniFemmineNI + numeroFemmine [i];
							break;
						case "AS":
							TotAlunniAS = TotAlunniAS + numeroAlunni [i];
							TotAlunniMaschiAS = TotAlunniMaschiAS + numeroMaschi [i];
							TotAlunniFemmineAS = TotAlunniFemmineAS + numeroFemmine [i];
							break;
						case "EL":
							TotAlunniEL = TotAlunniEL + numeroAlunni [i];
							TotAlunniMaschiEL = TotAlunniMaschiEL + numeroMaschi [i];
							TotAlunniFemmineEL = TotAlunniFemmineEL + numeroFemmine [i];

							break;
						case "ME":
							TotAlunniME = TotAlunniME + numeroAlunni [i];
							TotAlunniMaschiME = TotAlunniMaschiME + numeroMaschi [i];
							TotAlunniFemmineME = TotAlunniFemmineME + numeroFemmine [i];
							break;
						case "SU":
							TotAlunniSU = TotAlunniSU + numeroAlunni [i];
							TotAlunniMaschiSU = TotAlunniMaschiSU + numeroMaschi [i];
							TotAlunniFemmineSU = TotAlunniFemmineSU + numeroFemmine [i];
							break;
					}
				
				}
				if ($('#nido').val() == 'si') {
					$('#tabellaAlunniCruscotto tr:last').after("<tr style='font-weight: bold; color: black'><td style='text-align: left;'>TOT NIDO</td><td style='text-align: center;'>"+TotAlunniNI+"</td><td style='text-align: center;'>"+TotAlunniMaschiNI+"</td><td style='text-align: center;'>"+TotAlunniFemmineNI+"</td><td style='text-align: center;'>-</td><td style='text-align: center;'>-</td><td style='text-align: center;"+hide+"'>-</td><td><button onclick=\"postToAnagraficaPerAnno('"+listaattesa+"', '"+annoscolastico+"', 'NI', '', '');\"><img style='width: 16px; cursor: pointer' src='assets/img/Icone/search-plus-solid.svg'></button></td></tr>");
				}
				if ($('#materna').val() == 1) {
					$('#tabellaAlunniCruscotto tr:last').after("<tr style='font-weight: bold; color: black'><td style='text-align: left;'>TOT MATERNA</td><td style='text-align: center;'>"+TotAlunniAS+"</td><td style='text-align: center;'>"+TotAlunniMaschiAS+"</td><td style='text-align: center;'>"+TotAlunniFemmineAS+"</td><td style='text-align: center;'>"+TotAlunniPrima+"</td><td style='text-align: center;'>"+TotAlunniAnnoRe+"</td><td style='text-align: center;"+hide+"'>"+TotAlunniPrima_2+"</td><td><button  onclick=\"postToAnagraficaPerAnno('"+listaattesa+"', '"+annoscolastico+"', 'AS', '', '');\"><img style='width: 16px; cursor: pointer' src='assets/img/Icone/search-plus-solid.svg'></button></td></tr>");
				}
				if ($('#elementari').val() == 1) {
					$('#tabellaAlunniCruscotto tr:last').after("<tr style='font-weight: bold; color: black'><td style='text-align: left;'>TOT PRIMARIA</td><td style='text-align: center;'>"+TotAlunniEL+"</td><td style='text-align: center;'>"+TotAlunniMaschiEL+"</td><td style='text-align: center;'>"+TotAlunniFemmineEL+"</td><td style='text-align: center;'>-</td><td style='text-align: center;'>-</td><td style='text-align: center;"+hide+"'>-</td><td><button  onclick=\"postToAnagraficaPerAnno('"+listaattesa+"', '"+annoscolastico+"', 'EL', '', '');\"><img style='width: 16px; cursor: pointer' src='assets/img/Icone/search-plus-solid.svg'></button></td></tr>");
				}
				if ($('#medie').val() == 1) {
					$('#tabellaAlunniCruscotto tr:last').after("<tr style='font-weight: bold; color: black'><td style='text-align: left;'>TOT MEDIE</td><td style='text-align: center;'>"+TotAlunniME+"</td><td style='text-align: center;'>"+TotAlunniMaschiME+"</td><td style='text-align: center;'>"+TotAlunniFemmineME+"</td><td style='text-align: center;'>-</td><td style='text-align: center;'>-</td><td style='text-align: center;"+hide+"'>-</td><td><button  onclick=\"postToAnagraficaPerAnno('"+listaattesa+"', '"+annoscolastico+"', 'ME', '', '');\"><img style='width: 16px; cursor: pointer' src='assets/img/Icone/search-plus-solid.svg'></button></td></tr>");
				}
				if ($('#superiori').val() == 1) {
					$('#tabellaAlunniCruscotto tr:last').after("<tr style='font-weight: bold; color: black'><td style='text-align: left;'>TOT SUPERIORI</td><td style='text-align: center;'>"+TotAlunniSU+"</td><td style='text-align: center;'>"+TotAlunniMaschiSU+"</td><td style='text-align: center;'>"+TotAlunniFemmineSU+"</td><td style='text-align: center;'>-</td><td style='text-align: center;'>-</td><td style='text-align: center;"+hide+"'>-</td><td><button  onclick=\"postToAnagraficaPerAnno('"+listaattesa+"', '"+annoscolastico+"', 'SU', '', '');\"><img style='width: 16px; cursor: pointer' src='assets/img/Icone/search-plus-solid.svg'></button></td></tr>");
				}
				
				$('#tabellaAlunniCruscotto tr:last').after("<tr style='font-weight: bold; color: red'><td style='text-align: left;'>TOTALE</td><td style='text-align: center;'>"+TotAlunni+"</td><td style='text-align: center;'>"+TotMaschi+"</td><td style='text-align: center;'>"+TotFemmine+"</td><td style='text-align: center;'>"+TotAlunniPrima+"</td><td style='text-align: center;'>"+TotAlunniAnnoRe+"</td><td style='text-align: center;"+hide+"'>"+TotAlunniPrima_2+"</td></tr>");
				
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '09Cruscotto ##fname##'");     
			}
		});
		
		// ora costruisco gli array delle rette nella pagina 09qry_CruscottoRette.php
		//le rette Nominali, Concordate, Pagate e le differenze tra le prime due e tra le seconde due a livello aggregato
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "09qry_CruscottoRette.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				TotDefault_ret = data.TOTDefault_ret;
				TotConcordato_ret = data.TOTConcordato_ret;
				TotPagato_ret = data.TOTPagato_ret;
				TotPagato_retFin = data.TOTPagato_retFin;
				//console.log (TotPagato_retFin);
				let formatter = new Intl.NumberFormat('it-IT', {
					style: 'currency',
					currency: 'EUR',
					minimumFractionDigits: 0,
					// the default value for minimumFractionDigits depends on the currency
					// and is usually already 2
				});
				TotAnnoD = 0;
				TotAnnoC = 0;
				TotAnnoP = 0;
				TotAnnoPFin = 0;
				if (viewportWidth < 1280) {
					mesi = ["GEN", "FEB", "MAR", "APR", "MAG", "GIU", "LUG", "AGO", "SET", "OTT", "NOV", "DIC"];
				} else {
					mesi = ["GENNAIO", "FEBBRAIO", "MARZO", "APRILE", "MAGGIO", "GIUGNO", "LUGLIO", "AGOSTO", "SETTEMBRE", "OTTOBRE", "NOVEMBRE", "DICEMBRE"];
				}

				
				for (i = 9; i < (13); i++) {
					$("#tabellaRetteCruscotto tr:last").after("<tr><td style='text-align: left'>"+mesi[i-1]+"</td><td>"+formatter.format(TotDefault_ret[i])+"</td><td style='"+hide+"'>"+formatter.format(TotConcordato_ret[i])+"</td><td>"+formatter.format(TotPagato_ret[i])+"</td><td>"+formatter.format(TotPagato_retFin[i])+"</td></tr>");
					TotAnnoD = TotAnnoD + parseInt(TotDefault_ret[i]);
					TotAnnoC = TotAnnoC + parseInt(TotConcordato_ret[i]);
					TotAnnoP = TotAnnoP + parseInt(TotPagato_ret[i]);
					TotAnnoPFin = TotAnnoPFin + parseInt(TotPagato_retFin[i]);
				}
				for (i = 1; i < (9); i++) {
					$("#tabellaRetteCruscotto tr:last").after("<tr><td style='text-align: left'>"+mesi[i-1]+"</td><td style='"+hide+"'>"+formatter.format(TotDefault_ret[i])+"</td><td>"+formatter.format(TotConcordato_ret[i])+"</td><td>"+formatter.format(TotPagato_ret[i])+"</td>><td>"+formatter.format(TotPagato_retFin[i])+"</td></tr>");
					TotAnnoD = TotAnnoD + parseInt(TotDefault_ret[i]);
					TotAnnoC = TotAnnoC + parseInt(TotConcordato_ret[i]);
					TotAnnoP = TotAnnoP + parseInt(TotPagato_ret[i]);
					TotAnnoPFin = TotAnnoPFin + parseInt(TotPagato_retFin[i]);
				}
				$("#tabellaRetteCruscotto tr:last").after("<tr style='font-weight: bold; color: red'><td style='text-align: left'>TOT ANNO</td><td style='"+hide+"'>"+formatter.format(TotAnnoD)+"</td><td>"+formatter.format(TotAnnoC)+"</td><td>"+formatter.format(TotAnnoP)+"</td><td>"+formatter.format(TotAnnoPFin)+"</td></tr>");
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '09Cruscotto ##fname##'");      
			}
		});
	}
	
	function postToAnagraficaPerAnno(listaattesa, annoscolastico, aselme, classe, sezione) {
	//function postToAnagraficaPerAnno(listaattesa, annoscolastico, classe, sezione) {
		let form = $(document.createElement('form'));
		$(form).attr("action", "01AnagraficaPerAnno.php");
		$(form).attr("method", "POST");
		$(form).css("display", "none");
		let input_listaattesa = $("<input>")
		.attr("type", "text")
		.attr("name", "listaattesaDaCruscotto")
		.val(listaattesa);
		$(form).append($(input_listaattesa));
		let input_aselme = $("<input>")
		.attr("type", "text")
		.attr("name", "aselmeDaCruscotto")
		.val(aselme);
		$(form).append($(input_aselme));
		let input_classe = $("<input>")
		.attr("type", "text")
		.attr("name", "classeDaCruscotto")
		.val(classe);
		$(form).append($(input_classe));
		let input_sezione = $("<input>")
		.attr("type", "text")
		.attr("name", "sezioneDaCruscotto")
		.val(sezione);
		$(form).append($(input_sezione));
		let input_annoscolastico = $("<input>")
		.attr("type", "text")
		.attr("name", "annoscolasticoDaCruscotto")
		.val(annoscolastico);
		$(form).append($(input_annoscolastico));
		form.appendTo( document.body );
		$(form).submit();
	}
</script>
