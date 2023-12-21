<?//Costruzione pagella ufficiale di tipo 6 (così codificata in database)
//quella voluta da Verona e usata anche da Cittadella
$tipodoc_mat = 6;

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


//********************** Comportamento *************************************/
$pdf->SetXY (10,130);

$pdf->Cell(70,10,utf8_decode("Comportamento"), 1,0, 'C');
if ($quadrimestre ==1) {
    $vot_comportamento = $vot1_comportamento;
} else {
    $vot_comportamento = $vot2_comportamento;
}

$pdf->Cell(120,10,utf8_decode(array_search($vot_comportamento,$votidesccomp)), 1,0, 'C');



//FINE FRONTESPIZIO E QUARTA************************************************************************************************************************************
 
 
  //INIZIO SCRITTURA PAGELLA************************************************************************************************************************************
$pdf->AddPage("L", "A3");

include("12stampasoloamministrativiA3.php");
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,0,0);

include("12LogoAltoDxeSx.php");

//Header sx e dx Nome e cognome Alunno          ***********************

$x1 =   10;
$y1 =   15;

$pdf->SetXY ($x1,$y1);
$pdf->SetFont($fontdefault,'',11);
$pdf->Cell(190,10,utf8_decode("- ". $nome_alu." ".$cognome_alu." - a.s. ".$annoscolastico_cla. " -" ), '',1, 'C');

$pdf->SetXY (10+$x1+210,$y1);
$pdf->SetFont($fontdefault,'',11);
$pdf->Cell(190,10,utf8_decode("- ". $nome_alu." ".$cognome_alu." - a.s. ".$annoscolastico_cla. " -" ), '',1, 'C');
$pdf->SetFont($fontdefault,'',13);


//Intestazioni colonne sx e dx                 ***********************
$startY = 35;

$x1 = 10;

$h1 =   34;     //altezza del box in cui viene scritto il voto
$rowh = 36;     //altezza della riga INCLUSA l'altezza h1
$rowhOb = 10;
$y1 =   42;       //start Y
$w1 =   10; //Larghezza colonna Materie
$wGap =  2;
$hGap =  2;
$w2 =   68; //Larghezza colonna Obiettivi
$w3 =   26; //Larghezza colonna Voti Obiettivi /Livello Raggiunto
$w4 =   80; //Larghezza colonna Giudizio



$pdf->SetFont($fontdefault,'',11);
$pdf->SetXY ($x1 +$w1 + $wGap, $startY);
$pdf->Cell  ($w2,7,utf8_decode("Obiettivi di Apprendimento"), 0,0, 'C');
$pdf->SetFont($fontdefault,'',10);
$pdf->SetXY ($x1 + $w1 + $wGap + $w2 + $wGap, $startY);
$pdf->Cell  ($w3,7,utf8_decode("Livello raggiunto *"), 0,0, 'C');
$pdf->SetFont($fontdefault,'',11);
$pdf->SetXY ($x1 + $w1 + $wGap + $w2 + $wGap + $w3 + $wGap, $startY);
$pdf->Cell  ($w4,7,utf8_decode($titoloPagColonnaVoti), 0,0, 'C');

$x1 = 220;
$pdf->SetFont($fontdefault,'',11);
$pdf->SetXY ($x1 +$w1 + $wGap, $startY);
$pdf->Cell  ($w2,7,utf8_decode("Obiettivi di Apprendimento"), 0,0, 'C');
$pdf->SetFont($fontdefault,'',10);
$pdf->SetXY ($x1 + $w1 + $wGap + $w2 + $wGap, $startY);
$pdf->Cell  ($w3,7,utf8_decode("Livello raggiunto *"), 0,0, 'C');
$pdf->SetFont($fontdefault,'',11);
$pdf->SetXY ($x1 + $w1 + $wGap + $w2 + $wGap + $w3 + $wGap, $startY);
$pdf->Cell  ($w4,7,utf8_decode($titoloPagColonnaVoti), 0,0, 'C');




$pdf->SetFont($fontdefault,'',14);

//Impostazioni altezza dei box


$posxEL = array(1=>10, 2=>10, 3=>10, 4=>10, 5=>10, 6=>10,
                7=>220, 8=>220, 9=>220, 10=>220, 11=>220, 12=>220);

$posyEL = array(1=>$y1, 2=>$y1+$rowh*1, 3=>$y1+$rowh*2, 4=>$y1+$rowh*3, 5=>$y1+$rowh*4, 6=>$y1+$rowh*5, 
                7=>$y1, 8=>$y1+$rowh*1, 9=>$y1+$rowh*2, 10=>$y1+$rowh*3, 11=>$y1+$rowh*4, 12=>$y1+$rowh*5);

$nmateria = 0;

while (mysqli_stmt_fetch($stmt)) {
    if ($codmat_mat != 'COM') {

        $nmateria++;

        $x1 = $posxEL[$nmateria];
        $y1 = $posyEL[$nmateria];

        //Materia
        $pdf->SetFont($fontdefault,'',11);
        $pdf->SetXY ($x1, $y1);
        $pdf->Rect($x1,$y1, $w1 ,$h1);
        $pdf->RotatedText($x1 + $w1 - 3,$y1 + $h1 - 3,$descmateria_mat,90);
        
        //Obiettivi di Apprendimento
        $pdf->SetFont($fontdefault,'',8);
        $pdf->SetXY ($x1 + $w1 + $wGap, $y1);
        for ($j = 1; $j <= $n_obiettivi; $j++) {
            $pdf->SetXY ($x1 + $w1 + $wGap, $y1 + ($j-1)*$rowhOb + ($j-1)*$hGap);
            $pdf->MultiCell($w2,3.3,utf8_decode(str_replace( "@@", "\n", stripslashes(str_replace("\\n", "@@",$descObA [$ID_mat][$j])))), 0,'J');
            $pdf->Rect($x1 + $w1 + $wGap, $y1 + ($j-1)*$rowhOb + ($j-1)*$hGap, $w2 ,$rowhOb);
        }    

        //Livelli
        $pdf->SetXY ($x1 + $w1 + $wGap +$w2 +$wGap, $y1);

        for ($j = 1; $j <= $n_obiettivi; $j++) {
            $pdf->SetXY ($x1 + $w1 + $wGap +$w2 +$wGap, $y1 + ($j-1)*$rowhOb + ($j-1)*$hGap);
            if ($quadrimestre == 1) {$pdf->Cell($w3,$rowhOb,utf8_decode($vot1ObA[$ID_mat][$j]), 1,0, 'C');}
            if ($quadrimestre == 2) {$pdf->Cell($w3,$rowhOb,utf8_decode($vot2ObA[$ID_mat][$j]), 1,0, 'C');}
            // $pdf->MultiCell($w2,3.4,utf8_decode(str_replace( "@@", "\n", stripslashes(str_replace("\\n", "@@",$vot1ObA [$ID_mat][$j])))), 0,'J');
            // $pdf->Rect($x1 + $w1 + $wGap +$w2 +$wGap, $y1 + ($j-1)*$rowhOb + ($j-1)*$hGap, $w3 ,$rowhOb);
        }


        //Giudizio Descrittivo
        $pdf->SetXY ($x1 + $w1 + $wGap + $w2 + $wGap + $w3 + $wGap, $y1);
        $pdf->Cell($w4,$h1,"", 1, 0, 'C');                                                  //rettangolo "bordo" del giudizio
        $pdf->SetXY ($pdf->GetX()-$w4, $y1);                                                //torno indietro per scrivere il giudizio
        $pdf->SetFont($fontdefault,'',9);

        //bisogna fare lo stripslashes, tuttavia questo toglie anche gli a capo.
        //Per conservarli prima li sostituisco con @@, poi faccio lo stripslashes e poi ci rimetto l'a capo
        if ($quadrimestre == 1) {$pdf->MultiCell($w4,3.4,utf8_decode(str_replace( "@@", "\n", stripslashes(str_replace("\\n", "@@",$giu1_cla)))), 0,'J');}     //testo del giudizio 1Q
        if ($quadrimestre == 2) {$pdf->MultiCell($w4,3.4,utf8_decode(str_replace( "@@", "\n", stripslashes(str_replace("\\n", "@@",$giu2_cla)))), 0,'J');}     //testo del giudizio 2Q


    }
}

include("12LegendaObiettivi.php");
?>