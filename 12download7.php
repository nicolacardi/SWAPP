<?//Costruzione Documento Interno di tipo 2 (così codificato in database)
//di solito usato con Pagella 1
$tipodoc_mat = 2;

include ('12downloadEstrazioneDati.php');


//FRONTESPIZIO E QUARTA************************************************************************************************************************************

$pdf->AddPage("L", "A3");



$pdf->SetFont($fontdefault,'',5);
$pdf->Cell(-10,-10,$tipodoc_mat, 0,1, 'C');



$pdf->SetFillColor(200,200,200);
$titleSize =    16;
$yRectQuarta =  180;
$hRectQuarta =  105;
$colorsPag = explode (";", $_SESSION['colorsPag']); 
$R =           $colorsPag[0];
$G =           $colorsPag[1];
$B =           $colorsPag[2];
$mostraSez =     1;
$pdf->SetDrawColor($R,$G,$B);
$pdf->SetTextColor($R,$G,$B);
$coloreLogo = "Viola";
$titoloDoc = "Profilo dello studente";
$sottoTitoloDoc = $sottoTitoloDocValutazione;
// $pdf->SetDash(1,1); //5mm on, 5mm off
// $pdf->SetDash();


include("12stampasoloamministrativiA3.php");

include("12FrontespizioEQuarta.php"); 

include("12TimbrieFirmeQuarta.php");

include("12RilevazioneProgressi.php");

//FINE FRONTESPIZIO E QUARTA************************************************************************************************************************************

  //INIZIO SCRITTURA DOCUMENTO INTERNO************************************************************************************************************************************
$pdf->AddPage("L", "A3");


$pdf->SetXY (10,265);
$pdf->SetFont($fontdefault,'',11);
$pdf->Cell(190,10,utf8_decode($footerpagella), 0,1, 'C');
$pdf->SetXY (220,265);
$pdf->SetFont($fontdefault,'',11);
$pdf->Cell(190,10,utf8_decode($footerpagella), 0,1, 'C');
$pdf->SetXY (0,0);

include("12stampasoloamministrativiA3.php");
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,0,0);

include("12LogoAltoDxeSx.php");


$w1 = 35;
$w2 = 1;
$w3 = 154;

if ($pagprimotrim_cls == 1) {
    $x1 = 0;
    $pdf->SetXY (10+$x1,30);
    $pdf->SetFont($fontdefault,'',16);
    $pdf->Cell(190,8,utf8_decode("- PRIMO QUADRIMESTRE -"), 0,1, 'C');
    $pdf->SetFont($fontdefault,'',13);
    $pdf->SetXY (10+$x1,38);
    $pdf->Cell(190,10,utf8_decode("(".$nome_alu." ".$cognome_alu." - a.s. ".$annoscolastico_cla.")"), 0,1, 'C');
    $pdf->SetXY (10+$x1,48);
    $pdf->Cell($w1,7,utf8_decode("Materia"), 0,0, 'C');
    $pdf->Cell($w2,7,utf8_decode(""), 0,0, 'C');
    $pdf->Cell($w3,7,utf8_decode("Giudizio"), 0,0, 'C');
}
$x1 = 210;
$pdf->SetXY (10+$x1,30);
$pdf->SetFont($fontdefault,'',16);
$pdf->Cell(190,8,utf8_decode("- SECONDO QUADRIMESTRE -"), 0,1, 'C');
$pdf->SetFont($fontdefault,'',13);
$pdf->SetXY (10+$x1,38);
if ($quadrimestre == 2)  {
	$pdf->Cell(190,10,utf8_decode("(".$nome_alu." ".$cognome_alu." - a.s. ".$annoscolastico_cla.")"), 0,1, 'C');
}
$pdf->SetXY (10+$x1,48);
$pdf->Cell($w1,7,utf8_decode("Materia"), 0,0, 'C');
$pdf->Cell($w2,7,utf8_decode(""), 0,0, 'C');
$pdf->Cell($w3,7,utf8_decode("Giudizio"), 0,0, 'C');


$pdf->SetFont($fontdefault,'',14);

$y1 = 55;
if ($aselme_cla == "EL") {
	$h1 = 20;
	$rowh = 25;
	$mcrowHOr = 5;
} else {
	$h1 = 15;
	$rowh = 16;
	$mcrowHOr = 4.7;
}



// function getRandomString($length = 500) {
//     $characters = '                    0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//     $string = '';
//     for ($i = 0; $i < $length; $i++) {
//         $string .= $characters[mt_rand(0, strlen($characters) - 1)];
//     }
//     return $string;
// }


while (mysqli_stmt_fetch($stmt)) {


    if ($pagprimotrim_cls == 1) {
        $x1 = 10;

        //Descrizione Materia
        $pdf->SetFont($fontdefault,'',12);
        $pdf->SetXY ($x1, $y1);
        $pdf->Cell($w1, $h1, "", 1, 0, 'C'); 
        $pdf->SetXY ($x1, $y1);

        $mcrowH = 7;  //interlinea multicell

        $pdf->MultiCell($w1,$mcrowH,utf8_decode($descmateria_mat),0,'C');


        //Giudizio
        $pdf->SetXY ($x1+$w1+$w2, $y1);
        $pdf->Cell($w3, $h1, "", 1, 0, 'C');    //faccio un rettangolo vuoto poi torno indietro e ci scrivo dentro in quanto uso multicell x scriverci
        $pdf->SetXY ($x1+$w1+$w2, $y1);


        switch ($aselme_cla) {
            case "AS" :
                //non possibile
                break;
            case "EL" :
                if (strlen($giu1_cla) > 248) { $pdf->SetFont($fontdefault,'',8); $mcrowH = 4;} else { $pdf->SetFont($fontdefault,'',10); $mcrowH = $mcrowHOr;}
                break;
            case "ME" :
                if (strlen($giu1_cla) > 248) { $pdf->SetFont($fontdefault,'',8); $mcrowH = 3.5;} else { $pdf->SetFont($fontdefault,'',10); $mcrowH = $mcrowHOr;}
                break;
            case "SU" :
                if (strlen($giu1_cla) > 248) { $pdf->SetFont($fontdefault,'',8); $mcrowH = 3.5;} else { $pdf->SetFont($fontdefault,'',10); $mcrowH = $mcrowHOr;}
                break;
        }





        // $rndstr = getRandomString();
        // if ($aselme_cla =="EL"){
        //     if (strlen($rndstr) > 248) { $pdf->SetFont($fontdefault,'',8); $mcrowH = 4;} else { $pdf->SetFont($fontdefault,'',10); $mcrowH = $mcrowHOr;}
        // }
        // if ($aselme_cla =="ME"){
        //     if (strlen($rndstr) > 248) { $pdf->SetFont($fontdefault,'',7.5); $mcrowH = 3.5;} else { $pdf->SetFont($fontdefault,'',10); $mcrowH = $mcrowHOr;}
        // }
        // $txt = $pdf->MultiCell($w3,$mcrowH,$rndstr, 0 , 'C', 0, 4);

        $txt = $pdf->MultiCell($w3,$mcrowH,utf8_decode(str_replace( "@@", "\n", stripslashes(str_replace("\\n", "@@", $giu1_cla)))), 0 , 'C', 0, 4);
        //footer con nome scuola (download7 viene usato da scuola ARCA)


    }
	
	//Pagina di destra
    $x1 = 220;
    
        //Descrizione Materia
        $pdf->SetFont($fontdefault,'',12);
        $pdf->SetXY ($x1, $y1);
        $pdf->Cell($w1, $h1, "", 1, 0, 'C'); 
        $pdf->SetXY ($x1, $y1);

        $mcrowH = 7;  //interlinea multicell

        $pdf->MultiCell($w1,$mcrowH,utf8_decode($descmateria_mat),0,'C');
    
    //Giudizio
	$pdf->SetXY ($x1+$w1+$w2, $y1);
	$pdf->Cell($w3, $h1, "", 1, 0, 'C');        //faccio un rettangolo vuoto poi torno indietro e ci scrivo dentro in quanto uso multicell x scriverci
	$pdf->SetXY ($x1+$w1+$w2, $y1);



    switch ($aselme_cla) {
        case "AS" :
            //non possibile
            break;
        case "EL" :
            if (strlen($giu2_cla) > 248) { $pdf->SetFont($fontdefault,'',8); $mcrowH = 4;} else { $pdf->SetFont($fontdefault,'',10); $mcrowH = $mcrowHOr;}
            break;
        case "ME" :
            if (strlen($giu2_cla) > 248) { $pdf->SetFont($fontdefault,'',8); $mcrowH = 3.5;} else { $pdf->SetFont($fontdefault,'',10); $mcrowH = $mcrowHOr;}
            break;
        case "SU" :
            if (strlen($giu2_cla) > 248) { $pdf->SetFont($fontdefault,'',8); $mcrowH = 3.5;} else { $pdf->SetFont($fontdefault,'',10); $mcrowH = $mcrowHOr;}
            break;
    }

	if ($quadrimestre == 2) {$txt = $pdf->MultiCell($w3,$mcrowH,utf8_decode(str_replace( "@@", "\n", stripslashes(str_replace("\\n", "@@", $giu2_cla)))),0, 'C', 0, 4);} else {	$txt = $pdf->MultiCell(125,$mcrowH,"",0, 'C', 0, 4);}
	
	$y1 = $y1 + $rowh;     

}






// ///Timbro Firme e tratteggi per firme Sinistra
// if ($pagprimotrim_cls == 1) {
//     $indicetimbro = rand(1,9);
//     $pdf->Image('assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png', (135), 250, 20);
//     $pdf->SetFont($fontdefault,'',12);
//     $pdf->SetXY (15,250);
//     $pdf->Cell(60,10,"Firma del genitore", 0 ,1, 'C');
//     $pdf->SetXY (15,255);
//     $pdf->SetFont($fontdefault,'',9);
//     $pdf->Cell(60,10,"(o di chi ne fa le veci)", 0 ,0, 'C');
//     $pdf->SetFont($fontdefault,'',12);
//     $pdf->SetXY (135,250);
//     $pdf->Cell(60,10,"Il Coordinatore Didattico", 0 ,1, 'C');
//     $indicefirma = rand(1,15);
//     $pdf->Image('assets/img/firmecoordinatori/firme'.$codscuola.'/CoordDidattico'.$aselme_cla.$indicefirma.'.png', (135), 255, 60);

//     $pdf->SetDash(1,1); //5mm on, 5mm off
//     $pdf->SetXY ((15),260);
//     $pdf->Cell(60,10,"", "B" ,0, 'C');
//     $pdf->SetXY ((135),260);
//     $pdf->Cell(60,10,"", "B" ,0, 'C');
//     $pdf->SetDash(); //Restore dash
//     $pdf->SetTextColor(0,0,0);
//     $pdf->SetDrawColor(0,0,0);
// }

// //Timbro Firme e tratteggi per firme Destra
// $y1 = 250;
// $indicetimbro = rand(1,9);
// if ($quadrimestre == 2) {
// 	$pdf->Image('assets/img/timbri/timbro'.$codscuola.'/timbro'.$indicetimbro.'.png', (135+210), $y1, 20);
// }
// $pdf->SetFont($fontdefault,'',12);
// $pdf->SetXY ((15+210),$y1);
// $pdf->Cell(60,10,"Firma del genitore", 0 ,0, 'C');
// $pdf->SetXY ((15+210),($y1+5));
// $pdf->SetFont($fontdefault,'',9);
// $pdf->Cell(60,10,"(o di chi ne fa le veci)", 0 ,0, 'C');
// $pdf->SetFont($fontdefault,'',12);
// $pdf->SetXY ((135+210),($y1+5));
// $pdf->Cell(60,10,"Il Coordinatore Didattico", 0 ,1, 'C');
// $indicefirma = rand(1,15);
// if ($quadrimestre == 2) {
// 	$pdf->Image('assets/img/firmecoordinatori/firme'.$codscuola.'/CoordDidattico'.$aselme_cla.$indicefirma.'.png', (135+210), ($y1+5), 60);
// }

// $pdf->SetDash(1,1); //5mm on, 5mm off
// $pdf->SetXY ((15+210),($y1+10));
// $pdf->Cell(60,10,"", "B" ,0, 'C');
// $pdf->SetXY ((135+210),($y1+10));
// $pdf->Cell(60,10,"", "B" ,0, 'C');
// $pdf->SetDash(); //Restore dash
// $pdf->SetTextColor(0,0,0);
// $pdf->SetDrawColor(0,0,0);




?>