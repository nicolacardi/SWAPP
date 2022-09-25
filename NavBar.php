	<?$role_usr = $_SESSION['role_usr']?>
	<!--<link rel="stylesheet" href="assets/css/fontstyle.css">-->
	<? include("assets/functions/autologoff.php"); ?>
	<div class="showonlessthan1280" style="overflow: hidden;">
		<div class="topnav" style="background-color: rgba(0,0,0,0.9) !important;">

			<!-- Navigation links (hidden by default) -->
			<div id="topnavlinks" style="height: 0px; z-index: 120; position: relative; text-align: center; font-size: 18px; ">
				<br>
				<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {?>
					<div class="topnavlinka" style="color:grey;">
					<?if ($_SESSION['page']=="Scheda Alunno") {
						echo ("<a style='text-decoration: none;' class='hrefSelected' href='#'>Scheda Singolo Alunno</a>");
					} else {
						echo ("<a style='color:grey; text-decoration: none;' title='Scheda singolo Alunno' href='06SchedaAlunno.php' >Scheda Singolo Alunno</a>");
					}?>
					</div>				
				<?} ?>
				<br>
				<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {?>
					<div class="topnavlinka" >
					<?if ($_SESSION['page']=="Scheda Maestro") {
						echo ("<a style='text-decoration: none;' class='hrefSelected' href='#'>Scheda Singolo Maestro</a>");
					} else {
						echo ("<a style='color:grey;  text-decoration: none;' title='Scheda singolo Maestro' href='08SchedaMaestro.php' >Scheda Singolo Maestro</a>");
					}?>
					</div>				
				<?} ?>
				<br>
				<div class="topnavlinka" >
				<?
				if ($_SESSION['page']=="Cruscotto") {
					echo ("<a style='text-decoration: none;' class='hrefSelected' href='#'>Cruscotto</a>");
				} else {
					echo ("<a style='color:grey; text-decoration: none;' title='Cruscotto' href='09Cruscotto.php'>Cruscotto</a>");
				}?>
				</div>
				<br>
				<div class="topnavlinka" >
				<? if ($_SESSION['page']=="Emissione Documenti") {
					echo ("<a style='text-decoration: none;' class='hrefSelected' href='#'>Emissione Documenti</a>");
				} else {
					echo ("<a style='color:grey; text-decoration: none;' title='Emissione Documenti' href='12EmissioneDocumenti.php'>Emissione Documenti</a>");
				} ?>
				</div>
				<br>
				<div class="topnavlinka" >
					<a title='Logout' class="pointer" onclick="showModalLogout();"><img class='imgNotSelected' src='assets/img/Icone/grey/Logout.svg'><span class='txtMenu'>Logout</span></a>
				</div>
				<br>
			</div>
			<!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->

		</div>
		<a href="javascript:void(0);" style="position:absolute; left: 10px; top: 20px; z-index: 150;" onclick="toggleTopNav();">
			<img style="padding: 0px; margin-top: -5px; " src="assets/img/menu.png">
		</a>
	</div>

	<div id="mySidenav" class="sidenav hideonlessthan1280" style="overflow: hidden;">

		<?/*<a class='hideonlessthan1280 hrefSelected'  onclick="toggleNav();" href='#'><img style="width: 30px; padding-top: 5px;  overflow: hidden;" src="assets/img/xmenu.svg">

		<span class='txtMenuSelected ;' style="border: 1px solid grey; padding-top: 10px; padding-bottom: 11px; padding-left: 10px; border-radius: 4px; font-size: 10px; ">[User: <?echo($_SESSION['nome_mae']." ".$_SESSION['cognome_mae'])?>]
			<? $nomefile = "assets/photos/imgs/".$_SESSION['nome_mae'].$_SESSION['cognome_mae'].".png";
			if (file_exists($nomefile)) {
				echo ("<img class='imgSelected' style=' margin-left: 20px; overflow: hidden; width: 30px; border-radius: 50px; ' src='".$nomefile."'>");
			} else {
				
			}?></span>
			
		</a>*/?>
		<a class='hrefSelected hideonlessthan1280'  onclick="toggleNav();" href='#'><img style="width: 30px; padding-top: 5px;  overflow: hidden;" src="assets/img/xmenu.svg"></a>
		<? if ($role_usr <= 1  || $role_usr ==4) {?>
			<input style="position: absolute; width: 220px; top: 18px; left: 43px; text-align: left; background-color : rgba(255,255,255,0.6);" class="tablecell2 txtMenu" type="text"  placeholder="...digita almeno 3 caratteri" id="camporicerca" name="camporicerca"><img title="Ricerca nei seguenti campi:&#13;Nome Alunno&#13;Cognome Alunno&#13;Indirizzo di Residenza&#13;Comune di Residenza&#13;Paese di Residenza&#13;Comune di Nascita&#13;Paese di Nascita&#13;Cognome Madre&#13;Nome Madre&#13;Nome Padre&#13;Telefono Madre&#13;Altro Tel. Madre&#13;Telefono Padre&#13;Altro Tel. Padre&#13;e-mail Padre&#13;e-mail Madre&#13;Paese di nascita Padre&#13;Paese di nascita Madre" style="width: 22px; position: absolute; top: 18px; left:235px; cursor: pointer;" src='assets/img/Icone/search.svg' onclick="showModalRisultatiRicerca();">
		<?}?>
		<!--
		
		$role_usr = 0 	: superadmin
		$role_usr = 1	: amm + mae
		$role_usr = 2	: maestro solo
		$role_usr = 3	: supervisore maestro
		$role_usr = 4 	: amministratore solo
		
		-->
		<div class='hideonlessthan1280'>
			<? if ($role_usr == 0) {
				if ($_SESSION['page']=="Amministrazione SWAPP") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/15Use.svg'><span class='txtMenuSelected'>Overview Utilizzo SWAPP</span></a>");
				} else {
					echo ("<a title='Anagrafica Alunni' href='15AdmTools.php' ><img class='imgNotSelected' src='assets/img/Icone/grey/15Use.svg'><span class='txtMenu'>Overview Utilizzo SWAPP</span></a>");
				}
			} ?>
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {
				if ($_SESSION['page']=="Anagrafica Alunni") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/00Anagrafica.svg'><span class='txtMenuSelected'>Anagrafica Alunni</span></a>");
				} else {
					echo ("<a title='Anagrafica Alunni' href='00Anagrafica.php' ><img class='imgNotSelected' src='assets/img/Icone/grey/00Anagrafica.svg'><span class='txtMenu'>Anagrafica Alunni</span></a>");
				}
			} ?>
			
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {
				if ($_SESSION['page']=="Anagrafica x as") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/01AnagraficaFrequenzaRette.svg'><span class='txtMenuSelected'>Anagrafica Alunni per Classe</span></a>");
				} else {
					echo ("<a title='Anagrafica Alunni per Classe' href='01AnagraficaPerAnno.php'><img class='imgNotSelected' src='assets/img/Icone/grey/01AnagraficaFrequenzaRette.svg'><span class='txtMenu'>Anagrafica Alunni per Classe</span></a>");
				}
			} ?>
			
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {
				if ($_SESSION['page']=="Scheda Alunno") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/06SchedaAlunno.svg'><span class='txtMenuSelected'>Scheda singolo Alunno</span></a>");
				} else {
					echo ("<a title='Scheda singolo Alunno' href='06SchedaAlunno.php' ><img class='imgNotSelected' src='assets/img/Icone/grey/06SchedaAlunno.svg'><span class='txtMenu'>Scheda singolo Alunno</span></a>");
				}
			} ?>
			
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {
				if ($_SESSION['page']=="Iscrizioni") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/19Iscrizione.svg'><span class='txtMenuSelected'>Iscrizioni</span></a>");
				} else {
					echo ("<a title='Iscrizioni' href='19Iscrizioni.php' ><img class='imgNotSelected' src='assets/img/Icone/grey/19Iscrizione.svg'><span class='txtMenu'>Iscrizioni</span></a>");
				}
			} ?>
			
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {echo "<hr style='margin-top: 0px; margin-bottom: 0px; border-color:grey'>"; }?>
			
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {
				if ($_SESSION['page']=="Anagrafica Maestri") {
					echo ("<a class='hrefSelected' href='#' ><img class='imgSelected' src='assets/img/Icone/white/03AnagraficaMaestri.svg'><span class='txtMenuSelected'>Anagrafica Maestri & C</span></a>");
				} else {
					echo ("<a title='Anagrafica Maestri' href='03AnagraficaMaestri.php'><img class='imgNotSelected' src='assets/img/Icone/grey/03AnagraficaMaestri.svg'><span class='txtMenu'>Anagrafica Maestri & C</span></a>");
				}
			} ?>
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {
				if ($_SESSION['page']=="Formazione Maestri") {
					echo ("<a class=' hrefSelected' href='#' ><img class='imgSelected' src='assets/img/Icone/white/16FormazioneMaestri.svg'><span class='txtMenuSelected'>Formazione Maestri & C</span></a>");
				} else {
					echo ("<a title='Formazione Maestri' href='16FormazioneMaestri.php'><img class='imgNotSelected' src='assets/img/Icone/grey/16FormazioneMaestri.svg'><span class='txtMenu'>Formazione Maestri & C</span></a>");
				}
			} ?>
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr == 3 || $role_usr ==4) {
				if ($_SESSION['page']=="Scheda Maestro") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/08SchedaMaestro.svg'><span class='txtMenuSelected'>Scheda singolo Maestro</span></a>");
				} else {
					echo ("<a title='Scheda singolo Maestro' href='08SchedaMaestro.php' ><img class='imgNotSelected' src='assets/img/Icone/grey/08SchedaMaestro.svg'><span class='txtMenu'>Scheda singolo Maestro</span></a>");
				}
			} ?>
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {echo "<hr style='margin-top: 0px; margin-bottom: 0px; border-color:grey'>"; }?>
			
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {
				if ($_SESSION['page']=="Anagrafica Soci") {
					echo ("<a class='hrefSelected' href='#' ><img class='imgSelected' src='assets/img/Icone/white/20AnagraficaSoci.svg'><span class='txtMenuSelected'>Anagrafica Soci</span></a>");
				} else {
					echo ("<a title='Anagrafica Soci' href='20AnagraficaSoci.php'><img class='imgNotSelected' src='assets/img/Icone/grey/20AnagraficaSoci.svg'><span class='txtMenu'>Anagrafica Soci</span></a>");
				}
			} ?>
			
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr == 3 || $role_usr ==4) {
				if ($_SESSION['page']=="Scheda Socio") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/21SchedaSocio.svg'><span class='txtMenuSelected'>Scheda singolo Socio</span></a>");
				} else {
					echo ("<a title='Scheda singolo Socio' href='21SchedaSocio.php' ><img class='imgNotSelected' src='assets/img/Icone/grey/21SchedaSocio.svg'><span class='txtMenu'>Scheda singolo Socio</span></a>");
				}
			} ?>

			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {echo "<hr style='margin-top: 0px; margin-bottom: 0px; border-color:grey'>"; }?>
			
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {
				if ($_SESSION['page']=="Quote Mensili per Alunno") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/04Rette.svg'><span class='txtMenuSelected'>Quote mensili per Alunno</span></a>");
				} else {
					echo ("<a title='Quote mensili per Alunno' href='04Rette.php'><img class='imgNotSelected' src='assets/img/Icone/grey/04Rette.svg'><span class='txtMenu'>Quote mensili per Alunno</span></a>");
				}
			} ?>
			
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {
				if ($_SESSION['page']=="Quote Annuali per Famiglia") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/05RettePerFamiglia.svg'><span class='txtMenuSelected'>Quote annuali per Famiglia</span></a>");
				} else {
					echo ("<a title='Quote annuali per Famiglia' href='05RettePerFamiglia.php' ><img class='imgNotSelected' src='assets/img/Icone/grey/05RettePerFamiglia.svg'><span class='txtMenu'>Quote annuali per Famiglia</span></a>");
				}
			} ?>
			
			
			<? 
				if ($_SESSION['page']=="Cruscotto") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/09Cruscotto.svg'><span class='txtMenuSelected'>Cruscotto</span></a>");
				} else {
					echo ("<a title='Cruscotto' href='09Cruscotto.php'><img class='imgNotSelected' src='assets/img/Icone/grey/09Cruscotto.svg'><span class='txtMenu'>Cruscotto</span></a>");
				}			
			?>
			
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==4) {echo "<hr style='margin-top: 0px; margin-bottom: 0px; border-color:grey'>"; }?>
			
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==2 || $role_usr ==3) {
				if ($_SESSION['page']=="OrarioNew") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/07Orario.svg'><span class='txtMenuSelected'>Orario Settimanale per classe</span></a>");
				} else {
					echo ("<a title='Orario Settimanale per classe' href='07OrarioNew.php'><img class='imgNotSelected' src='assets/img/Icone/grey/07Orario.svg'><span class='txtMenu'>Orario Settimanale per classe</span></a>");
				}
			} ?>


			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==2 || $role_usr ==3) {
				if ($_SESSION['page']=="Il Mio Registro") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/11IlMioRegistro.svg'><span class='txtMenuSelected'>Il Mio Orario e Registro</span></a>");
				} else {
					echo ("<a title='Il Mio Orario e Registro' href='11IlmioRegistro.php'><img class='imgNotSelected' src='assets/img/Icone/grey/11IlMioRegistro.svg'><span class='txtMenu'>Il Mio Orario e Registro</span></a>");
				} 
			}?>
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==2 || $role_usr ==3) {
				if ($_SESSION['page']=="I miei Alunni") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/02IMieiAlunni.svg'><span class='txtMenuSelected'>I miei alunni</span></a>");
				} else {
					echo ("<a title='I miei alunni' href='02IMieiAlunni.php'><img class='imgNotSelected' src='assets/img/Icone/grey/02IMieiAlunni.svg'><span class='txtMenu'>I miei alunni</span></a>");
				} 
			}?>
			
			<? 
			// if ($role_usr == 0 || $role_usr == 1 || $role_usr ==2 || $role_usr ==3) {
			// 	if ($_SESSION['page']=="Appello") {
			//  		echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/20Appello.svg'><span class='txtMenuSelected'>Appello</span></a>");
			//  	} else {
			//  		echo ("<a title='Appello' href='20Appello.php'><img class='imgNotSelected' src='assets/img/Icone/grey/20Appello.svg'><span class='txtMenu'>Appello</span></a>");
			//  	} 
			// }
			?>

			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==2 || $role_usr ==3) {
				if ($_SESSION['page']=="Compiti e Verifiche") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/13CompitieVerifiche.svg'><span class='txtMenuSelected'>Compiti e Verifiche</span></a>");
				} else {
					echo ("<a title='Compiti e Verifiche' href='13CompitieVerifiche.php'><img class='imgNotSelected' src='assets/img/Icone/grey/13CompitieVerifiche.svg'><span class='txtMenu'>Compiti e Verifiche</span></a>");
				} 
			}?>
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==2 || $role_usr ==3) {
				if ($_SESSION['page']=="Verbali") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/14Verbali.svg'><span class='txtMenuSelected'>Verbali</span></a>");
				} else {
					echo ("<a title='Verbali' href='14Verbali.php'><img class='imgNotSelected' src='assets/img/Icone/grey/14Verbali.svg'><span class='txtMenu'>Verbali</span></a>");
				} 
			}?>
			
			<? /*if ($_SESSION['page']=="Programmazione") {
				echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/18Programmazione.svg'><span class='txtMenuSelected'>Programmazione</span></a>");
			} else {
				echo ("<a title='Programmazione' href='18Programmazione.php'><img class='imgNotSelected' src='assets/img/Icone/grey/18Programmazione.svg'><span class='txtMenu'>Programmazione</span></a>");
			} */?>
			
			<? if ($role_usr == 0 || $role_usr == 1 || $role_usr ==2 || $role_usr ==3) {
				if ($_SESSION['page']=="Emissione Documenti") {
					echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/12EmissioneDocumenti.svg'><span class='txtMenuSelected'>Emissione Documenti</span></a>");
				} else {
					echo ("<a title='Emissione Documenti' href='12EmissioneDocumenti.php'><img class='imgNotSelected' src='assets/img/Icone/grey/12EmissioneDocumenti.svg'><span class='txtMenu'>Emissione Documenti</span></a>");
				} 
			}?>
			
			<hr style="margin-top: 0px; margin-bottom: 0px; border-color:grey" >
			
			<? if ($_SESSION['page']=="Tutorials") {
				echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/17Tutorials.svg'><span class='txtMenuSelected'>Tutorials</span></a>");
			} else {
				echo ("<a title='Tutorials' href='17Tutorials.php'><img class='imgNotSelected' src='assets/img/Icone/grey/17Tutorials.svg'><span class='txtMenu'>Tutorials</span></a>");
			} ?>
			
			<? if ($_SESSION['page']=="Modifica Password") {
				echo ("<a class='hrefSelected' href='#'><img class='imgSelected' src='assets/img/Icone/white/10ModificaPassword.svg'><span class='txtMenuSelected'>Modifica Password</span></a>");
			} else {
				echo ("<a title='Modifica Password' href='10ModificaPassword.php'><img class='imgNotSelected' src='assets/img/Icone/grey/10ModificaPassword.svg'><span class='txtMenu'>Modifica Password</span></a>");
			} ?>
				<a title='Logout' class="pointer" onclick="showModalLogout();"><img class='imgNotSelected' src='assets/img/Icone/grey/Logout.svg'><span class='txtMenu'>Logout</span></a>
		</div>
	
	</div>

	<?include_once ("modal01Msg_OK.html");?>
	<?include_once ("modal02Msg_OKCancel.html");?>
	<?include_once ("modal03Msg_OKCancelPsw.html");?>
<script>
	$(document).ready(function(){
		var viewportWidth = $(window).width();
		if (viewportWidth < 1280) { $('.hideonlessthan1280').hide();} else { $('.hideonlessthan1280').show();}
		if (viewportWidth < 1280) { $('.showonlessthan1280').show();} else { $('.showonlessthan1280').hide();}
		
	});
	
	function toggleNav() {
		var x = document.getElementById("mySidenav");
		if (x.style.width == "270px") {
			$('.txtMenuSelected').hide();
			$('.txtMenu').hide();
			$(x).animate({
				width: '45px'
			}, 100);

		} else {
			//$(x).animate({width: '270px'}, 'slow');
			$(x).animate({
				width: '270px'
			}, 400, function () {
				$('.txtMenuSelected').show();
				$('.txtMenu').show();
			});

		}
	
		$("#camporicerca" ).val("");
	}
	
	function toggleTopNav() {
		var x = document.getElementById("topnavlinks");
		
		if (x.style.height == "0px") {
			$(x).animate({
				height: '275px'
			}, 100, function () {
				//x.style.display = "block";
			});

		} else {
			$(x).animate({
				height: '0px'
			}, 300, function () {
				//x.style.display = "none";
			});

		}
		//if (x.style.display == "block") {
		//  x.style.display = "none";
		//} else {
		//  x.style.display = "block";
		//}
		
	}
	
	function showModalLogout(){
		$('#titolo02Msg_OKCancel').html('LOGOUT');
		$('#msg02Msg_OKCancel').html("Sei sicuro di voler uscire?");
		$("#btn_OK02Msg_OKCancel").html("Esci");
		$("#btn_OK02Msg_OKCancel").attr("onclick","location.href = 'logout.php';");
		$('#modal02Msg_OKCancel').modal('show');
	}



	function showModalRisultatiRicerca(){
		let input = $( "#camporicerca" ).val();
		
		if ((input !="") && (input.length >2)){
			postData = { input: input};
			//console.log (postData);
			$.ajax({
				type: 'POST',
				url: "NavBarSearch.php",
				data: postData,
				dataType: 'html',
				success: function(html){

					//$("#modal-dialog01Msg_OK").width('50%');
					$("#msg01Msg_OK").addClass('row');
					$('#titolo01Msg_OK').html('RISULTATI RICERCA');
					$('#msg01Msg_OK').html(html);
					$('#modal01Msg_OK').modal('show');
					
							
					//$("#risultatiricerca").html(html);
					//$('#modalRisultatiRicerca').modal('show');
				}
			});
		}
	}
	
	$('#camporicerca').keypress(function (e) {
    if(e.which ==13)
        showModalRisultatiRicerca();
	});


</script>

