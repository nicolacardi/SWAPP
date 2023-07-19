<?
//PAGINA DI SINISTRA - QUARTA DI COPERTINA

//Intestazione Scuola pagina di sinistra
include("12intestazionescuolaA3.php");

//Rettangolo grande
$pdf->Rect(10,$yRectQuarta,190,$hRectQuarta);

//PAGINA DI DESTRA - PRIMA DI COPERTINA
//Rettangolo grande
$pdf->Rect(220,10,190,275);

//Logo
$width =  75;
$positionX= 210 / 2 - ($width/2)+210;
$positionY =  25;
$pdf->Image('assets/img/logo/logo'.$codscuola.'/logodef'.$coloreLogo.'.png',$positionX,$positionY, $width);

//Titoli
$pdf->SetFont('TitilliumWeb-SemiBold','',$titleSize);
$pdf->SetXY (210,90);
if ($quadrimestre ==2) {
    $pdf->Cell(210,10,utf8_decode($titoloDoc), 0,1, 'C');
} else {
    $pdf->Cell(210,10,utf8_decode($titoloDoc. " - Primo Quadrimestre"), 0,1, 'C');
}

$pdf->SetFont('TitilliumWeb-SemiBold','',$titleSize);
$pdf->SetX (210);
$pdf->Cell(210,10,utf8_decode($sottoTitoloDoc), 0,1, 'C');
$pdf->SetFont($fontdefault,'',$titleSize);
$pdf->SetX (210);
$pdf->Cell(210,10,"Anno scolastico: ".$annoscolastico_cla, 0,1, 'C');
// $pdf->SetX (210);
// $pdf->Cell(210,10,"", 0,1, 'C');
$pdf->SetX (210);
$pdf->SetFont($fontdefault,'',12);

$pdf->Cell(210,10,"Alunn".$finmin, 0,1, 'C');
$pdf->SetX (210);
$pdf->SetFont('TitilliumWeb-SemiBold','',$titleSize);
$pdf->Cell(210,10,utf8_decode($nome_alu." ".$cognome_alu), 0,1, 'C');
$pdf->SetFont($fontdefault,'',12);
$pdf->SetX (210);
$pdf->Cell(210,7,"C.F. ".$cf_alu, 0,1, 'C');
$pdf->SetX (210);
if ($provnascita_alu !="") { $comunenascita_alu = $comunenascita_alu ." (".$provnascita_alu.")";}
$pdf->Cell(210,7,"Nat".$finmin." a ".utf8_decode($comunenascita_alu)." il ".timestamp_to_ggmmaaaa($datanascita_alu), 0,1, 'C');
$pdf->SetX (210);
$pdf->SetFont('TitilliumWeb-SemiBold','',$titleSize);
if ($mostraSez) {
    $pdf->Cell(210,7,"Classe ".$desc2_cls." Sez. ".$sezione_cla, 0,1, 'C');
} else {
    $pdf->Cell(210,7,"Classe ".$desc2_cls, 0,1, 'C');
}
$pdf->SetFont($fontdefault,'',12);

switch ($aselme_cla) {
	case "AS" :
		//non possibile
		break;
	case "EL" :
		$tiposcuola = '- Scuola Primaria -';
		break;
	case "ME" :
		$tiposcuola = '- Scuola Secondaria di primo grado -';
		break;
	case "SU" :
		$tiposcuola = '- Scuola Secondaria di secondo grado -';
		break;
}

$pdf->SetX (210);
$pdf->Cell(210,14,$tiposcuola, 0,1, 'C');

if ($quadrimestre == 2) {
    //$pdf->Rect(230,185,170,45);
    $pdf->SetX (250);
    $pdf->SetFont('TitilliumWeb-SemiBold','',$titleSize);

    if  ($attestazioneAmmissione) {


        $pdf->Cell(130,10,'ATTESTAZIONE', "B",1, 'C');
        $pdf->SetFont($fontdefault,'',12);
        $pdf->SetX (210);
        $pdf->Cell(210,6,utf8_decode("Accertato che l'alunn".$finmin." ai fini della validità dell'anno scolastico (art 2, 2. 10 DPR 122/2009)"), 0,1, 'C');
        $pdf->SetX (210);
        $pdf->Cell(210,6,utf8_decode("con ".($ggassenza2_cla)." giorni di assenza"), 0,1, 'C');
        if ($hafreq_cla == 1) {
            $hafreqphrase = "ha frequentato le lezioni e le attività didattiche per almeno i 3/4 dell'orario annuale";
        } else {
            $hafreqphrase = "non ha frequentato le lezioni e le attività didattiche per almeno i 3/4 dell'orario annuale";
        }
        //COVID
        $pdf->SetX (210);
        $pdf->Cell(210,6,utf8_decode($hafreqphrase), 0,1, 'C');
        //COVID
        $pdf->SetX (210);

        $pdf->Cell(210,6,utf8_decode("visti gli atti d'ufficio e la valutazione dei docenti della classe si attesta che"), 0,1, 'C');

        //COVID
        //$ammesso_cla=1; //COVID!


        if ($ammesso_cla == 1) {
            if ($_SESSION['stampa_voti_ammissione_VIII'] == 1) {$convoto = "con votazione ".$votofinale_cla." decimi";} else {$convoto = "";}
            $ammessophrase = "l'alunn".$finmin." è risultat".$finmin." AMMESS".$finMAI." alla classe successiva";
            if ($classe_cla == "V") {$ammessophrase = "l'alunn".$finmin." è risultat".$finmin." AMMESS".$finMAI." al successivo grado di istruzione";}
            if ($classe_cla == "VIII") {$ammessophrase = "l'alunn".$finmin." è risultat".$finmin." AMMESS".$finMAI." a sostenere l'esame di Stato ".$convoto;}
        } else {
            $ammessophrase = "l'alunn".$finmin." è risultat".$finmin." NON AMMESS".$finMAI." alla classe successiva";
            if ($classe_cla == "V") {$ammessophrase = "l'alunn".$finmin." è risultat".$finmin." NON AMMESS".$finMAI." al successivo grado di istruzione";}
            if ($classe_cla == "VIII") {$ammessophrase = "l'alunn".$finmin." è risultato NON AMMESS".$finMAI." a sostenere l'esame di Stato";}
        }
        $pdf->SetX (210);
        $pdf->Cell(210,10,utf8_decode($ammessophrase), 0,1, 'C');
    } else {
        $pdf->Cell(130,10,'', "B",1, 'C');
        $pdf->SetFont($fontdefault,'',12);
        $pdf->SetX (210);
        $pdf->Cell(210,6,utf8_decode("Si attesta che l'alunn".$finmin.", con ".($ggassenza2_cla)." giorni di assenza,"), 0,1, 'C');
        if ($hafreq_cla == 1) {
            $hafreqphrase = "ha frequentato le lezioni e le attività didattiche per almeno i 3/4 dell'orario annuale";
        } else {
            $hafreqphrase = "non ha frequentato le lezioni e le attività didattiche per almeno i 3/4 dell'orario annuale";
        }
        $pdf->SetX (210);
        $pdf->Cell(210,6,utf8_decode($hafreqphrase), 0,1, 'C');
        $pdf->SetX (210);
    }

}




//Timbro Firme e tratteggi per firme
$indicetimbro = rand(1,9);
$pdf->Image('assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png', (135+210), 230, 20);
$pdf->SetFont($fontdefault,'',12);
$pdf->SetXY ((15+210),230);
$pdf->Cell(60,10,"Data e Luogo", 0 ,0, 'C');
$pdf->SetXY ((135+210),230);
$pdf->Cell(60,10,"Il Coordinatore Didattico", 0 ,1, 'C');
$indicefirma = rand(1,15);
$pdf->Image('assets/img/firmecoordinatori/firme'.$codscuola.'/CoordDidattico'.$aselme_cla.$indicefirma.'.png', (135+210), 235, 60);

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->SetXY ((15+210),240);
if ($quadrimestre == 2) {
    $pdf->Cell(60,10,"        ".$citta.", ".timestamp_to_ggmmaaaa($datapagella2_cla), "B" ,0, 'L');
} else {
    $pdf->Cell(60,10,"        ".$citta.", ".timestamp_to_ggmmaaaa($datapagella1_cla), "B" ,0, 'L');
}
//$pdf->Cell(60,10,"", "B" ,0, 'C');
$pdf->SetXY ((135+210),240);
$pdf->Cell(60,10,"", "B" ,0, 'C');
$pdf->SetDash(); //Restore dash

if ($_SESSION['mostra_logo_federazione'] == 1) {
    $width = 60;
    $positionX= 210 / 2 - ($width/2)+210;
    $positionY =  253;
    // if ($pagprimotrim_cls == 1) {
    $pdf->Image('assets/img/logo/logo'.$codscuola.'/logofederazione.png',$positionX,$positionY, $width);
}

//FINE FRONTESPIZIO************************************************************************************************************************************
?>