<? //PAGINA ADESIONE SOCIO ************************************************************************************************************************************



//se ISC_mostra_sociovolontario == 1 allora devo creare il modulo per chi non è socio

		$nome_socio = 				$nomepadre_fam;
		$cognome_socio = 			$cognomepadre_fam;
		$comunenascita_socio = 		$comunenascitapadre_fam;
		$provnascita_socio = 		$provnascitapadre_fam;
		$paesenascita_socio = 		$paesenascitapadre_fam;
		$cittadinanza_socio = 		$cittadinanzapadre_fam;
		$datanascita_socio = 		$datanascitapadre_fam;
		$comune_socio = 			$comunepadre_fam;
		$prov_socio = 				$provpadre_fam;
		$paese_socio = 				$paesepadre_fam;
		$CAP_socio = 				$CAPpadre_fam;
		$indirizzo_socio = 			$indirizzopadre_fam;
		$cf_socio	= 				$cfpadre_fam;
		$telefono_socio = 			$telefonopadre_fam;
		$email_socio = 				$emailpadre_fam;
		$professione_socio =		$profpadre_fam;



		if ($sociopadre_fam == 1 || $blank) {

			$volontario = 0;
			if ($codscuola =='AR') {
				include("AllegatoF_ModuloAdesioneSocio_AR.php");
			}
			if ($codscuola =='PD') {
				include("AllegatoF_ModuloAdesioneSocio_PD.php");
			}
			if ($codscuola =='TN') {
				include("AllegatoF_ModuloAdesioneSocio_TN.php");
			}
			if ($codscuola =='CI') {
				include("AllegatoF_ModuloAdesioneSocio_CI.php");
			}

		} else {
			$volontario = 1;
			if ($_SESSION['ISC_mostra_sociovolontario'] == 1) {
				if ($codscuola =='TN') {
					include("AllegatoF_ModuloAdesioneSocio_TN.php");
					//include("AllegatoF_ModuloAdesioneSocioVolontario_TN.php");
				}
			}
		}


		$nome_socio = 				$nomemadre_fam;
		$cognome_socio = 			$cognomemadre_fam;
		$comunenascita_socio = 		$comunenascitamadre_fam;
		$provnascita_socio = 		$provnascitamadre_fam;
		$paesenascita_socio = 		$paesenascitamadre_fam;
		$cittadinanza_socio = 		$cittadinanzamadre_fam;
		$datanascita_socio = 		$datanascitamadre_fam;
		$comune_socio = 			$comunemadre_fam;
		$prov_socio = 				$provmadre_fam;
		$paese_socio = 				$paesemadre_fam;
		$CAP_socio = 				$CAPmadre_fam;
		$indirizzo_socio = 			$indirizzomadre_fam;
		$cf_socio	= 				$cfmadre_fam;
		$telefono_socio = 			$telefonomadre_fam;
		$email_socio = 				$emailmadre_fam;
		$professione_socio =		$profmadre_fam;


		if ($sociomadre_fam == 1) {

			$volontario = 0;
			if ($codscuola =='AR') {
				include("AllegatoF_ModuloAdesioneSocio_AR.php");
			}
			if ($codscuola =='PD') {
				include("AllegatoF_ModuloAdesioneSocio_PD.php");
			}
			if ($codscuola =='TN') {
				include("AllegatoF_ModuloAdesioneSocio_TN.php");
			}
			if ($codscuola =='CI') {
				include("AllegatoF_ModuloAdesioneSocio_CI.php");
			}

		} else {

			$volontario = 1;
			if ($_SESSION['ISC_mostra_sociovolontario'] == 1) {
				if ($codscuola =='TN') {
					include("AllegatoF_ModuloAdesioneSocio_TN.php");
					//include("AllegatoF_ModuloAdesioneSocioVolontario_TN.php");
				}
			}
		}



?>