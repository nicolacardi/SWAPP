<?//Costruzione pagella ufficiale di tipo 8 (così codificata in database)
//Come la 3 ma senza comportamento e con riquadro in ultima pagina (come ce l'ha il template 4)
$tipodoc_mat = 8;

include ('12downloadEstrazioneDati.php');


//FRONTESPIZIO E QUARTA************************************************************************************************************************************

$pdf->AddPage("L", "A3");
$pdf->SetFont($fontdefault,'',5);
$pdf->Cell(-10,-10,$tipodoc_mat, 0,1, 'C');

$pdf->SetFillColor(200,200,200);
$titleSize =    16;
$yRectQuarta = 180;
$hRectQuarta = 105;
$colorsPag = explode (";", $_SESSION['colorsPag']); 
$R =           $colorsPag[0];
$G =           $colorsPag[1];
$B =           $colorsPag[2];
$mostraSez =     1;
$pdf->SetDrawColor($R,$G,$B);
$pdf->SetTextColor($R,$G,$B);
$coloreLogo = "Viola";
$titoloDoc = "Documento di Valutazione";
$sottoTitoloDoc = "";
// $pdf->SetDash(1,1); //5mm on, 5mm off
// $pdf->SetDash();

include("12stampasoloamministrativiA3.php");

include("12FrontespizioEQuarta.php");

include("12TimbrieFirmeQuarta.php");

include("12RilevazioneProgressi.php");


//FINE FRONTESPIZIO E QUARTA************************************************************************************************************************************
 
 
  //INIZIO SCRITTURA PAGELLA************************************************************************************************************************************
$pdf->AddPage("L", "A3");

include("12stampasoloamministrativiA3.php");
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,0,0);

include("12LogoAltoDxeSx.php");

if ($quadrimestre ==2) {
    $nquadrimestre = "SECONDO";
} else {
    $nquadrimestre = "PRIMO";
}

//Intestazioni Pagina di destra
// if ($pagprimotrim_cls == 1) {
    $x1 = 0;
    $pdf->SetXY (10+$x1,25);
    $pdf->SetFont($fontdefault,'',11);
    $pdf->Cell(190,10,utf8_decode("- ". $nome_alu." ".$cognome_alu." - a.s. ".$annoscolastico_cla. " -" ), '',1, 'C');
    $pdf->SetXY (10+$x1+210,25);
    $pdf->SetFont($fontdefault,'',11);
    $pdf->Cell(190,10,utf8_decode("- ". $nome_alu." ".$cognome_alu." - a.s. ".$annoscolastico_cla. " -" ), '',1, 'C');
    $pdf->SetFont($fontdefault,'',13);


    $x1 = 210;

    if ($aselme_cla == "EL") {
        $startY = 35;
    } else {
        $startY = 48;
    }
    $pdf->SetFont($fontdefault,'',13);
    $pdf->SetXY (10+$x1, $startY);
    $pdf->Cell(40,7,utf8_decode("Materia"), 0,0, 'C');
    $pdf->Cell(2,7,utf8_decode(""), 0,0, 'C');
    
    $pdf->Cell(110,7,utf8_decode($titoloPagColonnaVoti), 0,0, 'C');
    $pdf->Cell(2,7,utf8_decode(""), 0,0, 'C');
    $pdf->SetFont($fontdefault,'',11);
    $pdf->Cell(36,7,utf8_decode("Voto"), 0,0, 'C');
    // $pdf->SetXY (10+$x1+40+2+110+2, $startY + 5);
    // $pdf->Cell(36,7,utf8_decode("di Apprendimento"), 0,0, 'C');
// }
//Intestazioni Pagina di destra

$x1 = 0;
$pdf->SetFont($fontdefault,'',13);
$pdf->SetXY (10+$x1, $startY);


$pdf->Cell(40,7,utf8_decode("Materia"), 0,0, 'C');
$pdf->Cell(2,7,utf8_decode(""), 0,0, 'C');
$pdf->Cell(110,7,utf8_decode($titoloPagColonnaVoti), 0,0, 'C');
$pdf->Cell(2,7,utf8_decode(""), 0,0, 'C');
$pdf->SetFont($fontdefault,'',11);
$pdf->Cell(36,7,utf8_decode("Voto"), 0,0, 'C');
// $pdf->SetXY (10+$x1+40+2+110+2, $startY + 5);
// $pdf->Cell(36,7,utf8_decode("di Apprendimento"), 0,0, 'C');

$pdf->SetFont($fontdefault,'',14);

//Impostazioni altezza dei box

if ($aselme_cla == "EL") {
	$h1 = 26; //era 20: altezza del box in cui viene scritto il voto
    $rowh = 28;  //era 25: altezza della riga INCLUSA l'altezza h1
} else {
	$h1 = 23;
	$rowh = 25;
}




$y1 = 60;

$posxEL = array(1=>220, 2=>220, 3=>220, 4=>220, 5=>220, 6=>220, 7=>10, 8=>10, 9=>10, 10=>10, 11=>10, 12=>10);

$posyEL = array(1=>$y1, 2=>$y1+$rowh*1, 3=>$y1+$rowh*2, 4=>$y1+$rowh*3, 5=>$y1+$rowh*4, 6=>$y1+$rowh*5, 7=>$y1, 8=>$y1+$rowh*1, 9=>$y1+$rowh*2, 10=>160, 11=>160+$rowh*1, 12=>160+$rowh*2);

$y1 = 63;

$posxME = array(1=>220, 2=>220, 3=>220, 4=>220, 5=>220, 6=>220, 7=>220, 8=>10, 9=>10, 10=>10, 11=>10, 12=>10, 13=>10);

$posyME = array(1=>$y1, 2=>$y1+$rowh*1, 3=>$y1+$rowh*2, 4=>$y1+$rowh*3, 5=>$y1+$rowh*4, 6=>$y1+$rowh*5, 7=>$y1+$rowh*6, 8=>$y1, 9=>$y1+$rowh*1, 10=>$y1+$rowh*2, 11=>$y1+$rowh*3, 12=>$y1+$rowh*4, 13=>$y1+$rowh*5);


$x1 = 10;
$nmateria = 0;

//Scrittura dei voti
if ($aselme_cla == "EL") {
    $pdf->SetXY (220, 47);
    $pdf->Cell(190,10,utf8_decode("Area Linguistico Artistico Espressiva"),1,0, 'C',1);
    $pdf->SetXY (10, 47);
    $pdf->Cell(190,10,utf8_decode("Area Storico Geografica"),1,0, 'C',1);
    $pdf->SetXY (10, 147);
    $pdf->Cell(190,10,utf8_decode("Area Matematico Scientifico Tecnologica"),1,0, 'C',1);
}

//qui parte il loop di fetch sui voti estratti: la select si trova in 12downloadEstrazioneDati.php
while (mysqli_stmt_fetch($stmt)) {

    //QUESTO TEMPLATE NON PREVEDE IL COMPORTAMENTO
    // if ($descmateria_mat =="Comportamento") {
    //     $votcomportamento1 = $vot1_cla;
    //     $votcomportamento2 = $vot2_cla;
    //     $giucomportamento1 = $giu1_cla;
    //     $giucomportamento2 = $giu2_cla;

    //     if ($aselme_cla == "EL") {
    //         $startY = 232;
    //     } else {
    //         $startY = 245;
    //     }
    //     $pdf->SetXY (10+210, $startY);
    //     $pdf->Cell(40,10,utf8_decode("Comportamento"), 1,0, 'C');
    //     $pdf->Cell(2,10,"", 0,0, 'C');

    //     if ($quadrimestre ==2) {
    //         $pdf->Cell(110,10,utf8_decode(array_search($votcomportamento2, $votidesccomp)), 1,0, 'C');
    //     } else {
    //         $pdf->Cell(110,10,utf8_decode(array_search($votcomportamento1, $votidesccomp)), 1,0, 'C');
    //     }
    
    // } else {

        $nmateria++; //ad ogni giro aumento di uno la materia, che va a pescare le posizioni negli array posx-yEL e posx-yME


        switch ($aselme_cla) {
            case "AS" :
                //non possibile
                break;
            case "EL" :
                $x1 = $posxEL[$nmateria];
                $y1 = $posyEL[$nmateria];
                break;
            case "ME" :
                $x1 = $posxME[$nmateria];
                $y1 = $posyME[$nmateria];
                break;
            case "SU" :
                $x1 = $posxME[$nmateria];
                $y1 = $posyME[$nmateria];
                break;
        }


        $pdf->SetFont($fontdefault,'',11);
        if (strlen($descmateria_mat) > 22) { $pdf->SetFont($fontdefault,'',9);}
        $pdf->SetXY ($x1, $y1);
        $pdf->Cell(40,$h1,utf8_decode($descmateria_mat),1,0, 'C');                          //descrizione materia
        $pdf->Cell(2,$h1,utf8_decode(""), 0,0, 'C');                                        //spazio tra la materia e il giudizio
        $pdf->SetFont($fontdefault,'',9);
        $pdf->Cell(110,$h1,"", 1, 0, 'C');                                                  //rettangolo "bordo" del giudizio
        $pdf->SetXY ($pdf->GetX()-110, $y1+1);
        $pdf->SetFont($fontdefault,'',8);

        //bisogna fare lo stripslashes, tuttavia questo toglie anche gli a capo.
        //Per conservarli prima li sostituisco con @@, poi faccio lo stripslashes e poi ci rimetto l'a capo
        if ($quadrimestre == 1) {$pdf->MultiCell(110,3.5,utf8_decode(str_replace( "@@", "\n", stripslashes(str_replace("\\n", "@@",$giu1_cla)))), 0,'J');}     //testo del giudizio 1Q
        if ($quadrimestre == 2) {$pdf->MultiCell(110,3.5,utf8_decode(str_replace( "@@", "\n", stripslashes(str_replace("\\n", "@@",$giu2_cla)))), 0,'J');}     //testo del giudizio 2Q

        $pdf->SetFont($fontdefault,'',11);
        $pdf->SetXY ($x1+152, $y1);                                                         //riposizionamento per livello apprendimento
        $pdf->Cell(2,$h1,utf8_decode(""), 0,0, 'C');                                        //bordo del livello di apprendimento


        if ($quadrimestre == 1) {$pdf->Cell(36,$h1,utf8_decode(array_search($vot1_cla, $votidesc)), 1,0, 'C');} //Liv Apprendimento 1Q
        if ($quadrimestre == 2 && $votidoppiSecondoQuadrimestre == 0) {
            $pdf->Cell(36,$h1,utf8_decode(array_search($vot2_cla, $votidesc)), 1,0, 'C');
        }
        if ($quadrimestre == 2 && $votidoppiSecondoQuadrimestre == 1) {
            
            $pdf->SetTextColor(150, 150, 150);
            $pdf->SetFont($fontdefault,'',10);
            $pdf->Cell(36,$h1/4,utf8_decode("Primo Quadrimestre"), 1,0, 'C', 1);
            $pdf->SetXY ($x1+154, $y1+$h1/4);
            $pdf->SetFont($fontdefault,'',9);
            $pdf->Cell(36,$h1/4,utf8_decode(array_search($vot1_cla, $votidesc)), 1,0, 'C');
            $pdf->SetXY ($x1+154, $y1+$h1/2);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont($fontdefault,'',10);
            $pdf->Cell(36,$h1/4,utf8_decode("Finale"), 1,0, 'C', 1);
            $pdf->SetFont($fontdefault,'',11);
            $pdf->SetXY ($x1+154, $y1+3*$h1/4);
            $pdf->Cell(36,$h1/4,utf8_decode(array_search($vot2_cla, $votidesc)), 1,0, 'C'); //Liv Apprendimento 2Q
        }


        $pdf->SetFont($fontdefault,'',13);
    // }
}





?>